<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1>Grupos</h1>
    </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmGrupos();"><i class="fa fa-plus"></i></button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tblGrupos">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Genero</th>
                                <th>Torneo</th>
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
<div id="nuevoGrupo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Grupo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmGrupos">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" name="status_id" value="1">

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre"
                            placeholder="Nombre de la Ubicación">
                    </div>
                    <div class="form-group">
                        <label for="torneo_id">Torneo</label>
                            <!--Recordar cargar los torneos desde el js  -->
                            <select id="torneo_id" class="form-control" name="torneo_id" required>
                            <option value="" disabled selected>Seleccione un Torneo</option>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="genero">Genero</label>
                        <select id="genero" class="form-control" name="genero" required>
                            <option value="" disabled selected>Seleccione un Género</option>
                           
                        </select>
                    </div>

                    <button class="btn btn-primary" type="button" onclick="registrarGrupo(event);"
                        id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>