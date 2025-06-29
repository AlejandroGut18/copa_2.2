<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1> Jugadores</h1>
    </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmJugadores();"><i class="fa fa-plus"></i></button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblJugadores">
                        <thead class="thead-dark">
                            <tr>
                                <th>Cedula</th>
                                <th>Nombre Completo</th>
                                <th>Fecha Nacimiento</th>
                                <th>Edad</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Genero</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="nuevoJugador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Jugador</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  <form method="post" id="frmJugadores">
                    <input type="hidden" name="status_id" value="1">
                  
                    <div class="form-group">
                        <label for="nombre">Cedula</label>
                        <input id="cedula" class="form-control" type="text" name="cedula" placeholder="Cedula">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input id="apellido" class="form-control" type="text" name="apellido" placeholder="Apellido">
                    </div>

                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input id="fecha_nacimiento" class="form-control" type="date" name="fecha_nacimiento"
                                required>
                        </div>


                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" class="form-control" type="email" name="email" required>
                        </div>


                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input id="telefono" class="form-control" type="text" name="telefono" pattern="^[0-9]{11}"
                                title="El teléfono debe tener 11 dígitos" required>
                        </div>


                    <div class="form-group">
                        <label for="genero">Genero</label>
                        <select id="genero" class="form-control" name="genero" required>
                            <option value="" disabled selected>Seleccione un Género</option>
                            
                        </select>
                    </div>

                    <button class="btn btn-primary" type="button" onclick="registrarJugador(event);"
                        id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////// -->
 <!-- Modal Editar -->
 <div id="modalEditarJugador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editarJugadorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Editar Jugador</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" id="frmEditarJugador">

          <input type="hidden" name="status_id" id="status_id_editar" value="1">

          <div class="form-group">
            <label for="cedula_editar">Cédula</label>
            <input id="cedula_editar" class="form-control" type="text" name="cedula" readonly>
          </div>

          <div class="form-group">
            <label for="nombre_editar">Nombre</label>
            <input id="nombre_editar" class="form-control" type="text" name="nombre" placeholder="Nombre">
          </div>

          <div class="form-group">
            <label for="apellido_editar">Apellido</label>
            <input id="apellido_editar" class="form-control" type="text" name="apellido" placeholder="Apellido">
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="fecha_nacimiento_editar" >Fecha de Nacimiento</label>
              <input id="fecha_nacimiento_editar" class="form-control" type="date" name="fecha_nacimiento" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="email_editar">Email</label>
              <input id="email_editar" class="form-control" type="email" name="email" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="telefono_editar">Teléfono</label>
              <input id="telefono_editar" class="form-control" type="text" name="telefono" pattern="[0-9]{11}"
                title="El teléfono debe tener 11 dígitos" required>
            </div>
          </div>

          <div class="form-group">
            <label for="genero_editar">Género</label>
            <select id="genero_editar" class="form-control" name="genero" required>
              <option value="" disabled>Seleccione un Género</option>
              <option value="M">Masculino</option>
              <option value="F">Femenino</option>
            </select>
          </div>

          <button class="btn btn-warning" type="button" onclick="actualizarJugador(event);">Modificar</button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>

        </form>
      </div>
    </div>
  </div>
</div>

<?php include "Views/Templates/footer.php"; ?>