<?php
ini_set('display_errors');
ini_set('display_startup_errors');
error_reporting(E_ALL);

include_once "config.php";
include_once "entidades/venta.php";
include_once "entidades/cliente.php";
include_once "entidades/producto.php";

$venta = new Venta();

if($_POST){
    $venta = new Venta();
    $venta->cargarDesdeFormulario($_REQUEST);

	if(isset($_POST["btnInsertar"])){
       $venta->insertar();

	} else if(isset($_POST["btnBorrar"])){
       $venta->borrar();

    } else if(isset($_POST["btnActualizar"])){
       $venta->actualizar();
    }
}

$cliente = new Cliente();
$aClientes = $cliente->obtenerTodos();

$producto = new Producto();
$aProductos = $producto->obtenerTodos();

$venta = new Venta();
$aVentas = $venta->obtenerTodos();

if(isset($_GET["id"])){
    $idVenta = $_GET["id"];
    $venta->obtenerUnoPorId($idVenta);
}
include_once("menu.php");
?>


        <!-- Begin Page Content -->
    
    <div class="container-fluid">
    <div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Registro de ventas</h1>
        </div>
    </div>
    <div class="row">
    <div class="col-12">
    <form action="" method="POST">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>           
                    <th>Fecha</th>            
                    <th>Cliente</th>          
                    <th>Producto</th>          
                    <th>Precio</th>          
                </tr>
                </thead>
                <tbody>
                <?php foreach($aVentas as $index => $venta): ?>
                <tr>
                    <td><?php echo $index+1; ?></td>
                    <td><a href="abmventa.php?id=<?php echo $venta->idventa; ?>"><?php echo date_format(date_create($venta->fecha), 'd/m/Y'); ?></a></td>
                    <td><a target="_blank" href="ncliente.php?pos=<?php echo $venta->fk_idcliente; ?>"><?php echo $venta->nombre_cliente; ?></a></td>
                    <td><a target="_blank" href="nproducto.php?pos=<?php echo $venta->fk_idproducto; ?>"><?php echo $venta->nombre_producto; ?></a></td>
                    <td>$ <?php echo $venta->importe ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </form>
        </div>
        </div>
        </div>
        </div>   
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







    

    




