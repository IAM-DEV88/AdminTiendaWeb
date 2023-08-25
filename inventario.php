<?php
session_start();
if (isset($_SESSION['usuario'])) {
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title><?php if (isset($_GET['nuevo'])) {echo "Nuevo Inventario";}else{echo "Inventario";}?></title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/inventario.css">
  </head>
  <body>
    <header>
      <h1>Administrador de Tienda Web</h1>
    </header>
    <nav id="nav-principal">
      <ul>
        <li><a href="venta.php">Ventas</a></li>
        <li><a href="facturacion.php">Facturación</a></li>
        <li><a class="active" href="inventario.php">Inventario</a></li>
        <li><a href="cliente.php">Clientes</a></li>
        <li><a href="php/logout.php">Cerrar sesion</a></li>
        
      </ul>
    </nav>
    <main>
      <div id="inventario">
        <?php
        if (isset($_GET['nuevo'])) {
         ?>
         <h5>Crear nuevo articulo: <?php echo $_GET['nuevo']; ?></h5>
         <?php
       } else {
         ?>
         <div class="barra-busqueda">
          <input type="text" placeholder="Buscar inventario..." id="seleccion-inventario">
          <button onclick="reset('inventario');">Reset</button>
          <div id="lista-inventario">
          </div>
        </div>
        <script>
          let selectorInventario = {};

          const seleccionInventario = document.getElementById('seleccion-inventario');
          const listaInventario = document.getElementById('lista-inventario');

          seleccionInventario.addEventListener('keyup', function(){
            let articulo = this.value;
            listaInventario.style.display = "initial";
            var xmlhttp = new XMLHttpRequest();
            let queryString = "buscar="+JSON.stringify(articulo);
            xmlhttp.open("POST", "php/buscaInventario.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
            xmlhttp.send(queryString);
            xmlhttp.onreadystatechange = function() {
              if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
                if (xmlhttp.status == 200) {
                  selectorInventario=JSON.parse(xmlhttp.response);
                  selectorInventario.filtro = seleccionInventario.value;
                  muestraLista(selectorInventario,"inventario");
                }
              }
            };
          });

          seleccionInventario.addEventListener('focusout', function(){
            setTimeout(function(){listaInventario.style.display = "none";}, 200)
          });

          document.addEventListener('keydown', (event) => {
            var keyValue = event.key;
            var codeValue = event.code;
            if (codeValue=="ControlRight") {
              seleccionInventario.focus();
            }
            if (codeValue=="ControlLeft") {
              seleccionInventario.select();
            }
          }, false);
        </script>
        <?php
      }
      ?>
      <hr>
      <div id="info-inventario">
        <span>Articulo:</span><input id="inputArticulo" placeholder="Nombre..." type="text">
        <span>Codigo:</span><input id="inputBarcode" placeholder="Codigo de barra..." type="number">
        <span>Unidades:</span><input id="inputDisponible" class="corto" placeholder="Unidades disponibles..." type="number">
        <span>Valor:</span><input id="inputValor" class="corto" placeholder="Valor de venta..." type="number">

        <div id="busca-proveedor">
          <input type="text" placeholder="Buscar proveedor..." id="seleccion-proveedor">
          <button onclick="reset('proveedor');">Reset</button>
          <div id="lista-proveedor">
          </div>
        </div>
        <div id="info-proveedor">
          <span>Proveedor:</span><input id="displayProveedor" readonly placeholder="Nombre..." type="text">
          <span>Direccion:</span><input id="displayDireccion" readonly placeholder="Direccion..." type="text">
          <span>Correo:</span><input id="displayCorreo" readonly placeholder="Correo electronico..." type="mail">
          <span>Telefono:</span><input class="corto" id="displayTelefono" readonly placeholder="Telefono..." type="text">
        </div>
      </div>
    </div>
    <div id="opciones">
      <div id="menu-inventario">
        <a href="tablainventario.php">Inventario completo</a>
      </div>
      <hr>
      <div id="crud">
        <?php
        if (isset($_GET['nuevo'])) {
         ?>
         <button onclick="guarda();">Guardar nuevo articulo</button><button onclick="recarga()">Cancelar</button>
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
  <div class="copyright"><span>Copyright &copy; 2023 IAM-DEV88</span></div>
</footer>

<script src="js/inventario.js"></script>
</body>
</html>

<?php
} else {
  header("Location: index.php?error=Para continuar inicie sesion");
}
?>