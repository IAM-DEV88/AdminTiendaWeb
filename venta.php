<?php
session_start();
if (isset($_SESSION['usuario'])) {
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Registro de Ventas</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/venta.css">
  </head>
  <body>
    <header>
      <h1>Arctic</h1>
    </header>
    <nav id="nav-principal">
      <ul>
        <li><a class="active" href="venta.php">Ventas</a></li>
        <li><a href="facturacion.php">Facturación</a></li>
        <li><a href="inventario.php">Inventario</a></li>
        <li><a href="cliente.php">Clientes</a></li>
        <li><a href="php/logout.php">Cerrar sesion</a></li>
      </ul>
    </nav>
    <main>
      <div class="caja-registradora">
        <div class="agrega-articulo">
          <div class="barra-articulo">
            <input type="text" autocomplete="off" placeholder="Buscar articulo..." id="input-articulo">
            <button onclick="reset('articulo');">Reset</button>
            <div id="lista-articulo">
            </div>
          </div>
          <input type="number" id="input-cantidad" onkeyup="revisaDisponible(null, this)" onchange="revisaDisponible(null, this)" placeholder="Cantidad...">
          <button id="agrega-articulo">Agregar</button>
        </div>
        <div class="barra-titular">
          <input type="text" autocomplete="off" placeholder="Buscar titular..." id="input-titular">
          <button onclick="reset('titular');">Reset</button>
          <div id="lista-titular">

          </div>
        </div>
        <hr>
        <div class="factura">
          <div class="encabezado-factura">
            <div id="info-caja">
              <div>
                <span class="logo-factura">
                  <h1>Tramitaciones</h1>
                </span>
                <span id="clockArea">
                  <span id="hoy"></span> / <span id="hr"></span><span id="min"></span><span id="secs"></span>
                </span>
              </div>
              <div>Nit. <span>1144035525-1</span></div>
              <div>Direccion: <span>Calle 2 # 4-09</span></div>
              <div>Telefono: <span>316 681 6657</span></div>
              <div>Cajero: <span id="cajero" data-cajero="<?php echo $_SESSION['cajero'] ?>"><?php echo $_SESSION['nombre'] ?></span></div>
            </div>
            <div id="info-cliente"></div>
          </div>
          <div class="cuerpo-factura">
            <table id="cinta-factura">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Articulo</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody id="cinta">

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4">Total:</td>
                  <td id="total">0</td>
                </tr>
              </tfoot>
            </table>
          </div>
          <hr>
        </div>
      </div>

      <div class="opciones">
        <input type="text" placeholder="Pago..." id="pago-venta" onkeyup="calculaRegreso(this)">
        <h2>Regreso<br>$ <span id="regreso"></span></h2>
        <hr>
        <button id="concreta-venta">Concretar venta</button>
        <button id="vacia-factura">Vaciar factura</button>
      </div>  
    </main>
    <footer>
      <div id="barra-estado"></div>
      <div class="copyright"><span>Copyright &copy; 2023 Arctic</span></div>
    </footer>
    <script src="js/venta.js"></script>
  </body>
  </html>

  <?php
} else {
  header("Location: index.php?error=Para continuar inicie sesion");
}
?>