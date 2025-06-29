<?php include "Views/Templates/header.php";
include "Controllers/Grupos.php";
echo "";
?>

<div class="app-title">
    <div>
        <h1> Equipos Inscritos</h1>
    </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmInscripcion()"><i class="fa fa-plus"></i></button>
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
                        <label for="genero">Genero</label>
                        <select id="genero" class="form-control" name="genero" required onchange="actualizarFiltros()">
                            <option value="" disabled selected>Seleccione un Género</option>

                        </select>
                    </div>
                    <div class="form-group">

                        <label for="grupo_id">Grupo (Opcional)</label>
                        <small class="form-text text-muted">
                            La Asigancion de grupo es opcinal, puede ser asignado después
                        </small>
                        <select id="grupo_id" class="form-control" name="grupo_id">
                            <option value="" disabled selected>Seleccione un Grupo</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="equipo_id">Equipos</label>
                        <select id="equipo_id" class="form-control" name="equipo_id" required>
                            <option value="" disabled selected>Seleccione un Equipo</option>

                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="delegado">Jugador</label>
                            <select id="jugador" class="form-control" name="jugador" required >
                            <option value="" disabled selected>Seleccione un Jugador</option>
                            
                        </select>
                    </div> -->


                    <button class="btn btn-primary" type="button" onclick="registrarInscripcion(event);"
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