<?php include "Views/Templates/header.php";
include "Controllers/Grupos.php";
echo "";
require_once __DIR__ . '/../../Config/Config.php';

?>

<div class="app-title">
  <div>
    <h1> Inscripción de Equipos</h1>
  </div>
</div>
<div class="card shadow-sm p-3 mb-3 border rounded">
  <div class="row align-items-end">

    <div class="col-md-3 mb-2">
      <label for="filtro_torneo">Torneo:</label>
      <select id="filtro_torneo" class="form-control">
      </select>
    </div>

    <div class="col-md-2 mb-2">
      <label for="filtro_genero">Género:</label>
      <select id="filtro_genero" name="filtro_genero" class="form-control">
        <option value="">Todos</option>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
      </select>
    </div>


    <div class="col-md-2 mb-2">
      <label for="filtro_grupo">Grupo:</label>
      <select id="filtro_grupo" class="form-control">
        <option value="">Todos</option>
        <option value="A">Grupo A</option>
        <option value="B">Grupo B</option>
        <option value="C">Grupo C</option>
        <option value="D">Grupo D</option>
      </select>
    </div>

    <div class="col-md-2 mb-2">
      <label for="filtro_estado">Estado:</label>
      <select id="filtro_estado" class="form-control">
        <option value="">Todos</option>
        <option value="1">Activo</option>
        <option value="2">Inactivo</option>
      </select>
    </div>

    <div class="col-md-3 d-flex align-items-end mb-2">
      <button class="btn btn-filter d-flex align-items-center justify-content-center flex-fill mr-2"
        onclick="filtrarInscripciones()">
        <i class="fa fa-filter mr-1"></i> Filtrar
      </button>
      <button class="btn btn-clean d-flex align-items-center justify-content-center flex-fill"
        onclick="limpiarFiltrosInscripciones()">
        <i class="fa fa-eraser mr-1"></i> Limpiar
      </button>
    </div>


  </div>
</div>
<div class="d-flex align-items-center gap-2 mb-3">
  <?php if ($_SESSION['rol_id'] == ROL_ADMINISTRADOR || $_SESSION['rol_id'] == ROL_ADMIN): ?>
    <button class="btn btn-success" data-toggle="modal" data-target="#modalAsignarGrupos">
      <i class="fa fa-random mr-1"></i> Asignar equipos a grupos
    </button>
  <?php endif; ?>

  <button class="btn btn-new" type="button" onclick="frmInscripcion()">
    <i class="fa fa-plus mr-1"></i> Agregar
  </button>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="tile">
      <div class="tile-body">
        <div class="table-responsive">
          <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblInscripciones">
            <thead class="thead-dark">
              <tr>
                <th>Id</th>
                <th>Torneo</th>
                <th>Equipo</th>
                <th>Grupo</th>
                <th>Género</th>
                <th>Fecha de Inscripción</th>
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
<div id="inscribir_equipo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="title">Inscribir Equipo</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="frmInscripcion">
          <input type="hidden" id="id" name="id">
          <input type="hidden" id="status_id" name="status_id" value="1">
          <div class="form-group">
            <label for="torneo_id">Torneo</label>
            <!--Recordar cargar los torneos desde el js  -->
            <select id="torneo_id" class="form-control" name="torneo_id" onchange="actualizarFiltros()">
              <option value="" disabled selected>Seleccione un Torneo</option>

            </select>
          </div>
          <div class="form-group">
            <label for="genero">Género</label>
            <select id="genero" class="form-control" name="genero" required onchange="actualizarFiltros()">
              <option value="" disabled selected>Seleccione un Género</option>

            </select>
          </div>

          <div class="form-group">
            <label for="equipo_id">Equipos</label>
            <select id="equipo_id" class="form-control" name="equipo_id" required onchange="actualizarFiltros()">
              <option value="" disabled selected>Seleccione un Equipo</option>

            </select>
          </div>

          <div class="form-group">
            <label>Seleccione los Jugadores del Equipo</label>
            <div id="listaJugadores" class="row">
              <!-- Aquí se agregan los checkboxes dinámicamente -->
            </div>
          </div>


          <button class="btn btn-primary" type="button" onclick="registrarInscripcion(event);"
            id="btnAccion">Registrar</button>
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ///////////////////////////////////////////////////////// -->
<!--  modal editar -->
<!-- /////////////////////////////////////////////////////// -->

<div id="editar_inscripcion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editar-modal-title"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="editar-title">Editar Inscripción</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="frmEditarInscripcion">
          <input type="hidden" id="editar_id" name="id">
          <input type="hidden" id="editar_status_id" name="status_id" value="1">

          <div class="form-group">
            <label for="editar_torneo_id">Torneo</label>
            <select id="editar_torneo_id" class="form-control" name="torneo_id" onchange="actualizarFiltrosEditar()" disabled>
              <option value="" disabled selected>Seleccione un Torneo</option>
              <!-- Opciones se cargan por JS -->
            </select>
            <input type="hidden" name="torneo_id" id="torneo_hidden">

          </div>

          <div class="form-group">
            <label for="editar_genero">Género</label>
            <select id="editar_genero" class="form-control" name="genero" required onchange="actualizarFiltrosEditar()">
              <option value="" disabled selected>Seleccione un Género</option>
            </select>
          </div>

          <div class="form-group">
            <label for="editar_equipo_id">Equipo</label>
            <select id="editar_equipo_id" class="form-control" name="equipo_id" required
              onchange="actualizarFiltrosEditar()">
              <option value="" disabled selected>Seleccione un Equipo</option>
            </select>
          </div>

          <div class="form-group">
            <label>Seleccione los Jugadores del Equipo</label>
            <div id="editar_listaJugadores" class="row">
              <!-- Checkboxes dinámicos -->
            </div>
          </div>

          <button class="btn btn-primary" type="button" onclick="actualizarJuego(event)" id="btnActualizarJuego">
            <i class="fa fa-save mr-1"></i>Guardar
          </button>

          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ver Inscripción -->
<div id="modalVerInscripcion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="verInscripcionLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="contenidoPDFInscripcion">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="verInscripcionLabel">Información de la Inscripción</h5>
        <button class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <p><strong>ID Inscripción:</strong> <span id="ver_inscripcion_id"></span></p> -->
        <p><strong>Torneo:</strong> <span id="ver_torneo"></span></p>
        <p><strong>Género:</strong> <span id="ver_genero"></span></p>
        <p><strong>Equipo:</strong> <span id="ver_equipo"></span></p>
        <p><strong>Estado:</strong> <span id="ver_status_inscripcion"></span></p>
        <hr>
        <h6>Jugadores Asociados</h6>
        <ul id="ver_jugadores" class="list-group">
          <!-- <li> se añadirán con JS -->
        </ul>
      </div>
      <div class="modal-footer">
        <button class="btn btn-close" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" onclick="descargarPDFInscripcion()">Descargar PDF</button>
      </div>
    </div>
  </div>
</div>

<!-- ///////////////////////////////////////////////// -->
<!-- modal para aleatorio -->
<!-- /////////////////////////////////////////////// -->

<div id="modalAsignarGrupos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="asignarGruposTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title text-white" id="asignarGruposTitle">Asignar Equipos a Grupos</h5>
        <button class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmAsignarGrupos">

          <div class="form-group">
            <label for="torneo_grupo">Torneo activo</label>
            <select id="torneo_grupo" name="torneo_id" class="form-control select2" required
              onchange="actualizarEquiposInscritos()">
              <option value="" disabled selected>Seleccione un torneo</option>
            </select>

          </div>

          <div class="form-group">
            <label>Género</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="genero" id="generoM" value="M" required
                onchange="actualizarEquiposInscritos()">
              <label class="form-check-label" for="generoM">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="genero" id="generoF" value="F"
                onchange="actualizarEquiposInscritos()">
              <label class="form-check-label" for="generoF">Femenino</label>
            </div>
          </div>


          <div class="form-group">
            <label>Equipos Inscritos</label>
            <div id="listaEquiposCheckboxes" class="row">
              <!-- Aquí se renderizan los equipos con checkboxes seleccionados automáticamente hasta 24 o 28 -->
            </div>
          </div>
        </form>
      </div>
      <div class="text-right mb-3 mr-3">
        <button class="btn btn-primary" type="button" onclick="asignarEquiposAGrupos()">Asignar</button>
        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
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


  /* Altura total del select */
  .select2-container--default .select2-selection--single {
    height: 35px !important;
    line-height: 44px !important;
    padding: 6px 12px !important;
    display: flex !important;
    align-items: center !important;
  }

  /* Altura del texto interno */
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 44px !important;
    font-size: 15px !important;
  }

  /* Altura del icono de flecha */
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 35px !important;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }

  .select2-container--default .select2-selection--single {
    max-width: 100% !important;
    width: 100% !important;
    box-sizing: border-box !important;
  }
</style>

<?php include "Views/Templates/footer.php"; ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    cargarTorneos("", "filtro_torneo", true);
  });
</script>
<script>
  // Abre el modal y resetea los campos

  // Cargar grupos cuando tanto el torneo como el género estén seleccionados
</script>
<script src="<?php echo base_url; ?>Assets/js/inscripciones.js"></script>