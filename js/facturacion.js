let inputFiltro = document.querySelector("#filtro-fecha");
let selectorFecha = {};
const listaFacturacion = document.getElementById('lista-facturacion');

let selectorFactura = {};

inputFiltro.addEventListener('change', function(){
	let fecha = this.value;
	var xmlhttp = new XMLHttpRequest();
	let queryString = "buscar="+JSON.stringify(fecha);
	xmlhttp.open("POST", "php/buscaFecha.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(queryString);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
			if (xmlhttp.status == 200) {
				selectorFecha=JSON.parse(xmlhttp.response);
				muestraLista(selectorFecha);
			}
		}
	}
});

function muestraLista(selector){
	let output = "";
	for (let i=0; i<selector.length; i++) {
		output += "<div class='factura-resultado'><span class='fecha-resultado'>"+selector[i].fecha+"</span></div>";
	}
	listaFacturacion.innerHTML=output;

	let facturaResultado = document.querySelectorAll(".factura-resultado");
	for (let i=0; i<facturaResultado.length; i++) {
		facturaResultado[i].addEventListener('click', function(){
			document.querySelector("#cajero").innerHTML=(selectorFecha[i].cajero.nombre?selectorFecha[i].cajero.nombre:"");
			document.querySelector("#clockArea").innerHTML=selectorFecha[i].fecha;
			document.getElementById("info-cliente").innerHTML="<div>Cliente: "+(selectorFecha[i].cliente.nombre?selectorFecha[i].cliente.nombre:"")+"</div><div>Cliente Nit.: "+(selectorFecha[i].cliente.nit?selectorFecha[i].cliente.nit:"")+"</div>";
			muestraFactura(selectorFecha[i].venta);
			selectorFactura=selectorFecha[i];
			muestraGarantia(selectorFecha[i].garantia);
			muestraPanel("rud");
		});
	}
}

function cargaFactura(selector){
	var xmlhttp = new XMLHttpRequest();
	let queryString = "buscar="+JSON.stringify(selector);
	xmlhttp.open("POST", "php/buscaFactura.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(queryString);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
			if (xmlhttp.status == 200) {
				selectorFactura=JSON.parse(xmlhttp.response);
				muestraFactura(selectorFactura.venta);
				muestraGarantia(selectorFactura.garantia);
				muestraPanel("rud");
			}
		}
	}
}

let cuerpoFactura = document.querySelector("#cuerpo-factura");
function muestraFactura(selector){
	let output="";
	let total=0;
	for (let i=0; i<selector.length; i++) {
		output+="<tr>";
		output+="<td class='numerador'>"+(i+1)+"</td>";
		output+="<td>"+selector[i].nombre.articulo+"</td>";

		output+="<td>"+selector[i].cantidad+"</td>";
		output+="<td><input type='number' onkeyup='revisaAnulado("+i+", this)' onchange='revisaAnulado("+i+", this)' class='cantidad-item' value='"+selector[i].anulado+"' min='0'></td>";
		output+="<td class='valor'>$ "+Intl.NumberFormat('es-CO').format(selector[i].valor)+"</td>";
		output+="<td class='subtotal'>$ "+Intl.NumberFormat('es-CO').format((selector[i].cantidad-selector[i].anulado)*selector[i].valor)+"</td>";
		output+="</tr>";
		total+=(selector[i].cantidad-selector[i].anulado)*selector[i].valor;
	}
	cuerpoFactura.innerHTML=output;
	document.getElementById("total").innerHTML="$ "+Intl.NumberFormat('es-CO').format(total);
}

function revisaAnulado(count, input){
	let entero = parseInt(input.value);
	if (isNaN(entero) || entero<0) {
		entero=0;
	}
	input.value=entero;
	input.setAttribute("value", entero);
	
	let max=selectorFactura.venta[count].cantidad;
	let msg = "";
	if (max==1) {
		msg = "Solo puede anular "+max+" unidad";
	}
	if (max>=2) {
		msg = "Solo puede anular "+max+" unidades";
	}
	msg+=" de este articulo";
	if (entero>max) {
		input.value=max;
		selectorFactura.venta[count].anulado=max;
		input.classList.add("campoVacio");
		barraEstado(msg);
		setInterval(function(){
			input.classList.remove("campoVacio");
		},1400);
	}else{
		selectorFactura.venta[count].anulado=parseInt(input.value);
		let subtotal = (selectorFactura.venta[count].cantidad-selectorFactura.venta[count].anulado)*selectorFactura.venta[count].valor;
		let fila = document.querySelectorAll('#cuerpo-factura > tr');
		let labelSubtotal=fila[count].querySelector(".subtotal");
		labelSubtotal.innerHTML="$ "+Intl.NumberFormat('es-CO').format(subtotal)
		let total = 0;
		for (let i=0; i<selectorFactura.venta.length; i++) {
			total+=(selectorFactura.venta[i].cantidad-selectorFactura.venta[i].anulado)*selectorFactura.venta[i].valor;
		}
		document.getElementById("total").innerHTML="$ "+Intl.NumberFormat('es-CO').format(total);
	}
}

let displayGarantia = document.querySelector("#garantia");
function muestraGarantia(selector){
	if (selector.length<=0) {
		displayGarantia.innerHTML="No hay garantias registradas para esta factura.";
	}else{
		displayGarantia.innerHTML="";
		let output="";
		for (var j = 0; j < selector.length; j++) {
			output+="<div class='garantia'>";
			output+="<span>Garantia iniciada el: "+selector[j].fecha_inicio+"</span>";
			output+="<span>"+selector[j].estado+"</span>";
			output+="<textarea placeholder='Detalles de la garantia' "+(selector[j].estado=="Cerrada"?"readonly":"")+">"+selector[j].detalle+"</textarea>";
			if (selector[j].estado!="Cerrada") {
				output+="<button onclick='cierraGarantia("+[j]+")'>Cerrar</button>";
				output+="<button onclick='eliminaGarantia("+[j]+")'>Eliminar</button>";
			}
			output+="</div>";
		}
		displayGarantia.innerHTML=output;
		let inputDetalle = document.querySelectorAll("textarea");
		for (var k = 0; k < inputDetalle.length; k++) {
			inputDetalle[k].addEventListener("keyup", function(){
				selectorFactura.garantia[(k-1)].detalle = this.value;
			});
		}
	}
}

let barra = document.querySelector("#barra-estado");
function barraEstado(msg){
	barra.innerHTML="<span>"+msg+"</span>";
	barra.querySelector("span").classList.add("fundido");
	let elemento = document.querySelectorAll(".fundido");
	setInterval(function(){
		for (let i = 0; i < elemento.length; i++) {
			elemento[i].classList.remove("fundido");
			elemento[i].remove();
		}
	},4000);
}

function muestraPanel(modo){
	crud = document.getElementById("opciones");
	switch (modo) {
		case "rud":
		crud.innerHTML = "<button onclick='actualiza()'>Actualizar factura</button>";
		crud.innerHTML+= "<button onclick='garantia()'>Añadir garantia</button>";
		crud.innerHTML+= "<button id='imprime-factura'>Imprimir</button>";
		crud.innerHTML+= "<button onclick='recarga()'>Cancelar</button>";
		break;
		default:
		crud.innerHTML = "";
		break;
	}
}

function actualiza(){
	let confirma=confirm("¿Continuar y guardar cambios?");
	if (confirma) {
		var xmlhttp = new XMLHttpRequest();
		let	queryString = "actualiza="+JSON.stringify(selectorFactura);
		xmlhttp.open("POST", "php/actualizaFactura.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(queryString);
		barraEstado("Cambios almacenados");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
				if (xmlhttp.status == 200) {
					cargaFactura(selectorFactura.id);
				}
			}
		}
	}
}  

function garantia(){
	let confirma=confirm("¿Continuar y añadir garantia?");
	if (confirma) {
		var xmlhttp = new XMLHttpRequest();
		let	queryString = "garantia="+JSON.stringify(selectorFactura.id);
		xmlhttp.open("POST", "php/agregaGarantia.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(queryString);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
				if (xmlhttp.status == 200) {
					cargaFactura(selectorFactura.id);
				}
			}
		}
	}
}

function cierraGarantia(id){
	let inputDetalle = document.querySelectorAll("textarea");
	let confirma=confirm("¿Continuar y añadir garantia?");
	if (confirma) {
		var xmlhttp = new XMLHttpRequest();
		let	queryString = "garantia="+JSON.stringify(selectorFactura.garantia[id].id);
		queryString += "&detalle="+JSON.stringify(inputDetalle[id].value);
		xmlhttp.open("POST", "php/cierraGarantia.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(queryString);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
				if (xmlhttp.status == 200) {
					cargaFactura(selectorFactura.id);
					console.log(xmlhttp.response);
				}
			}
		}
	}
}

function eliminaGarantia(id){
	let confirma=confirm("¿Continuar y eliminar garantia?");
	if (confirma) {
		var xmlhttp = new XMLHttpRequest();
		let	queryString = "garantia="+JSON.stringify(selectorFactura.garantia[id].id);
		xmlhttp.open("POST", "php/eliminaGarantia.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(queryString);

		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
				if (xmlhttp.status == 200) {
					cargaFactura(selectorFactura.id);
				}
			}
		}
	}
}    

function recarga(){
	location.replace(`facturacion.php`);
}