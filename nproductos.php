<?php 
ini_set('display_errors');
ini_set('display_startup_errors');
error_reporting(E_ALL);

include_once "config.php";
include_once "entidades/producto.php";

$producto= new Producto();
$aProductos = $producto->obtenerTodos();

include_once("menu.php");

?>

        <!-- Begin Page Content -->
          <form action="" method="POST">
          <div class="container-fluid">
          <h1 class="h3 mb-4 text-gray-800">Listado de Productos</h1>
          <table class="table table-hover border">
            <tr>
                <th>ID:</th>
                <th>Nombre:</th>
                <th>Cantidad:</th>
                <th>Precio:</th>
                <th>Descripcion:</th>
                
            </tr>
            <?php foreach ($aProductos as $producto): ?>
              <tr>
                  <td><a href="nproductos.php?id=<?php echo $producto->idproducto; ?>"><?php echo $producto->idproducto; ?></a></td>
                  <td><?php echo $producto->nombre; ?></td>
                  <td><?php echo $producto->cantidad; ?></td>
                  <td><?php echo $producto->precio; ?></td>
                  <td><?php echo $producto->descripcion; ?></td>
              </tr>
            <?php endforeach; ?>
          </table>

        </div>
        </form>
      <!-- End of Main Content -->

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
