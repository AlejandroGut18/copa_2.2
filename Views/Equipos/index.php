<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1>Tabla Equipos</h1>
    </div>
</div>
<button class="btn btn-new mb-2" type="button" onclick="frmEquipos();"><i class="fa fa-plus"></i>Agregar</button>
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
                                <th>Tipo</th>
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
<div id="nuevoEquipo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
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
                            oninput="this.value = this.value.replace(/[^a-zA-ZÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                            placeholder="Nombre del Equipo">
                    </div>
                    <div class="form-group">
                        <label for="genero">Género de Equipo</label>
                        <select id="genero" class="form-control" name="genero" required>
                            <option value="" disabled selected>Seleccione un Género</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="delegado">Delegado</label>
                        <select id="delegado" class="form-control select-alto" name="delegado" required>
                            <option value="" disabled selected>Seleccione un Delegado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_equipo">Tipo de Equipo</label>
                        <select id="tipo_equipo" name="tipo_equipo" class="form-control">

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
<script src="<?php echo base_url; ?>Assets/js/equipos.js"></script>

<style>

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