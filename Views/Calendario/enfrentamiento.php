<?php include "Views/Templates/header.php"; ?>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />


<div class="app-title">
    <div>
        <h1>Calendario de Juegos</h1>
    </div>
</div>


<div id='calendarEn' class="app sidebar-mini pace-done sidenav-toggled"></div>

<!-- Modal para mostrar información del evento -->
<div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoModalLabel">Detalle del Partido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <p><strong>Partido:</strong> <span id="modalTitle"></span></p>
                <p><strong>Fecha y Hora:</strong> <span id="modalFecha"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-close" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendarEn');
        var calendarE = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            events: function (fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: base_url + 'Enfrentamiento/getEventosCalendarEnfrentamiento',
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        successCallback(response);
                    },
                    error: function () {
                        failureCallback();
                    },
                    eventColor: ' #3788d8'
                });
            },
            eventClick: function (info) {
                // Mostrar información en el modal
                document.getElementById('modalTitle').textContent = info.event.title;
                var fecha = info.event.start;
                var fechaStr = fecha.toLocaleDateString() + ' ' + fecha.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                document.getElementById('modalFecha').textContent = fechaStr;
                var modal = new bootstrap.Modal(document.getElementById('eventoModal'));
                modal.show();
            }
        });
        calendarE.render();

        var observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'class') {
                    setTimeout(function () {
                        calendarE.updateSize();
                    }, 310);
                }
            });
        });
        observer.observe(document.body, { attributes: true });
    });
</script>
<script src="<?php echo base_url; ?>Assets/js/calendario.js"></script>
<script src="<?php echo base_url; ?>Assets/fullcalendar/index.global.min.js"></script>

<?php include "Views/Templates/footer.php"; ?>