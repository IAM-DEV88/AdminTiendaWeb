<?php
session_start();
if (isset($_SESSION['usuario'])) {
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Facturacion</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/facturacion.css">
  </head>
  <body>
    <header>
      <h1>Administrador de Tienda Web</h1>
    </header>
    <nav id="nav-principal">
      <ul>
        <li><a href="venta.php">Ventas</a></li>
        <li><a class="active" href="facturacion.php">Facturación</a></li>
        <li><a href="inventario.php">Inventario</a></li>
        <li><a href="cliente.php">Clientes</a></li>
        <li><a href="php/logout.php">Cerrar sesion</a></li>
      </ul>
    </nav>
    <main>
      <div class="panel-facturacion">
        <div class="factura">
          <div class="encabezado-factura">
            <div class="info-caja">
            <div>
                <span class="logo-factura">
                  <h1>Nombre del Negocio</h1>
                </span>
                <span id="clockArea">
                  <span id="hoy"></span> / <span id="hr"></span><span id="min"></span><span id="secs"></span>
                </span>
              </div>
              <div>Nit. <span>9984013725-1</span></div>
              <div>Direccion: <span>Carrera 17b # 14-109</span></div>
              <div>Telefono: <span>160 625 3153</span></div>
              <div>Cajero: <span id="cajero">**** **** **** *</span></div>
            </div>
            <div id="info-cliente"></div>
          </div>
          <div>
            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Articulo</th>
                  <th>Cantidad</th>
                  <th>Anulado</th>
                  <th>Precio</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody id="cuerpo-factura">

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5">Total:</td>
                  <td id="total">0</td>
                </tr>
              </tfoot>
            </table>
          </div>
          <hr>
        </div>
        <div id="garantia">
          
        </div>
      </div>
      <div class="lateral-facturacion">
        <div id="opciones">
          
        </div>
      <hr>
        <div class="historial">
          <input type="date" id="filtro-fecha">
          <div id="lista-facturacion">
          </div>
        </div>  
        
      </div>
    </main>
    <footer>
      <div id="barra-estado"></div>
      <div class="copyright"><span>Copyright &copy; 2023 IAM-DEV88</span></div>
    </footer>
    <script src="js/facturacion.js"></script>
  </body>
  </html>

  <?php
} else {
  header("Location: index.php?error=Para continuar inicie sesion");
}
?>