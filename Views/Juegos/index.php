<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
  <div>
    <h1> Tabla de Juegos</h1>
  </div>
</div>



<div class="d-flex justify-content-end mb-3">
  <?php if ($_SESSION['rol_id'] == ROL_ADMIN || $_SESSION['rol_id'] == ROL_ADMINISTRADOR): ?>
    <button class="btn btn-success" data-toggle="modal" data-target="#modalGenerarEnfrentamientos">
      Generar enfrentamientos
    </button>
  <?php endif; ?>

</div>


<!-- <button class="btn btn-new mb-2" type="button" onclick="frmJuegos()"><i class="fa fa-plus"></i>Agregar</button> -->
<!-- card shadow-sm p-3 mb-3 border rounded -->
<div class="container-fluid px-0 mb-2">
  <div class="row align-items-end" style="gap: 0.25rem 0;">

    <div class="col-md-3 mb-1">
      <label for="filtro_torneo_juego" class="mb-1">Torneo:</label>
      <select id="filtro_torneo_juego" class="form-control form-control-sm"></select>
    </div>

    <div class="col-md-2 mb-1">
      <label for="filtro_genero_juego" class="mb-1">Género del Equipo:</label>
      <select id="filtro_genero_juego" name="filtro_genero_juego" class="form-control form-control-sm">
        <option value="">Todos</option>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
      </select>
    </div>

    <div class="col-md-3 mb-1">
      <label for="filtro_equipo_juego" class="mb-1">Equipo:</label>
      <select id="filtro_equipo_juego" class="form-control form-control-sm">
        <option value="">Todos</option>
      </select>
    </div>

    <div class="col-md-2 mb-1">
      <label for="filtro_estado_juego" class="mb-1">Estado:</label>
      <select id="filtro_estado_juego" class="form-control form-control-sm">
        <option value="">Todos</option>
        <option value="3">Pendiente</option>
        <option value="5">Culminado</option>
      </select>
    </div>

    <div class="col-md-2 mb-1 d-flex flex-nowrap">
      <button class="btn btn-filter btn-sm mr-2 d-flex align-items-center flex-fill" onclick="filtrarJuegos()"
        style="min-width: 0;">
        <i class="fa fa-filter mr-1"></i>
        <span>Filtrar</span>
      </button>
      <button class="btn btn-clean btn-sm d-flex align-items-center flex-fill" onclick="limpiarFiltrosJuegos()"
        style="min-width: 0;">
        <i class="fa fa-eraser mr-1"></i>
        <span>Limpiar</span>
      </button>
    </div>

  </div>
</div>


<div class="row">
  <div class="col-lg-12">
    <div class="tile">
      <div class="tile-body">
        <div class="table-responsive">
          <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblJuegos">
            <thead class="thead-dark">
              <tr>
                <th>Id</th>
                <th>Torneo</th>
                <th>Equipo1</th>
                <th>Puntos</th>
                <th>Equipo2</th>
                <th>Puntos</th>
                <th>Genero</th>
                <th>Fecha</th>
                <th>Hora</th>
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

<!-- ///// -->
<!-- Modal ingresar -->
<!-- ///// -->
<!-- <div id="nuevoJuego" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title text-white" id="title">Registro de Juego</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="tab-content mt-3" id="tabsJuegoContent">
          <div class="tab-pane fade show active" id="datos" role="tabpanel">
            <form id="frmJuegos">
              <input type="hidden" id="id" name="id">
              <div class="form-group">
                <label for="torneo_id">Torneo</label>
                Recordar cargar los torneos desde el js  -->
<!-- <select id="torneo_id" class="form-control" name="torneo_id" required>
                  <option value="" disabled selected>Seleccione un Torneo</option>
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="genero">Género</label>
                    <select id="genero" class="form-control select2" name="genero" required
                      onchange="actualizarFiltrosJuegos()">
                      <option value="" disabled selected>Seleccione un Género</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="grupo_id">Grupo</label>
                    <select id="grupo_id" class="form-control" name="grupo_id" required
                      onchange="actualizarFiltrosJuegos()">
                      <option value="" disabled selected>Seleccione un Grupo</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="equipo_id">Equipo 1</label>
                    <select id="equipo_id" class="form-control select2" name="equipo_id" required>
                      <option value="" disabled selected>Seleccione un equipo</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="vs_equipo_id">Equipo 2</label>
                    <select id="vs_equipo_id" class="form-control select2" name="vs_equipo_id" required>
                      <option value="" disabled selected>Seleccione un equipo</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha">Fecha del juego</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="hora">Hora del juego</label>
                    <input type="time" class="form-control" id="hora" name="hora" required>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="text-right mt-3">
            <button class="btn btn-primary" type="button" onclick="registrarJuego(event);"
              id="btnAccion">Registrar</button>
            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div> -->
<!-- ////////////////// -->
<div class="modal fade" id="modalEditarJuego" tabindex="-1" role="dialog" aria-labelledby="modalEditarJuegoLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form id="formEditarJuego" onsubmit="actualizarJuego(event)">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalEditarJuegoLabel">
            <i class="fa fa-clock-o mr-2"></i>Asignar Fecha y Hora del Juego
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Vista previa del enfrentamiento -->
        <div class="p-3 border-bottom text-center">
          <div class="row align-items-center">
            <div class="col-4 text-center">
              <img id="logo_equipo1" src="" alt="Logo Equipo 1" class="img-fluid rounded" style="height: 50px;">
              <p id="nombre_equipo1" class="mt-2 font-weight-bold mb-0 small text-truncate"></p>
            </div>
            <div class="col-4 text-center">
              <span class="font-weight-bold">VS</span>
            </div>
            <div class="col-4 text-center">
              <img id="logo_equipo2" src="" alt="Logo Equipo 2" class="img-fluid rounded" style="height: 50px;">
              <p id="nombre_equipo2" class="mt-2 font-weight-bold mb-0 small text-truncate"></p>
            </div>
          </div>
        </div>

        <!-- Campos fecha y hora -->
        <div class="modal-body">
          <input type="hidden" id="juego_id" name="juego_id">

          <div class="form-group">
            <label for="fecha_juego">Fecha:</label>
            <input type="date" id="fecha_juego" name="fecha" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="hora_juego">Hora:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
              </div>
              <input type="time" id="hora_juego" name="hora" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="fa fa-save mr-1"></i>Guardar
          </button>
          <button type="button" class="btn btn-close" data-dismiss="modal">
            <i class="fa fa-times mr-1"></i>Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!--///////////////// ///////////////////// -->
<!--  modal para actualizar resultados -->
<!-- /////////////////////////////////// -->
<div class="modal fade" id="modalActualizarPuntos" tabindex="-1" role="dialog"
  aria-labelledby="modalActualizarPuntosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form id="formActualizarPuntos" onsubmit="guardarDetalleJuego(event)">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalActualizarPuntosLabel">
            <i class="fa fa-futbol-o mr-2"></i>Recopilación del Juego
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Encabezado: Equipos y logos -->
          <div class="text-center mb-3">
            <img id="logo_equipo1_detalle" src="" alt="Logo Equipo 1" width="50" height="50" class="mr-2" />
            <strong id="nombre_equipo1_detalle"></strong>
            <span class="mx-3">VS</span>
            <strong id="nombre_equipo2_detalle"></strong>
            <img id="logo_equipo2_detalle" src="" alt="Logo Equipo 2" width="50" height="50" class="ml-2" />
          </div>

          <!-- Inputs ocultos -->
          <input type="hidden" id="juego_id_detalle" name="juego_id">
          <input type="hidden" id="inscripcion_equipo1_id" name="inscripcion_equipo1_id">
          <input type="hidden" id="inscripcion_equipo2_id" name="inscripcion_equipo2_id">

          <!-- Puntos -->
          <div class="row mb-4">
            <div class="col-md-6">
              <label><strong>Puntos Equipo 1</strong></label>
              <input type="number" name="puntos_equipo1" id="puntos_equipo1" class="form-control" min="0" max="100"
                required>
            </div>
            <div class="col-md-6">
              <label><strong>Puntos Equipo 2</strong></label>
              <input type="number" name="puntos_equipo2" id="puntos_equipo2" class="form-control" min="0" max="100"
                required>
            </div>
          </div>

          <!-- Planilla jugadores -->
          <div class="row">
            <!-- Equipo 1 -->
            <div class="col-md-6">
              <div class="text-center mb-2">
                <strong id="nombre_equipo1_titulo" class="text-primary h6"></strong>
              </div>
              <div class="table-responsive">
                <table class="table table-sm table-bordered" id="tablaJugadoresEquipo1">
                  <thead class="thead-light">
                    <tr>
                      <th>Jugador</th>
                      <th>AL</th>
                      <th>AB</th>
                      <th>BL</th>
                      <th>BB</th>
                      <th>RL</th>
                      <th>RB</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyJugadoresEquipo1">
                    <!-- Cargado dinámicamente -->
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Equipo 2 -->
            <div class="col-md-6">
              <div class="text-center mb-2">
                <strong id="nombre_equipo2_titulo" class="text-danger h6"></strong>
              </div>
              <div class="table-responsive">
                <table class="table table-sm table-bordered" id="tablaJugadoresEquipo2">
                  <thead class="thead-light">
                    <tr>
                      <th>Jugador</th>
                      <th>AL</th>
                      <th>AB</th>
                      <th>BL</th>
                      <th>BB</th>
                      <th>RL</th>
                      <th>RB</th>
                    </tr>
                  </thead>
                  <tbody id="tbodyJugadoresEquipo2">
                    <!-- Cargado dinámicamente -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="fa fa-save mr-1"></i>Guardar
          </button>
          <button type="button" class="btn btn-close" data-dismiss="modal">
            <i class="fa fa-times mr-1"></i>Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- ///////////////////////////////////////////////////////////////// -->
<!-- modal de asignar enfrentamientos -->
<!-- //////////////////////////////////////////////////////////////////// -->

<div id="modalGenerarEnfrentamientos" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Generar Enfrentamientos</h5>
        <button class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="frmGenerarJuegos">
          <div class="form-group">
            <label for="torneo_juego">Torneo</label>
            <select id="torneo_juego" name="torneo_id" class="form-control" onchange="actualizarEquiposPorGrupo()"
              required></select>
          </div>

          <div class="form-group">
            <label>Género</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="genero" value="M"
                onchange="actualizarEquiposPorGrupo()" required>
              <label class="form-check-label">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="genero" value="F"
                onchange="actualizarEquiposPorGrupo()">
              <label class="form-check-label">Femenino</label>
            </div>
          </div>

          <div id="contenedorEquiposPorGrupo" class="row"></div>
        </form>
      </div>
      <div class="text-right mb-3 mr-3">
        <button class="btn btn-primary" onclick="generarEnfrentamientos()">Generar</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>







<style>
  .modal-backdrop.show {
    opacity: 0.8 !important;
    /* Hace el fondo más visible */
    z-index: 1040 !important;
    /* Asegura que esté detrás del modal */
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    cargarTorneos("", "filtro_torneo_juego", true);
    cargarTorneos("", "torneo_juego", true);
  });
</script>

<script src="<?php echo base_url; ?>Assets/js/juegos.js"></script>


<?php include "Views/Templates/footer.php"; ?>