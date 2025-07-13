<?php include "Views/Templates/header.php";

?>

<div class="app-title">
    <div>
        <h1> Tabla de Torneos</h1>
    </div>
</div>


<button class="btn btn-new mb-2" type="button" onclick="frmTorneo()"><i class="fa fa-plus"></i>Agregar</button>
<div class="row mb-3 align-items-end">
    <div class="col-md-6">
        <div class="form-row">
            <div class="col-6">
                <div class="form-group mb-0">
                    <label for="filtro_fecha_desde"> Fecha Desde:</label>
                    <input type="date" id="filtro_fecha_desde" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-0">
                    <label for="filtro_fecha_hasta"> Fecha Hasta:</label>
                    <input type="date" id="filtro_fecha_hasta" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mb-0">
            <label for="filtro_estado">Estado:</label>
            <select id="filtro_estado" class="form-control">
                <option value="">Todos</option>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mb-0 d-flex align-items-end" style="width:100%;">
            <button class="btn btn-filter mr-2 flex-fill" type="button" onclick="filtrarTorneos()"><i
                    class="fa fa-filter"></i> Filtrar</button>
            <button class="btn btn-clean flex-fill" type="button" onclick="limpiarFiltros()"><i
                    class="fa fa-eraser"></i> Limpiar</button>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblTorneos">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Sede</th>
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
<div id="nuevoTorneo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
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
                                <input id="nombre" class="form-control" type="text" name="nombre" required
                                oninput="this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '')" placeholder="Nombre del torneo">
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
                                <label for="ubicacion_id">Sede</label>
                                <select id="ubicacion_id" class="form-control" name="ubicacion_id" required>
                                    <option value="" selected disabled>Selecione una Sede</option>
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
                                <button class="btn btn-primary" type="submit" onclick="registrarTorneo(event)"
                                    id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Atras</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url; ?>Assets/js/torneos.js"></script>

<?php include "Views/Templates/footer.php"; ?>