<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1>Registros de Auditoria</h1>
    </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="tile">
      <div class="tile-body">
        <div class="table-responsive">
          <table class="table table-light mt-4 dataTable no-footer dtr-inline" id="tblAuditoria">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Acción</th>
                <!-- <th>Tabla Afectada</th> -->
                <th>Detalle</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url; ?>Assets/js/auditoria.js"></script>

<?php include "Views/Templates/footer.php"; ?>