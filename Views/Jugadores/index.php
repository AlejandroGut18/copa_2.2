<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
  <div>
    <h1> Jugadores</h1>
  </div>
</div>

<button class="btn btn-new mb-2" type="button" onclick="frmJugadores();"><i class="fa fa-plus"></i>Agregar</button>
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
        <h5 class="modal-title text-white" id="title">Nuevo Jugador</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="post" id="frmJugadores">
          <input type="hidden" name="status_id" value="1">

          <div class="form-group">
            <label for="cedula">Cédula</label>
            <input id="cedula" class="form-control" type="text" name="cedula" placeholder="Cédula"
              oninput="this.value = this.value.replace(/[^0-9]/g, '')">
          </div>

          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre"
              oninput="this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '')">
          </div>

          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input id="apellido" class="form-control" type="text" name="apellido" placeholder="Apellido"
              oninput="this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '')">
          </div>

          <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input id="fecha_nacimiento" class="form-control" type="date" name="fecha_nacimiento" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="form-control" type="email" name="email"
              pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required>
          </div>

          <style>
            .select-codigo {
              width: 120px !important;
            }
          </style>

          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <div class="d-flex align-items-center">
              <select class="form-control select-codigo mr-2" name="codigo" required>
                <option value="+58414">+58 414</option>
                <option value="+58424">+58 424</option>
                <option value="+58412">+58 412</option>
                <option value="+58416">+58 416</option>
                <option value="+58212">+58 212</option>
              </select>
              <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Número (7 dígitos)"
                maxlength="7" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
          </div>




          <div class="form-group">
            <label for="genero">Género</label>
            <select id="genero" class="form-control" name="genero" required onchange="filtrarEquipos()">
              <option value="" disabled selected>Seleccione un Género</option>
              <!-- opciones dinámicas -->
            </select>
          </div>

          <div class="form-group">
            <label>Seleccione los equipos del jugador</label>
            <div id="listaEquipos" class="row">
              <!-- Aquí se cargan los checkboxes dinámicamente -->
            </div>
          </div>

          <button class="btn btn-primary" type="button" onclick="registrarJugador(event);" id="btnAccion">
            Registrar
          </button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- Modal Editar -->
<div id="modalEditarJugador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editarJugadorLabel"
  aria-hidden="true">
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
            <input id="nombre_editar" class="form-control" type="text" name="nombre" placeholder="Nombre"
              oninput="this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '')">
          </div>

          <div class="form-group">
            <label for="apellido_editar">Apellido</label>
            <input id="apellido_editar" class="form-control" type="text" name="apellido" placeholder="Apellido"
              oninput="this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '')">
          </div>

          <div class="form-group">
            <label for="fecha_nacimiento_editar">Fecha de Nacimiento</label>
            <input id="fecha_nacimiento_editar" class="form-control" type="date" name="fecha_nacimiento" required>
          </div>

          <div class="form-group">
            <label for="email_editar">Email</label>
            <input id="email_editar" class="form-control" type="email" name="email"
              pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required>
          </div>

          <style>
            .select-codigo {
              width: 120px !important;
            }
          </style>

          <div class="form-group">
            <label for="telefono_editar">Teléfono</label>
            <div class="d-flex align-items-center">
              <select class="form-control select-codigo mr-2" id="codigo_editar" name="codigo" required>
                <option value="+58414">+58 414</option>
                <option value="+58424">+58 424</option>
                <option value="+58412">+58 412</option>
                <option value="+58416">+58 416</option>
                <option value="+58212">+58 212</option>
              </select>
              <input id="telefono_editar" class="form-control" type="text" name="telefono"
                placeholder="Número (7 dígitos)" maxlength="7" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                required>
            </div>
          </div>

          <div class="form-group">
            <label for="genero_editar">Género</label>
            <select id="genero_editar" class="form-control" name="genero" required onchange="filtrarEquiposEditar()">
              <option value="" disabled selected>Seleccione un Género</option>
              <!-- opciones dinámicas -->
            </select>
          </div>

          <div class="form-group">
            <label>Seleccione los equipos del jugador</label>
            <div id="listaEquiposEditar" class="row">
              <!-- Aquí se agregan los checkboxes dinámicamente -->
            </div>
          </div>

          <button class="btn btn-primary" type="button" onclick="actualizarJugador(event);">Modificar</button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- //////////////////////////////////////////////////////////// -->
<!-- modal de vista -->
<div id="modalVerJugador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="verJugadorLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document"> <!-- QUITÉ modal-lg -->
    <div class="modal-content" id="contenidoPDFJugador">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white">Información del Jugador</h5>
        <button class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p><strong>Cédula:</strong> <span id="ver_cedula"></span></p>
        <p><strong>Nombre:</strong> <span id="ver_nombre"></span></p>
        <p><strong>Apellido:</strong> <span id="ver_apellido"></span></p>
        <p><strong>Fecha de Nacimiento:</strong> <span id="ver_fecha_nacimiento"></span></p>
        <p><strong>Email:</strong> <span id="ver_email"></span></p>
        <p><strong>Teléfono:</strong> <span id="ver_telefono"></span></p>
        <p><strong>Género:</strong> <span id="ver_genero"></span></p>

        <hr>
        <h6>Equipos Asociados</h6>
        <ul id="ver_equipos" class="list-group"></ul>
      </div>

      <div class="modal-footer">
        <button class="btn btn-close" data-dismiss="modal">Cerrar</button>
        <!-- <button class="btn btn-success" onclick="descargarPDFJugador()">Descargar PDF</button> -->
      </div>
    </div>
  </div>
</div>



<style>
  /* Ajusta el tamaño del checkbox */
  .equipo-check {
    transform: scale(0.75);
    vertical-align: middle;
    cursor: pointer;
    margin-right: 4px;
    /* espacio entre checkbox y texto */
  }

  /* Ajusta el texto del label para alinearlo con el checkbox */
  .equipo-check+label {
    vertical-align: middle;
    line-height: 1.2;
    margin-bottom: 0;
  }

  /* Texto verde y negrita cuando está marcado */
  .equipo-check:checked+label {
    color: #28a745;
    font-weight: bold;
  }

  /* Colorea el cuadro del checkbox de verde al seleccionar */
  .equipo-check:checked {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
  }

  /* Transiciones suaves */
  .equipo-check,
  .equipo-check+label {
    transition: all 0.2s ease;
  }
</style>
<script src="<?php echo base_url; ?>Assets/js/jugadores.js"></script>

<?php include "Views/Templates/footer.php"; ?>