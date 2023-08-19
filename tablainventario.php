<?php
session_start();
if (isset($_SESSION['usuario'])) {
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Tabla de Inventario</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/inventario.css">
  </head>
  <body>
    <header>
      <h1>Arctic</h1>
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
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th>Mas</th>
          </tr>
        </thead>
        <tbody id="cinta-inventario">

        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"># Articulos en inventario</td>
            <td id="total-articulo"></td>
            <td></td>
            <td id="total-valor">0</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </main>
    <footer>
      <div id="barra-estado"></div>
      <div class="copyright"><span>Copyright &copy; 2023 Arctic</span></div>
    </footer>

    <script src="js/tablainventario.js"></script>
  </body>
  </html>

  <?php
} else {
  header("Location: index.php?error=Para continuar inicie sesion");
}
?>