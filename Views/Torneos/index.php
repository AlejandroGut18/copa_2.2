<?php include "Views/Templates/header.php";

?>

<div class="app-title">
    <div>
        <h1> Tabla de Torneos</h1>
    </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmTorneo()"><i class="fa fa-plus"></i></button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblTorneos">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Ubicación</th>
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
<div id="nuevoTorneo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Torneo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="frmTorneo">
                    <div class="row">
                        <!-- Campo Oculto para ID -->
                        <input type="hidden" id="id" name="id">
                        
                        <!-- Nombre del Torneo -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre">Nombre del Torneo</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" required placeholder="Nombre del torneo">
                            </div>
                        </div>
                        
                        <!-- Fecha Inicio y Fecha Fin -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha Inicio</label>
                                <input id="fecha_inicio" class="form-control" type="date" name="fecha_inicio" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Fin (Opcional)</label>
                                <input id="fecha_fin" class="form-control" type="date" name="fecha_fin">
                            </div>
                        </div>
                        
                        <!-- Ubicación -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ubicacion_id">Ubicación</label>
                                <select id="ubicacion_id" class="form-control" name="ubicacion_id" required>
                                    <option value="" selected disabled >Selecione un Ubicacion</option>
                                    <!-- Las opciones se cargarán dinámicamente con JavaScript -->
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_id">Estado</label>
                                <select id="status_id" class="form-control" name="status_id" required>
                                    <option value="1" selected>Activo</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <button class="btn btn-primary" type="submit" onclick="registrarTorneo(event)" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Atras</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>