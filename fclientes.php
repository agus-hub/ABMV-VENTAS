<?php

ini_set('display_errors');
ini_set('display_startup_errors');
error_reporting(E_ALL);

include_once "config.php";
include_once "entidades/cliente.php";
include_once "entidades/provincia.entidad.php";
include_once "entidades/localidad.entidad.php";
include_once "entidades/domicilio.entidad.php";

$cliente = new Cliente();

if($_GET){
    if(isset($_GET["id"]) && $_GET["id"]> 0){
        $id = $_GET["id"];
        $cliente->obtenerPorId($id);
    }

    if(isset($_GET["do"]) && $_GET["do"] == "buscarLocalidad"){
        $idProvincia = $_GET["id"];
        $localidad = new Localidad();
        $aLocalidad = $localidad->obtenerPorProvincia($idProvincia);
        echo json_encode($aLocalidad);
        exit;
    }
    
}

/*if($_POST){
  $cliente = new Cliente();
  $cliente->cargarDesdeRequest($_REQUEST);

if(isset($_POST["btnInsertar"])){
     $cliente->insertar();
     
      for($i=0; $i < count($_POST["txtTipo"]); $i++){
          $domicilio = new Domicilio();
          $domicilio->fk_tipo = $_POST["txtTipo"][$i];
          $domicilio->fk_idcliente = $cliente->idcliente;
          $domicilio->fk_idlocalidad = $_POST["txtLocalidad"][$i];
          $domicilio->domicilio = $_POST["txtDomicilio"][$i];
          $domicilio->insertar();
      }

} else if(isset($_POST["btnBorrar"])){
     $cliente->borrar();

  } else if(isset($_POST["btnActualizar"])){
     $cliente->actualizar();

  }

}*/
       
if($_POST){

$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);     
  
    if(isset($_POST["btnGuardar"])){
     if(isset($_GET["id"]) && $_GET["id"] > 0){
              //Actualizo un cliente existente
              $cliente->actualizar();
        } else {
            //Es nuevo
            $cliente->insertar();
        }
    } else if(isset($_POST["btnBorrar"])){
        $cliente->eliminar();
    }
} 
if(isset($_GET["id"]) && $_GET["id"] > 0){
    $cliente->obtenerPorId();
}
if(isset($_GET["do"]) && $_GET["do"] == "cargarGrilla"){
  $idCliente = $_GET['idCliente'];
  $request = $_REQUEST;

  $entidad = new Domicilio();
  $aDomicilio = $entidad->obtenerFiltrado($idCliente);

  $data = array();

  $inicio = $request['start'];
  $registros_por_pagina = $request['length'];

  if (count($aDomicilio) > 0)
      $cont=0;
      for ($i=$inicio; $i < count($aDomicilio) && $cont < $registros_por_pagina; $i++) {
          $row = array();
          $row[] = $aDomicilio[$i]->tipo;
          $row[] = $aDomicilio[$i]->provincia;
          $row[] = $aDomicilio[$i]->localidad;
          $row[] = $aDomicilio[$i]->domicilio;
          $cont++;
          $data[] = $row;
      }

  $json_data = array(
      "draw" => intval($request['draw']),
      "recordsTotal" => count($aDomicilio), //cantidad total de registros sin paginar
      "recordsFiltered" => count($aDomicilio),//cantidad total de registros en la paginacion
      "data" => $data
  );
  echo json_encode($json_data);
  exit;
}

$provincia = new Provincia();
$aProvincias = $provincia->obtenerTodos();

include_once("menu.php")


?>


        <!-- Begin Page Content -->
        <form action="" method="POST">
      <div class="container-fluid">
      <h1 class="h3 mb-4 text-gray-800">Cliente</h1>
      <div class="row">
      <div class="col-12 mb-3">
          <a href="fclientes.php" class="btn btn-primary mr-2">Nuevo</a>
          <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
          <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
      </div>
  </div>
  <div class="row">
      <div class="col-6 form-group">
          <label for="txtNombre">Nombre:</label>
          <input type="text" required="" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $cliente->nombre ?>">
      </div>
      <div class="col-6 form-group">
          <label for="txtCantidad">CUIT:</label>
          <input type="number" required="" class="form-control" name="txtCuit" id="txtCuit" value="<?php echo $cliente->cuit ?>" maxlength="11">
      </div>
      <div class="col-6 form-group">
          <label for="txtCantidad">Fecha de nacimiento:</label>
          <input type="date" class="form-control" name="txtFechaNac" id="txtFechaNac" value="<?php echo $cliente->fecha_nac ?>">
      </div>
      <div class="col-6 form-group">
          <label for="txtCantidad">Teléfono:</label>
          <input type="number" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo $cliente->telefono ?>">
      </div>
      <div class="col-6 form-group">
          <label for="txtCorreo">Correo:</label>
          <input type="" class="form-control" name="txtCorreo" id="txtCorreo" required="" value="<?php echo $cliente->correo ?>">
      </div>
  </div>
  <div class="row">
    <div class="col-12">  
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Domicilios
            <div class="pull-right">
              <button type="button" class="btn btn-secondary fa fa-plus-circle" data-toggle="modal" data-target="#modalDomicilio">Agregar</button>
              </div>             
            </div>         
          <div class="panel-body">
          <table id="grilla" class="display" style="width:98%">
<thead>
     <tr>      
     <th>Tipo</th>
     <th>Provincia</th>                               
     <th>Localidad</th>                               
     <th>Dirección</th>                                
      <th></th>                           
       </tr>                        
      </thead>                  
      </table>              
   </div>         
</div>                                                                        
</form>
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
          <a class="btn btn-primary" href="login.php">Cerrar sesion</a>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<form action="" method="POST">
<div class="modal fade" id="modalDomicilio" tabindex="-1" role="dialog" aria-labelledby="modalDomicilioLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDomicilioLabel">Domicilio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col-12 form-group">
                <label for="lstTipo">Tipo:</label>
                <select name="lstTipo" id="lstTipo" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="1">Personal</option>
                    <option value="2">Laboral</option>
                    <option value="3">Comercial</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstProvincia">Provincia:</label>
                <select name="lstProvincia" id="lstProvincia" onchange="fBuscarLocalidad();" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                    <?php foreach($aProvincias as $prov): ?>
                        <option value="<?php echo $prov->idprovincia; ?>"><?php echo $prov->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="lstLocalidad">Localidad:</label>
                <select name="lstLocalidad" id="lstLocalidad" class="form-control">
                    <option value="" disabled selected>Seleccionar</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <label for="txtDireccion">Dirección:</label>
                <input type="text" name="" id="txtDireccion" class="form-control">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="fAgregarDomicilio()">Agregar</button>
      </div>
    </div>
  </div>
</div>
</form>

  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>

$(document).ready( function () {
  var idCliente = '<?php echo isset($cliente) && $cliente->idcliente >0? $cliente->idcliente: 0 ?>';          
  var dataTable = $('#grilla').DataTable({
                  "processing": true,
                  "serverSide": true,               
                   "bFilter": true,
                   "bInfo": true,              
                   "bSearchable": true,
                    "pageLength": 25,               
                    "order": [[ 0, "asc" ]],
                    "ajax": "fclientes.php?do=cargarGrilla&idCliente=" + idCliente  });       
                    } );           
        
        function fBuscarLocalidad(){
            idProvincia = $("#lstProvincia option:selected").val();
            $.ajax({
	            type: "GET",
	            url: "fclientes.php?do=buscarLocalidad",
	            data: { id:idProvincia },
	            async: true,
	            dataType: "json",
	            success: function (respuesta) {
                    $("#lstLocalidad option").remove();
                    $("<option>", {
                        value: 0,
                        text: "Seleccionar",
                        disabled: true,
                        selected: true
                    }).appendTo("#lstLocalidad");
                
                    for (i = 0; i < respuesta.length; i++) {
                        $("<option>", {
                            value: respuesta[i]["idlocalidad"],
                            text: respuesta[i]["nombre"]
                            }).appendTo("#lstLocalidad");
                        }
                    $("#lstLocalidad").prop("selectedIndex", "0");
	            }
	        });
        }

        function fAgregarDomicilio(){
            var grilla = $('#grilla').DataTable();
            grilla.row.add([
                $("#lstTipo option:selected").text() + "<input type='hidden' name='txtTipo[]' value='"+ $("#lstTipo option:selected").val() +"'>",
                $("#lstProvincia option:selected").text() + "<input type='hidden' name='txtProvincia[]' value='"+ $("#lstProvincia option:selected").val() +"'>",
                $("#lstLocalidad option:selected").text() + "<input type='hidden' name='txtLocalidad[]' value='"+ $("#lstLocalidad option:selected").val() +"'>",
                $("#txtDireccion").val() + "<input type='hidden' name='txtDomicilio[]' value='"+$("#txtDireccion").val()+"'>",
                ""
            ]).draw();
            $('#modalDomicilio').modal('toggle');
            limpiarFormulario();
        }

        function limpiarFormulario(){
            $("#lstTipo").val(0);
            $("#lstProvincia").val(0);
            $("#lstLocalidad").val(0);
            $("#txtDireccion").val("");
        }
    </script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
 
 

 