<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1>Tabla Equipos</h1>
    </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmEquipos();"><i class="fa fa-plus"></i></button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblEquipos">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Delegado</th>
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
<div id="nuevoEquipo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Equipo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmEquipos">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" name="status_id" value="1">

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre"
                            placeholder="Nombre del Equipo">
                    </div>
                    <div class="form-group">
                        <label for="delegado">Delegado</label>
                            <!--Recordar cargar los torneos desde el js  -->
                            <select id="delegado" class="form-control" name="delegado" required>
                            <option value="" disabled selected>Seleccione un Delegado</option>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="genero">Genero</label>
                        <select id="genero" class="form-control" name="genero" required>
                            <option value="" disabled selected>Seleccione un Género</option>
                            
                        </select>
                    </div>

                    <button class="btn btn-primary" type="button" onclick="registrarEquipo(event);"
                        id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>