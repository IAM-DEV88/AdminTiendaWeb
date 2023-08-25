<?php
if (isset($_SESSION['usuario'])) {
  header("Location: venta.php");
} else {
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Tienda Web - Inicio de sesion</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
  </head>
  <body>
    <header>
      <h1>Administrador de Tienda Web</h1>
    </header>
    <nav>
      
    </nav>
    <main>
      <div class="login">
        <form action="php/login.php" method="post">
        <h4>Aqui podra:</h4>
        <ul>
          <li>Registrar las ventas de la tienda</li>
          <li>Llevar registro de facturas</li>
          <li>Anular facturas total o parcialmente</li>
          <li>Generar garantias y llevar control</li>
          <li>Administrar el inventario de productos</li>
          <li>Gestionar facilmente administradores del sistema</li>
          <li>Registrar proveedores de cada producto</li>
          <li>Gestionar cajeros de punto</li>
          <li>Registrar clientes de la tienda</li>
          <li>Generar factura personalizada</li>
        </ul>
        <hr>
          <input id="nick" name="nick" type="text" placeholder="Nombre de usuario...">
          <input id="pass" name="pass" type="password" placeholder="Contraseña...">
          <input type="submit" value="Ingresar">
        </form>
      </div>
    </main>
    <footer>
      <div id="barra-estado"></div>
      <div class="copyright"><span>Copyright &copy; 2023 IAM-DEV88</span></div>
    </footer>
    <script src="js/index.js"></script>
    <?php
    if (isset($_GET['error'])) {
      ?>
      <script>barraEstado("<?php echo $_GET['error']; ?>");</script>
      <?php
    } 
    ?>
  </body>
  </html>
  <?php
}
?>