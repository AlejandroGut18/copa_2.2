<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
  <div>
    <h1> Tabla de Juegos</h1>
  </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmJuegos()"><i class="fa fa-plus"></i></button>
<div class="row">
  <div class="col-lg-12">
    <div class="tile">
      <div class="tile-body">
        <div class="table-responsive">
          <table class="table table-light mt-4" id="tblJuegos">
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
<div id="nuevoJuego" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
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
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="torneo_id">Torneo</label>
                    <select id="torneo_id" class="form-control" name="torneo_id" onchange="actualizarFiltrosJuegos()">
                      <option value="" disabled selected>Seleccione un Torneo</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="genero">Género</label>
                    <select id="genero" class="form-control select2" name="genero" required
                      onchange="actualizarFiltrosJuegos()">
                      <option value="" disabled selected>Seleccione un Género</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="grupo_id">Grupo</label>
                    <select id="grupo_id" class="form-control" name="grupo_id" required
                      onchange="actualizarFiltrosJuegos()">
                      <option value="" disabled selected>Seleccione un Grupo</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="status_id">Estado</label>
                    <select id="status_id" class="form-control" name="status_id" required>
                      <option value="3" selected>Pendiente</option>
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
  </div>
  <!-- ////////////////// -->
</div>
<div id="actualizarPuntos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title text-white" id="title">Actualizar</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmPuntos">
          <input type="hidden" id="juego_id" name="juego_id">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="act_equipo_id">Equipo 1</label>
                <select id="act_equipo_id" class="form-control select2" name="act_equipo_id" required disabled>
                  <option value="" disabled selected>Seleccione un equipo</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="puntos_equipo">Puntos Equipo 1</label>
                <input type="number" class="form-control" id="puntos_equipo" name="puntos_equipo" min="0" value="0"
                  max="100">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="act_vs_equipo_id">Equipo 2</label>
                <select id="act_vs_equipo_id" class="form-control select2" name="act_vs_equipo_id" required disabled>
                  <option value="" disabled selected>Seleccione un equipo</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="puntos_vs_equipo">Puntos Equipo 2</label>
                <input type="number" class="form-control" id="puntos_vs_equipo" name="puntos_vs_equipo" min="0"
                  value="0" max="100">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="text-right mt-3">
        <button class="btn btn-primary" type="button" onclick="registrarPuntos(event);"
          id="btnAccion">Actualizar</button>
        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
<style>
  .modal-backdrop.show {
    opacity: 0.8 !important; /* Hace el fondo más visible */
    z-index: 1040 !important; /* Asegura que esté detrás del modal */
}
</style>


  <?php include "Views/Templates/footer.php"; ?>