<!-- Views/Calendario/index.php -->

<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
  <div>
    <h1>Calendario Copa</h1>
  </div>
</div>
<!-- Estilos solo de FullCalendar v6 -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.css' rel='stylesheet' />
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/multi-month/main.min.css' rel='stylesheet' />



<div id="calendar" style="padding: 20px; background: #fff;"></div>

<!-- Modal para información del evento -->
<div class="modal fade" id="eventoModal" tabindex="-1" role="dialog" aria-labelledby="eventoModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventoModalLabel">Información del Evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>Nombre:</strong> <span id="eventoNombre"></span></p>
        <p><strong>Fecha inicio:</strong> <span id="eventoInicio"></span></p>
        <p><strong>Fecha fin:</strong> <span id="eventoFin"></span></p>
        <p><strong>Sede:</strong> <span id="eventoSede"></span></p>
        <p><strong>Estado:</strong> <span id="eventoEstado"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-close" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
  .fc-event {
    height: 15px !important;
    line-height: 6px;
    font-size: 0.7rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 0 !important;
    margin: 0 0 2px 0 !important;
    cursor: pointer;
  }

  .fc-multi-month-view .fc-event {
    height: 15px !important;
    cursor: pointer;
  }
</style>




<!-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/multi-month/main.global.min.js'></script> -->
<!-- No necesitas un CSS separado -->
<script src="<?php echo base_url; ?>Assets/js/calendario.js"></script>
<script src="<?php echo base_url; ?>Assets/fullcalendar/index.global.min.js"></script>


<?php include "Views/Templates/footer.php"; ?>