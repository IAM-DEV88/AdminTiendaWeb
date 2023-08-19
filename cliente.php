<?php
session_start();
if (isset($_SESSION['usuario'])) {
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Clientes</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/cliente.css">
  </head>
  <body>
    <header>
      <h1>Arctic</h1>
    </header>
    <nav id="nav-principal">
      <ul>
        <li><a href="venta.php">Ventas</a></li>
        <li><a href="facturacion.php">Facturación</a></li>
        <li><a href="inventario.php">Inventario</a></li>
        <li><a class="active" href="cliente.php">Clientes</a></li>
        <li><a href="php/logout.php">Cerrar sesion</a></li>
      </ul>
    </nav>
    <main>
      <div id="directorio">
        <?php
        if (isset($_GET['nuevo'])) {
         ?>
         <h5>Crear nuevo cliente: <?php echo $_GET['nuevo']; ?></h5>
         <?php
       } else {
         ?>
         <div class="barra-busqueda">
          <input type="text" autocomplete="off" placeholder="Buscar Cliente..." id="seleccion-cliente">
          <button onclick="reset();">Reset</button>
          <div id="lista-cliente">
          </div>
        </div>
        <script>
          let selectorCliente={};
          const seleccionCliente = document.getElementById('seleccion-cliente');
          const listaCliente = document.getElementById('lista-cliente');
          
          seleccionCliente.addEventListener('keyup', function(){
            listaCliente.style.display = "initial";
            var xmlhttp = new XMLHttpRequest();
            let queryString = "buscar="+JSON.stringify(selectorCliente.filtro);
            xmlhttp.open("POST", "php/buscaCliente.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
            xmlhttp.send(queryString);
            xmlhttp.onreadystatechange = function() {
              if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
                if (xmlhttp.status == 200) {
                  selectorCliente=JSON.parse(xmlhttp.response);
                  selectorCliente.filtro = seleccionCliente.value;
                  let output = "";
                  if (selectorCliente.length==0) {
                    output += "<div class='sin-resultados'>";
                    output += "<div class='contenedor-datos'>";
                    output += "Ninguna coincidencia para '"+selectorCliente.filtro+"', ¿desea <a href='cliente.php?nuevo="+selectorCliente.filtro+"'>crear nuevo cliente</a>&nbsp;con esta informacion?";
                    output += "</div>";
                    listaCliente.innerHTML=output;
                  }else{
                    for (let i=0; i<selectorCliente.length; i++) {
                      output += "<div class='cliente-resultado'>";
                      output += "<div class='contenedor-datos'>";
                      output += "<div class='cliente-nombre'>"+selectorCliente[i].nombre+"</div>";
                      output += "<div class='cliente-direccion'>"+selectorCliente[i].direccion+"</div>";
                      output += "<div class='cliente-telefono'>"+selectorCliente[i].telefono+"</div>";
                      output += "<div class='cliente-correo'>"+selectorCliente[i].correo+"</div>";
                      output += "</div></div>";
                    }
                    listaCliente.innerHTML=output;
                    clientes = document.querySelectorAll(".cliente-resultado");
                    for (let i=0; i<clientes.length; i++) {
                      clientes[i].addEventListener("click", function() {
                        selectorCliente=selectorCliente[i];
                        seleccionCliente.value=selectorCliente.nombre;
                        document.querySelector("#inputNombre").value=selectorCliente.nombre;
                        document.querySelector("#inputDireccion").value=selectorCliente.direccion;
                        document.querySelector("#inputCorreo").value=selectorCliente.correo;
                        document.querySelector("#inputNit").value=selectorCliente.nit;
                        document.querySelector("#inputTelefono").value=selectorCliente.telefono;
                        document.querySelector("#inputVinculo").value=selectorCliente.vinculo;
                        document.querySelector("#inputIngreso").value=selectorCliente.ingreso;
                        document.querySelector("#inputNacimiento").value=selectorCliente.nacimiento;
                        if(selectorCliente.vinculo==="Administrador" || selectorCliente.vinculo==="Cajero"){
                          let output="";
                          output+="<span>Usuario:</span><input class='corto' id='inputUsuario' placeholder='Nombre de usuario...' type='text'>";
                          output+="<span>Contraseña:</span><input class='corto' id='inputContrasena' placeholder='Contraseña...' type='password'>";
                          document.querySelector("#usuario").innerHTML=output;
                          document.querySelector("#inputUsuario").value=selectorCliente.usuario;
                          document.querySelector("#inputContrasena").value=selectorCliente.contrasena;
                        }else{
                          document.querySelector("#usuario").innerHTML="";
                        }
                        muestraPanel("rud");
                      });
                    }
                  }
                }
              }
            };
          });

          seleccionCliente.addEventListener('focusout', function(){
            setTimeout(function(){listaCliente.style.display = "none";}, 200)
          });

          document.addEventListener('keydown', (event) => {
            var keyValue = event.key;
            var codeValue = event.code;
            if (codeValue=="ControlRight") {
              seleccionCliente.focus();
            }
            if (codeValue=="ControlLeft") {
              seleccionCliente.select();
            }
          }, false);
        </script>
        <?php
      }
      ?>
      <hr>
      <div id="info-cliente" class="contenedor-datos">
        <span>Nombre:</span><input id="inputNombre" placeholder="Nombre..." type="text">
        <span>Direccion:</span><input id="inputDireccion" placeholder="Direccion..." type="text">
        <span>Correo:</span><input id="inputCorreo" placeholder="Correo electronico..." type="mail">
        <span>Nit:</span><input id="inputNit" placeholder="Nit..." type="text">
        <span>Telefono:</span><input class="corto" id="inputTelefono" class="corto" placeholder="Telefono..." type="text">
        <span>Vinculo:</span><select class="corto" id="inputVinculo">
          <option value="Cliente" selected>Cliente</option>  
          <option value="Proveedor">Proveedor</option>  
          <option value="Cajero">Cajero</option>  
          <option value="Administrador">Administrador</option>  
        </select>
        <span>Ingreso:</span><input class="corto" id="inputIngreso" placeholder="Fecha de ingreso..." type="date">
        <span>Nacimiento:</span><input class="corto" id="inputNacimiento" placeholder="Fecha de nacimiento..." type="date">
        <div id="usuario">

        </div>
      </div>
    </div>
    <div id="opciones">
      <div id="img-inventario">
      </div>
      <hr>
      <div id="crud">
        <?php
        if (isset($_GET['nuevo'])) {
         ?>
         <button onclick="guarda();">Guardar nuevo cliente</button><button onclick="recarga()">Cancelar</button>
         <?php
       } else {
         ?>
         <?php
       }
       ?>
     </div>
   </div>
 </main>
 <footer>
  <div id="barra-estado"></div>
  <div class="copyright"><span>Copyright &copy; 2023 Arctic</span></div>
</footer>

<script src="js/cliente.js"></script>
</body>
</html>

<?php
} else {
  header("Location: index.php?error=Para continuar inicie sesion");
}
?>