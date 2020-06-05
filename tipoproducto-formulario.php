<?php 
ini_set('display_errors');
ini_set('display_startup_errors');
error_reporting(E_ALL);

include_once "config.php";
include_once "entidades/tipoproducto.php";

$tipoproducto = new Tipoproducto();
$tipoproducto->cargarFormulario($_REQUEST);

if($_POST){
  
    if(isset($_POST["btnGuardar"])){
     if(isset($_GET["id"]) && $_GET["id"] > 0){
              //Actualizo un cliente existente
              $tipoproducto->actualizar();
        } else {
            //Es nuevo
            $tipoproducto->insertar();
        }
    } else if(isset($_POST["btnBorrar"])){
        $tipoproducto->eliminar();
    }
} 
if(isset($_GET["id"]) && $_GET["id"] > 0){
    $tipoproducto->obtenerPorId();
}
include_once("menu.php");

?>

        <!-- Begin Page Content -->
        <form action="" method="POST">
        <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tipo de Productos</h1>
  <div class="row">
      <div class="col-12 mb-3">
          <a href="tipoproducto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
          <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
          <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
      </div>
  </div>
  <div class="row">
      <div class="col-6 form-group">
          <label for="txtNombre">Nombre:</label>
          <input type="text" required="" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $tipoproducto->nombre ?>">
      </div>
  </div>
        </div>
        </form>
        <!-- /.container-fluid -->

      

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Listo para irte?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="login.php">Cerrar sesion</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

