<?php
ini_set('display_errors');
ini_set('display_startup_errors');
error_reporting(E_ALL);

include_once "config.php";
include_once "config.php";
include_once "entidades/venta.php";
include_once "entidades/cliente.php";
include_once "entidades/producto.php";

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

if(isset($_GET["do"]) && $_GET["do"] == "buscarProducto"){
    $idProducto = $_GET["id"];
    $producto = new Producto();
    $producto->producto = $idProducto;
    echo json_encode($producto->precio);
    exit;
}
 include_once("menu.php");

?>

        <!-- Begin Page Content -->
        <form action="" method="POST">
        <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Ventas</h1>
  <div class="row">
      <div class="col-12 mb-3">
          <a href="cliente-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
          <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
          <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
      </div>
  </div>
  <div class="container-fluid">
  <div class="row">
    <div class="col-12">
    </form>
        <form action="" method="POST">
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtFecha">Fecha:</label>
                <input type="date" required class="form-control" name="txtFecha" id="txtNtxtFechaombre" value="<?php echo date_format(date_create($venta->fecha), 'Y-m-d'); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstCliente">Cliente:</label>
                <select required class="form-control" name="lstCliente" id="lstCliente">
                    <option disabled selected value="">Seleccionar</option>
                    <?php foreach($aClientes as $cliente):  ?>
                            <?php if($cliente->idcliente == $venta->fk_idcliente): ?>
                                <option selected value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                            <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstProducto">Producto:</label>
                <select required class="form-control" name="lstProducto" id="lstProducto"  onchange= "fBuscarPrecio (); " >
                    <option disabled selected value="">Seleccionar</option>
                     <?php 
                     foreach($aProductos as $producto){
                        if($producto->idproducto == $venta->fk_idproducto)
                            echo "<option selected value='$producto->idproducto'>$producto->nombre</option>";
                        else
                            echo "<option value='$producto->idproducto'>$producto->nombre</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtCorreo">Cantidad:</label>
                <input type="text" class="form-control" name="txtCantidad" id="txtCantidad" value="<?php echo $venta->cantidad; ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtCorreo">Precio unitario:</label>
                <input type="text" class="form-control" name="txtPrecioUnitario" id="txtPrecioUnitario" value="<?php echo $venta->preciounitario; ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtCorreo">Importe:</label>
                <input type="text" class="form-control" name="txtImporte" id="txtImporte" value="<?php echo $venta->importe; ?>" />
            </div>
        </div> 
        </form>
        </div>
        </div>
      
        <!-- /.container-fluid -->

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

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

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
          <a class="btn btn-primary" href="login.html">Cerrar sesion</a>
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
  
  <script>
        function fBuscarPrecio(){
            var idProducto = $("#lstProducto option:selected").val();
            $.ajax({
                type: "GET",
                url: "fventas.php?do=buscarProducto",
                data: { id:idproducto },
                async: true,
                dataType: "json",
                success: function (respuesta) {
                    $("#txtPrecioUnitario").val(respuesta);
                }
            });

        }

        function fCalcularTotal (){

            var precio= $(#txtPrecioUnitario).val();
            var cantidad= $(#txtCantidad).val();
            var total= precio * cantidad;


        }
    </script>

