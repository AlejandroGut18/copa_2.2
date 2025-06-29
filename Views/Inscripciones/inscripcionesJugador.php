<?php include "Views/Templates/header.php"; ?>

<div class="app-title">
    <div>
        <h1> Jugadores Inscritos</h1>
    </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmInscripcionJugador()"><i class="fa fa-plus"></i>Agregar</button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblInscripcionesJugador">
                        <thead class="thead-dark">
                            <tr>
                                <th>id</th>
                                <th>Torneo</th>
                                <th>Equipo</th>
                                <th>Cedula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
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

<!-- ///// -->
<!-- Modal ingresar -->
<!-- ///// -->
<div id="inscribir_jugador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Inscribir Jugador</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmInscripcionJugador">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" name="inscripcion_id" id="inscripcion_id">

                    <div class="form-group">
                        <label for="torneo">Torneo</label>
                        <select id="torneo_id" class="form-control select2" name="torneo_id" required onchange="actualizarFiltrosJug()">
                            <option value="" disabled select>Seleccione un torneo</option>
                            <!-- Opciones se cargarán dinámicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="genero">Genero</label>
                        <select id="genero" class="form-control" name="genero" required
                            onchange="actualizarFiltrosJug()">
                            <option value="" disabled selected>Seleccione un Género</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="equipo_id">Equipos</label>
                        <select id="equipo_id" class="form-control" name="equipo_id" required onchange="actualizarFiltrosJug()">
                            <option value="" disabled selected>Seleccione un Equipo</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="delegado">Jugador</label>
                        <select id="jugador" class="form-control" name="jugador" required>
                            <option value="" disabled selected>Seleccione un Jugador</option>

                        </select>
                    </div>


                    <button class="btn btn-primary" type="button" onclick="registrarInscJugador(event);"
                        id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>

<script>
    // Abre el modal y resetea los campos

    // Cargar grupos cuando tanto el torneo como el género estén seleccionados
</script>