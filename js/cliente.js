const crud = document.getElementById('crud');
let clientes="";

function reset(){
	selectorCliente.value={};
	seleccionCliente.value="";
	document.getElementById("inputNombre").value="";
	document.getElementById("inputDireccion").value="";
	document.getElementById("inputCorreo").value="";
	document.getElementById("inputNit").value="";
	document.getElementById("inputTelefono").value="";
	document.getElementById("inputVinculo").value="";
	document.getElementById("inputIngreso").value="";
	document.getElementById("inputNacimiento").value="";
	muestraPanel();
}

function muestraPanel(modo){
	switch (modo) {
		case "rud":
		crud.innerHTML = "<button onclick=actualiza()>Actualizar</button>";
		crud.innerHTML+= "<button onclick=elimina()>Eliminar del directorio</button>";
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

function actualiza(){
	const cliente = {};
	let habilitaUsuario = false;
	let usuario = selectorCliente.usuario;
	cliente.id = selectorCliente.id;
	cliente.nombre = document.getElementById("inputNombre").value;
	cliente.direccion = document.getElementById("inputDireccion").value;
	cliente.correo = document.getElementById("inputCorreo").value;
	cliente.nit = document.getElementById("inputNit").value;
	cliente.telefono = document.getElementById("inputTelefono").value;
	cliente.vinculo = document.getElementById("inputVinculo").value;
	cliente.ingreso = document.getElementById("inputIngreso").value;
	cliente.nacimiento = document.getElementById("inputNacimiento").value;
	if (selectorCliente.vinculo=="Administrador" || selectorCliente.vinculo=="Cajero") {
		habilitaUsuario=true;
		cliente.nickname = document.getElementById("inputUsuario").value;
		cliente.contrasena = document.getElementById("inputContrasena").value;
	}else{
		habilitaUsuario=false;
	}
	if (campoCompleto(cliente)) {
		let confirma=confirm("¿Continuar y guardar cambios?");
		if (confirma) {
			var xmlhttp = new XMLHttpRequest();
			let	queryString = "actualiza="+JSON.stringify(cliente);
			queryString += "&habilita="+habilitaUsuario;
			queryString += "&usuario="+usuario;
			xmlhttp.open("POST", "php/actualizaCliente.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			xmlhttp.send(queryString);
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
					if (xmlhttp.status == 200) {
						barraEstado(xmlhttp.response);
					}
				}
			};
			// recarga();
		}
	}
}


function elimina(){
	var confirma = confirm("¿Continuar y eliminar este cliente?");
	if (confirma) {
		const cliente = {};
		cliente.id = selectorCliente.id;
		var xmlhttp = new XMLHttpRequest();
		let	queryString = "elimina="+JSON.stringify(cliente);
		xmlhttp.open("POST", "php/eliminaCliente.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xmlhttp.send(queryString);
		recarga();	
	} 
}

function guarda(){
	const cliente = {};
	cliente.nombre = document.getElementById("inputNombre").value;
	cliente.direccion = document.getElementById("inputDireccion").value;
	cliente.correo = document.getElementById("inputCorreo").value;
	cliente.nit = document.getElementById("inputNit").value;
	cliente.telefono = document.getElementById("inputTelefono").value;
	cliente.vinculo = document.getElementById("inputVinculo").value;
	cliente.ingreso = document.getElementById("inputIngreso").value;
	cliente.nacimiento = document.getElementById("inputNacimiento").value;
	if (campoCompleto(cliente)) {
		var confirma = confirm("¿Continuar y guardar este cliente?");
		if (confirma == true) {
			var xmlhttp = new XMLHttpRequest();
			let	queryString = "guarda="+JSON.stringify(cliente);
			xmlhttp.open("POST", "php/nuevoCliente.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			xmlhttp.send(queryString);
			
			recarga();
		}
	}
}

function recarga(){
	location.replace(`cliente.php`);
}