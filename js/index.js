
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