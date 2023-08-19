document.addEventListener('DOMContentLoaded', function(){
	
	var xmlhttp = new XMLHttpRequest();
	let queryString = "";
	xmlhttp.open("POST", "php/tablaInventario.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.send(queryString);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
			if (xmlhttp.status == 200) {
				console.log(JSON.parse(xmlhttp.response));
				muestraFila(JSON.parse(xmlhttp.response));
			}
		}
	};
});

let cintaInventario = document.querySelector("#cinta-inventario");
let totalArticulo = document.querySelector("#total-articulo");
let totalValor = document.querySelector("#total-valor");
function muestraFila(inventario){
	let articulos=0;
	let valorInventario=0;
	let output="";
	for (let i=0; i<inventario.length; i++) {
		output+="<tr>";
		output+="<td class='numerador'>"+(i+1)+"</td>";
		output+="<td>"+inventario[i].articulo+"</td>";

		output+="<td class='cantidad-item'>"+inventario[i].disponible+"</td>";
		output+="<td class='valor'>$ "+Intl.NumberFormat('es-CO').format(inventario[i].valor)+"</td>";
		output+="<td class='subtotal'>$ "+Intl.NumberFormat('es-CO').format(parseInt(inventario[i].disponible)*parseInt(inventario[i].valor))+"</td>";
		output+="<td>extra</td>";
		output+="</tr>";
		articulos+=parseInt(inventario[i].disponible);
		valorInventario+=parseInt(inventario[i].disponible)*parseInt(inventario[i].valor);
	}
	cintaInventario.innerHTML=output;
	totalArticulo.innerHTML=articulos;
	totalValor.innerHTML="$ "+Intl.NumberFormat('es-CO').format(valorInventario);
}