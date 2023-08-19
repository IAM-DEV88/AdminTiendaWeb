const inputArticulo = document.getElementById('input-articulo');
const listaArticulo = document.getElementById('lista-articulo');
const inputCantidad = document.getElementById("input-cantidad");
const agregaArticulo = document.getElementById('agrega-articulo');

const inputTitular = document.getElementById('input-titular');
const listaTitular = document.getElementById('lista-titular');

const pagoVenta = document.getElementById('pago-venta');

const concretaVenta = document.getElementById('concreta-venta');
const vaciaFactura = document.getElementById('vacia-factura');

// document.addEventListener('keydown', (event) => {
// 	console.log(event.code);
// 	if (event.code=="ControlRight") {
// 		inputArticulo.focus();
// 	}
// 	if (event.code=="ControlLeft") {
// 		inputArticulo.select();
// 	}
// }, false);

let selectorArticulo={};
inputArticulo.addEventListener('keyup', function(){
	let articulo = this.value;
	listaArticulo.style.display = "initial";
	var xmlhttp = new XMLHttpRequest();
	let queryString = "buscar="+JSON.stringify(articulo);
	xmlhttp.open("POST", "php/buscaArticulo.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(queryString);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
			if (xmlhttp.status == 200) {
				selectorArticulo=JSON.parse(xmlhttp.response);
				selectorArticulo.filtro=articulo;
				muestraLista(selectorArticulo, "inventario");
			}
		}
	};
});

inputArticulo.addEventListener('focusout', function(){
	setTimeout(function(){listaArticulo.style.display = "none";}, 200)
});

function muestraLista(selector, tipo){
	let output = "";
	if (!selector.length) {
		output += "<div class='sin-resultados'>";
		output += "<div class='contenedor-datos'>";
		output += "Ninguna coincidencia para '"+selector.filtro+"', ¿desea <a href='"+tipo+".php?nuevo="+selector.filtro+"'>crear nuevo "+tipo+"</a>&nbsp;con esta informacion?";
		output += "</div>";
	} 
	switch (tipo) {
		case "inventario":
		for (let i=0; i<selector.length; i++) {
			output += "<div class='articulo-resultado'>";
			output += "<div class='contenedor-datos'>";
			output += "<div class='articulo-nombre'>"+selector[i].articulo+"</div>";
			output += "<div class='dato-corto'>Disponible: <span class='articulo-disponible'>"+selector[i].disponible+"</span></div>";
			output += "<div class='dato-corto'>Valor: <span class='articulo-valor'>$ "+selector[i].valor+"</span></div>";
			output += "</div></div>";
		}
		listaArticulo.innerHTML=output;
		let busquedaArticulo = document.querySelectorAll('.articulo-resultado');
		for (let i = 0; i < busquedaArticulo.length; i++) {
			busquedaArticulo[i].addEventListener("click", function() {
				inputArticulo.value=selector[i].articulo;
				inputCantidad.value=(selector[i].disponible<=0?0:1);
				inputCantidad.setAttribute("value", (selector[i].disponible<=0?0:1));
				selectorArticulo=selector[i];
			});
		}
		break;
		case "cliente":
		for (let i=0; i<selector.length; i++) {
			output += "<div class='cliente-resultado'>";
			output += "<div class='contenedor-datos'>";
			output += "<div class='cliente-nombre'>"+selector[i].nombre+"</div>";
			output += "<div class='cliente-direccion'>"+selector[i].direccion+"</div>";
			output += "<div class='cliente-telefono'>"+selector[i].telefono+"</div>";
			output += "<div class='cliente-correo'>"+selector[i].correo+"</div>";
			output += "</div></div>";
		}
		listaTitular.innerHTML=output;
		let busquedaTitular = document.querySelectorAll('.cliente-resultado');
		for (let i = 0; i < busquedaTitular.length; i++) {
			busquedaTitular[i].addEventListener("click", function() {
				inputTitular.value=selector[i].nombre;
				document.getElementById("info-cliente").innerHTML="<div>Cliente: "+selector[i].nombre+"</div><div>Cliente Nit.: "+selector[i].nit+"</div>";
				selectorTitular=selector[i];
			});
		}
		break;
		default:
		break;
	}
}

function revisaDisponible(elem, input){
	let entero = parseInt(input.value);
	if (isNaN(entero) || entero==0) {
		entero=1;
	}
	input.value=entero;
	input.setAttribute("value", entero);
	let max=0;
	if (elem==null) {
		max=selectorArticulo.disponible;
	}else{
		max=factura[elem].disponible;
		factura[elem].cantidad=entero;
	}
	let msg = "";
	if (max==1) {
		msg = "Solo hay "+max+" unidad disponible";
	}
	if (max<1) {
		msg = "No hay unidades disponibles";
	}
	if (max>=2) {
		msg = "Solo hay "+max+" unidades disponibles";
	}
	msg+=" de este articulo";
	if (entero>=max) {
		input.value=max;
		if (elem==null) {
			selectorArticulo.cantidad=max;
		}else{
			factura[elem].cantidad=max;
		}
		input.classList.add("campoVacio");
		barraEstado(msg);
		setInterval(function(){
			input.classList.remove("campoVacio");
		},1400);
	}
	if (elem==null) {
	}else{
		let subtotal = factura[elem].cantidad*factura[elem].valor;
		factura[elem].subtotal=subtotal;
		let fila = document.querySelectorAll('#cinta-factura tbody > tr');
		let labelSubtotal=fila[elem].querySelector(".subtotal");
		labelSubtotal.innerHTML="$ "+Intl.NumberFormat('es-CO').format(subtotal)
		actualizaTotales();
	}
}

let selectorTitular={};
inputTitular.addEventListener('keyup', function(){
	let cliente = this.value;
	listaTitular.style.display = "initial";
	var xmlhttp = new XMLHttpRequest();
	let queryString = "buscar="+JSON.stringify(cliente);
	xmlhttp.open("POST", "php/buscaTitular.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(queryString);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
			if (xmlhttp.status == 200) {
				selectorTitular=JSON.parse(xmlhttp.response);
				selectorTitular.filtro=cliente;
				muestraLista(selectorTitular, "cliente");
			}
		}
	};
});

inputTitular.addEventListener('focusout', function(){
	setTimeout(function(){listaTitular.style.display = "none";}, 200)
});

function reset(tipo){
	switch (tipo) {
		case "articulo":
		selectorArticulo={};
		inputCantidad.value="";
		inputArticulo.value="";
		break;
		case "titular":
		selectorTitular={};
		inputTitular.value="";
		document.getElementById("info-cliente").innerHTML="";
		break;
		default:
		break;
	}
}

function mostrarFechaReloj(){
	var d = new Date();
	var hoy = new Date();
	var now = hoy.toLocaleDateString();
	document.getElementById("hoy").innerHTML=now;
	document.getElementById("hr").innerHTML=d.getHours()+":";
	document.getElementById("min").innerHTML=d.getMinutes()+":";
	document.getElementById("secs").innerHTML=d.getSeconds();
}
window.load = mostrarFechaReloj();
setInterval(function(){
	mostrarFechaReloj();
},1000);

let factura = [];
agregaArticulo.addEventListener('click', function(){
	let nuevo = {};
	if (selectorArticulo.id) {
		nuevo = selectorArticulo;
		nuevo.cantidad=parseInt(inputCantidad.value);
		let msg = "";
		if (nuevo.disponible==1) {
			msg = "Solo hay 1 unidad disponible";
		}
		if (nuevo.disponible<1) {
			msg = "No hay unidades disponibles";
		}
		if (nuevo.disponible>=2) {
			msg = "Solo hay "+nuevo.disponible+" unidades disponibles";
		}
		msg+=" de este articulo";
		if (nuevo.disponible>0) {
			if (!factura.length) {
				factura.push(nuevo);
			}else{
				let existe=false;
				for (let i=0; i<factura.length; i++) {
					if (factura[i].id==nuevo.id) {
						if (factura[i].cantidad+nuevo.cantidad>=factura[i].disponible) {
							factura[i].cantidad=factura[i].disponible;
							inputCantidad.classList.add("campoVacio");
							setInterval(function(){
								inputCantidad.classList.remove("campoVacio");
							},1400);
							barraEstado(msg);
						}else{
							factura[i].cantidad+=nuevo.cantidad;
						}
						existe=true;
					}
				}
				if (existe==false) {
					factura.push(nuevo);
				}
			}
			muestraFila();
		}else{
			inputCantidad.classList.add("campoVacio");
			setInterval(function(){
				inputCantidad.classList.remove("campoVacio");
			},1400);
			barraEstado(msg);
		}
	}else{
		barraEstado("Seleccione un articulo");
	}
});

let cintaFactura = document.querySelector("#cinta-factura tbody");
function muestraFila(){
	let output="";
	for (let i=0; i<factura.length; i++) {
		output+="<tr>";
		output+="<td class='numerador'>"+(i+1)+"</td>";
		output+="<td>"+factura[i].articulo+"</td>";

		output+="<td><button onclick='retiraFila("+i+");'>*</button><input type='number' onkeyup='revisaDisponible("+i+", this)' onchange='revisaDisponible("+i+", this)' class='cantidad-item' value='"+factura[i].cantidad+"' min='1'></td>";
		output+="<td class='valor'>$ "+Intl.NumberFormat('es-CO').format(factura[i].valor)+"</td>";
		output+="<td class='subtotal'>$ "+Intl.NumberFormat('es-CO').format(parseInt(factura[i].cantidad)*parseInt(factura[i].valor))+"</td>";
		output+="</tr>";
	}
	cintaFactura.innerHTML=output;
	actualizaTotales();
}

function retiraFila(el){
	factura.splice(el, 1);
	muestraFila();
}

function actualizaTotales(){
	let total=0;
	for (let i = 0; i < factura.length; i++) {
		let cantidad = factura[i].cantidad;
		let valor = factura[i].valor;
		total+=cantidad*valor;
	}
	document.getElementById("total").innerHTML="$ "+Intl.NumberFormat('es-CO').format(total);
	calculaRegreso();
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

function calculaRegreso(){
	let venta = parseInt(document.querySelector("#total").textContent.replace("$ ","").replace(".","").replace(".",""));
	let pago = parseInt(document.querySelector("#pago-venta").value);
	document.querySelector("#regreso").innerHTML=Intl.NumberFormat('es-CO').format((isNaN(pago)?0:pago)-venta);
}

concretaVenta.addEventListener("click", function(){
	if (!factura.length) {
		barraEstado("Factura vacia");
	}else{
		let concreta = confirm("¿Continuar y concretar esta venta?");
		if (concreta == true) {
			let imprime = confirm("¿Desea imprimir factura?");
			if (imprime == true) {
				alert("plantilla");
			} 
			let xmlhttp = new XMLHttpRequest();
			let idCajero= document.querySelector("#cajero").getAttribute("data-cajero");
			console.log(idCajero);
			let	queryString = "cajero="+idCajero;
			queryString += "&cliente="+selectorTitular.id;
			queryString += "&venta="+JSON.stringify(factura);
			xmlhttp.open("POST", "php/concretaVenta.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			xmlhttp.send(queryString);
			xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
			if (xmlhttp.status == 200) {
				console.log(xmlhttp.response);
			}
		}
	};
			// recarga();
		} 
	}
});

vaciaFactura.addEventListener('click', function(){
	if (!factura.length) {
		barraEstado("Factura vacia");
	}else{
		let confirma = confirm("¿Continuar y descartar esta factura?");
		if (confirma) {
			recarga();
		}
	}
});

function recarga(){
	location.replace(`venta.php`);
}