<?php require_once 'includes/headerAdmin.php';
      require_once '../Modelo/conexionA.php';
      require_once '../Controlador/Table.php';

      $conexion = new Conexion();

      if(isset($_POST['Nombre_Campo'])){
         $datos = array($_POST['Nombre_Campo'],
                        $_POST['Estado'],
                        $_POST['Municipio'],
                       );
         $sql_incluir = "INSERT INTO direcciones (idParroquia ,Direccion) VALUES (?,?)";
         $conexion->agregar($sql_incluir, array( $_POST['Parroquia'], $_POST['Direccion']));
         $sql_leer = "SELECT idDireccion FROM direcciones WHERE idParroquia = ? AND Direccion = ?";
         $r = $conexion->consultar($sql_leer, array( $_POST['Parroquia'], $_POST['Direccion']));
         $s = $r[0];
         $sql_incluir = "INSERT INTO campos (idDireccion, Campo) VALUES (?,?)";
         $conexion->agregar($sql_incluir, array($s['idDireccion'], $_POST['Nombre_Campo'])); 
      }


?>
<!-- CONTENIDO DE LA PAG -->
<!-- con las columnas que sobraron hacemos una nueva columna que abarcara 10  que es
donde se colocara el contenido de la pag-->
<div class="col fondo">
   <div class="row" >
      <div class="col-12 mt-3">
         <a href="#menu" class=" btn btn-info icon-play" aria-expanded="false" aria-controls="menu" data-toggle="collapse">Ocultar</a>
      </div>
      <div class="col-12">
         <div class="card mt-3">
            <div class="card-header">
               <div class="row justify-content-between">
                  <div class="col-auto">
                     <h5><i class="fas fa-greater-than-equal" style="position: relative; top: .1em;"></i>Campos Agregados</h5>
                  </div>
                  <div class="col-4">
                     <a href="#AgregarCampo" class="btn b1 b1-info btn-block"><i class="fas fa-share fa-lg mr-2" style="position: relative; top: .1em; text-shadow: 1px 1px 1px #000"></i>Agregar</a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="col-12">
                  <table class="table table-bordered table-sm table-hover table-responsive-sm">
                     <thead class="table-primary">
                        <th>Campo</th>
                        <th>Estado</th>
                        <th>Municipio</th>
                        <th>Parroquia</th>
                        <th>Dirección</th>
                     </thead>
                     <tbody>
                        <?php 

                           $sql_leer = "SELECT c.campo, e.Estado, m.Municipio, p.Parroquia, d.Direccion 
                                          FROM campos c 
                                          INNER JOIN direcciones d ON d.idDireccion = c.idDireccion 
                                          INNER JOIN parroquia p ON p.idParroquia = d.idParroquia 
                                          INNER JOIN municipios m ON m.idMunicipio = p.idMunicipio 
                                          INNER JOIN estados e ON e.idEstado = m.idEstado";
                           $resul = $conexion->consultar($sql_leer, array(''));
                           addItemAdmin($resul);
                        ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row mt-3">
      <div class="col-12">
         <div class="card" id="AgregarCampo">
            <div class="card-header">
               <h5><svg class="bi bi-folder-plus" width="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.828 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91H9v1H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H9.828zm-2.95-1.707L7.587 3H2.19c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293z"/><path fill-rule="evenodd" d="M13.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/><path fill-rule="evenodd" d="M13 12.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/></svg>Agregar Campo</h5>
            </div>
            <div class="card-body">
               <form method="POST">
                  <div class="form-group row">
                     <div class="col-7 col-md-3 mb-1">
                        <label for="Nombre_Campo">Nombre del Campo</label>
                        <input type="text" class="form-control" name="Nombre_Campo" required id="Nombre_Campo">
                     </div>
                     <div class="col-5 col-md-3 mb-1">
                        <label for="Estado">Estado</label>
                        <select class="form-control" id="Estado" name="Estado">
                           <?php    
                              $sql_leer = "select idEstado, Estado from estados";
                              $resul = $conexion->consultar($sql_leer, array(''));
                              foreach ($resul as $campo) {
                                 echo '<option value="'.$campo['idEstado'].'">'.$campo['Estado'].'</option>';
                              }
                            ?>
                        </select>
                     </div>
                     <div class="col-6 col-md-3">
                        <label for="Municipio">Municipio</label>
                        <select class="form-control" id="Municipio" name="Municipio">
                           <?php    
                              $sql_leer = "select idMunicipio, Municipio from Municipios";
                              $resul = $conexion->consultar($sql_leer, array(''));
                              foreach ($resul as $campo) {
                                 echo '<option value="'.$campo['idMunicipio'].'">'.$campo['Municipio'].'</option>';
                              }
                            ?>
                        </select>
                     </div>
                     <div class="col-6 col-md-3">
                        <label for="Parroquia">Parroquia</label>
                        <select class="form-control" id="Parroquia" name="Parroquia">
                           <?php    
                              $sql_leer = "select idParroquia, Parroquia from Parroquia";
                              $resul = $conexion->consultar($sql_leer, array(''));
                              foreach ($resul as $campo) {
                                 echo '<option value="'.$campo['idParroquia'].'">'.$campo['Parroquia'].'</option>';
                              }
                            ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row justify-content-end">
                     <div class="col-5 align-self-md-center">
                        <button type="submit" class="btn b1 b1-primary btn-block"> <i class="icon-mas fa-lg" style="text-shadow: 1px 1px 1px #000"></i> Aceptar</button>
                     </div>
                     <div class="col-7">
                        <textarea class="form-control" name="Direccion" id="Direccion" placeholder="Ingrese la Dirección del Campo por favor" maxlength="40" required cols="60" rows="3"></textarea>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>