let selectorProveedor = {};

const seleccionProveedor = document.getElementById('seleccion-proveedor');
const listaProveedor = document.getElementById('lista-proveedor');

const crud = document.getElementById('crud');
let listaItem="";
let proveedores="";

function reset(tipo){
	switch (tipo) {
		case "inventario":
		selectorInventario={};
		seleccionInventario.value="";
		document.getElementById("inputArticulo").value="";
		document.getElementById("inputBarcode").value="";
		document.getElementById("inputDisponible").value="";
		document.getElementById("inputValor").value="";
		reset("proveedor");
		muestraPanel();
		break;
		case "proveedor":
		selectorProveedor={};
		seleccionProveedor.value="";
		document.getElementById("displayProveedor").value="";
		document.getElementById("displayDireccion").value="";
		document.getElementById("displayTelefono").value="";
		document.getElementById("displayCorreo").value="";
		break;
		default:
		break;
	}
}

seleccionProveedor.addEventListener('keyup', function(){
	let Proveedor = this.value;
	listaProveedor.style.display = "initial";
	var xmlhttp = new XMLHttpRequest();
	let queryString = "buscar="+JSON.stringify(Proveedor);
	xmlhttp.open("POST", "php/buscaProveedor.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(queryString);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
			if (xmlhttp.status == 200) {
				selectorProveedor=JSON.parse(xmlhttp.response);
                selectorProveedor.filtro = seleccionProveedor.value;
				muestraLista(selectorProveedor,"cliente");
			}
		}
	};
});

seleccionProveedor.addEventListener('focusout', function(){
	setTimeout(function(){listaProveedor.style.display = "none";}, 200)
});

function muestraLista(selector, tipo){
	let output = "";
	if (!selector.length) {
		output += "<div class='sin-resultados'>";
		output += "<div class='contenedor-datos'>";
		output += "Ninguna coincidencia para '"+selector.filtro+"', ¿desea&nbsp;<a href='"+tipo+".php?nuevo="+selector.filtro+"' target='_blank'>crear nuevo "+tipo+"</a>&nbsp;con esta informacion?";
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
		listaInventario.innerHTML=output;
		let busquedaArticulo = document.querySelectorAll('.articulo-resultado');
		for (let i = 0; i < busquedaArticulo.length; i++) {
			busquedaArticulo[i].addEventListener("click", function() {
				selectorInventario=selector[i];
				selector=selector[i];
				seleccionInventario.value=selector.articulo;
				document.querySelector("#inputArticulo").value=selector.articulo;
				document.querySelector("#inputBarcode").value=selector.barcode;
				document.querySelector("#inputDisponible").value=selector.disponible;
				document.querySelector("#inputValor").value=selector.valor;
				if(selector.id_cliente!=0){
					selectorProveedor=selector.proveedor[0];
					seleccionProveedor.value=selector.proveedor[0].nombre;
					document.querySelector("#displayProveedor").value=selector.proveedor[0].nombre;
					document.querySelector("#displayDireccion").value=selector.proveedor[0].direccion;
					document.querySelector("#displayTelefono").value=selector.proveedor[0].telefono;
					document.querySelector("#displayCorreo").value=selector.proveedor[0].correo;
				}
				muestraPanel("rud");
			});
		}
		break;
		case "cliente":
		for (let i=0; i<selector.length; i++) {
			output += "<div class='proveedor-resultado'>";
			output += "<div class='contenedor-datos'>";
			output += "<div class='proveedor-nombre'>"+selector[i].nombre+"</div>";
			output += "<div class='proveedor-direccion'>"+selector[i].direccion+"</div>";
			output += "<div class='proveedor-telefono'>"+selector[i].telefono+"</div>";
			output += "<div class='proveedor-correo'>"+selector[i].correo+"</div>";
			output += "</div></div>";
		}
		listaProveedor.innerHTML=output;
		let busquedaProveedor = document.querySelectorAll('.proveedor-resultado');
		for (let i = 0; i < busquedaProveedor.length; i++) {
			busquedaProveedor[i].addEventListener("click", function() {
				selectorProveedor=selector[i];
				seleccionProveedor.value=selector[i].nombre;
					document.querySelector("#displayProveedor").value=selector[i].nombre;
					document.querySelector("#displayDireccion").value=selector[i].direccion;
					document.querySelector("#displayTelefono").value=selector[i].telefono;
					document.querySelector("#displayCorreo").value=selector[i].correo;
			});
		}
		break;
		default:
		break;
	}
}

function actualiza(){
	const item = {};
	item.id = selectorInventario.id;
	item.articulo = document.getElementById("inputArticulo").value;
	item.barcode = document.getElementById("inputBarcode").value;
	item.disponible = document.getElementById("inputDisponible").value;
	item.valor = document.getElementById("inputValor").value;
	item.proveedorid = selectorProveedor.id;
	if (item.proveedorid==null) {item.proveedorid="0";}
	if (campoCompleto(item)) {
		let confirma=confirm("¿Continuar y guardar cambios?");
		if (confirma) {
			var xmlhttp = new XMLHttpRequest();
			let	queryString = "inventario="+JSON.stringify(item);
			xmlhttp.open("POST", "php/actualizaInventario.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			xmlhttp.send(queryString);
			barraEstado("El articulo ha sido actualizado, recarga inminente");
			setInterval(function(){
				recarga();
			},4000);
		}
	}
}

function elimina(){
	var confima = confirm("¿Continuar y eliminar este articulo?");
	if (confima == true) {
		const item = {};
		item.id = selectorInventario.id;
		var xmlhttp = new XMLHttpRequest();
		let	queryString = "inventario="+JSON.stringify(item);
		xmlhttp.open("POST", "php/eliminaArticulo.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(queryString);
		barraEstado("El articulo ha sido eliminado, recarga inminente");
			setInterval(function(){
				recarga();
			},4000);
	} 
}

function guarda(){
	const item = {};
	item.articulo = document.getElementById("inputArticulo").value;
	item.barcode = document.getElementById("inputBarcode").value;
	item.disponible = document.getElementById("inputDisponible").value;
	item.valor = document.getElementById("inputValor").value;
	item.proveedorid = selectorProveedor.id;
	if (item.proveedorid==null) {item.proveedorid="0";}
	if (campoCompleto(item)) {
		let confirma=confirm("¿Continuar y guardar este articulo?");
		if (confirma) {
			var xmlhttp = new XMLHttpRequest();
			let	queryString = "inventario="+JSON.stringify(item);
			xmlhttp.open("POST", "php/nuevoInventario.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			xmlhttp.send(queryString);
			barraEstado("La informacion del nuevo articulo ha sido almacenada, sera redireccionado");
			setInterval(function(){
				window.close();
			},4000);
		}
	}
}

function muestraPanel(modo){
	switch (modo) {
		case "rud":
		crud.innerHTML = "<button onclick=actualiza()>Actualizar</button>";
		crud.innerHTML+= "<button onclick=elimina()>Eliminar del inventario</button>";
		crud.innerHTML+= "<button onclick=recarga()>Cancelar</button>";
		break;
		default:
		crud.innerHTML = "";
		break;
	}
}

function campoCompleto(necesario){
	let completo = false;
	let msg = "Para continuar debe completar los campos";
	let vacio = {};
	let conteo = 0;
	Object.keys(necesario).forEach(valor => {
		if (necesario[valor]=="") {
			let input = valor.charAt(0).toUpperCase() + valor.slice(1);
			document.querySelector("#input"+input).classList.add("campoVacio");
			conteo+= 1;
		}
	});
	if(conteo>0){
		barraEstado(msg);
		let elemento = document.querySelectorAll(".campoVacio");
		setInterval(function(){
			for (let i = 0; i < elemento.length; i++) {
				elemento[i].classList.remove("campoVacio");
			}
		},1400);
	}
	else{
		completo=true;
	}
	return completo;
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

function recarga(){
	location.replace(`inventario.php`);
}