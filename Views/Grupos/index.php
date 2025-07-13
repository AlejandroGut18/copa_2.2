<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1>Clasificación por Grupos</h1>
    </div>
</div>
<div class="card shadow-sm p-3 mb-4 border rounded">
    <div class="row align-items-end">
        <!-- Torneo -->
        <div class="col-md-3">
            <div class="form-group mb-2">
                <label for="filtro_torneo">Torneo:</label>
                <select id="filtro_torneo" class="form-control" required></select>
            </div>
        </div>

        <!-- Grupo -->
        <div class="col-md-2">
            <div class="form-group mb-2">
                <label for="filtro_grupo">Grupo:</label>
                <select id="filtro_grupo" class="form-control">
                    <option value="">Todos</option>
                    <option value="A">Grupo A</option>
                    <option value="B">Grupo B</option>
                    <option value="C">Grupo C</option>
                    <option value="D">Grupo D</option>
                </select>
            </div>
        </div>
        <!-- Género -->
        <div class="col-md-3">
            <div class="form-group mb-2">
                <label for="filtro_genero">Género:</label>
                <select id="filtro_genero" name="filtro_genero" class="form-control">
                    <option value="">Todos</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
        </div>


        <!-- Botones -->
        <div class="col-md-4 d-flex align-items-end ">
            <button class="btn btn-filter mb-2 mr-2 w-100 d-flex align-items-center justify-content-center"
                onclick="consultarGrupos()">
                <i class="fa fa-search mr-2"></i> Consultar
            </button>
            <button class="btn btn-clean mb-2 w-100 d-flex align-items-center justify-content-center"
                onclick="limpiarFiltroGrupos()">
                <i class="fa fa-eraser mr-2"></i> Limpiar
            </button>

        </div>
    </div>
</div>

<!-- Tabla oculta hasta consultar -->
<div id="contenedorTablaGrupos" style="display: none;">

    <div class="row">

        <div class="col-lg-12">
            <div class="tile">
                <!--                            <div class="d-flex flex-column align-items-center mb-2">
                                    <label class="mb-1 font-weight-bold">Exportar <span> / Imprimir<span></label>
                                    <div>
                                      <button class="btn btn-outline-danger buttons-pdf btn-sm mr-2" style="min-width:120px; border-radius: 20px;" onclick="mostrarModalGrupos()">
                                            <i class="icon fa fa-file-pdf-o"></i> PDF
                                        </button>
                                        <button class="btn btn-outline-success buttons-excel btn-sm mr-2" style="min-width:120px; border-radius: 20px;" id="btnExportarExcelGrupos">
                                            <i class="icon fa fa-file-excel-o"></i> Excel
                                        </button>
                                        <button class="btn btn-outline-p buttons-print btn-sm" style="min-width:120px; border-radius: 20px;" id="btnImprimirGrupos">
                                            <i class="fa fa-print mr-1"></i> Imprimir
                                        </button>
                                    
                                    </div>
                                </div> -->
                <!-- 
                <hr class="w-100 my-3" /> -->
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblGrupos">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Torneo</th>
                                    <th>Grupo</th>
                                    <th>Equipo</th>
                                    <th>Género</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="modalExportarGrupos" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resumen por Grupos</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contenidoModalExportar">
                <!-- Aquí se inyectará la tabla -->
            <!-- </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="exportarPDF()">
                    <i class="fa fa-file-pdf"></i> Descargar PDF
                </button>
            </div>
        </div>
    </div>
</div> --> 



<!-- Al final del body SCRIPTS-->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        cargarTorneos("", "filtro_torneo");
    });
</script>



</body>

</html>

<script src="<?php echo base_url; ?>Assets/js/grupos.js"></script>


<?php include "Views/Templates/footer.php"; ?>