<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1> Ubicaciones</h1>
    </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmUbicacion();"><i class="fa fa-plus"></i>Agregar</button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblUbicacion">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Sede</th>
                                <th>Dirección</th>
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
<div id="nuevaUbicacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Ubicación</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmUbicacion">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" name="status_id" value="1">


                    <div class="form-group">
                        <label for="nombre">Sede</label>
                        <input id="nombre" class="form-control" type="text" name="nombre"
                            placeholder="Nombre de la Sede"
                            oninput="this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '')">

                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input id="direccion" class="form-control" type="text" name="direccion"
                            placeholder="Ingrese la direccion" autocomplete="off">
                    </div>


                    <button class="btn btn-primary" type="button" onclick="registrarUbic(event);"
                        id="btnAccion">Registrar</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url; ?>Assets/js/ubicaciones.js"></script>

<?php include "Views/Templates/footer.php"; ?>