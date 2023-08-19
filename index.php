<?php
if (isset($_SESSION['usuario'])) {
  header("Location: venta.php");
} else {
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Registro de Ventas - Inicio de sesion</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
  </head>
  <body>
    <header>
      <h1>Arctic</h1>
    </header>
    <nav>
      
    </nav>
    <main>
      <div class="login">
        <form action="php/login.php" method="post">
        <h2>Bienvenido a la aplicación de registro de ventas</h2>
        <p>En esta aplicación podrás registrar las ventas realizadas en la tienda, generar facturas y llevar un control del inventario de productos.</p>
        <hr>
          <input id="nick" name="nick" type="text" placeholder="Nombre de usuario...">
          <input id="pass" name="pass" type="password" placeholder="Contraseña...">
          <input type="submit" value="Ingresar">
        </form>
      </div>
    </main>
    <footer>
      <div id="barra-estado"></div>
      <div class="copyright"><span>Copyright &copy; 2023 Arctic</span></div>
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