/* Assets/js/calendario.js */
document.addEventListener('DOMContentLoaded', function() {
  
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          
          timeZone: 'UTC',
          locale: 'es',
          initialView: 'multiMonthYear',
          views: {
            multiMonthYear: {
              type: 'multiMonth',
              duration: { months: 6 }, // 📅 muestra 6 meses (ajústalo como quieras)
              labelFormat: { year: 'numeric', month: 'short' }
            }
          },
          editable: false,
          events: {
              url: base_url + 'Calendario/getEventosCalendar',
              failure: function () {
                  alert('Error al cargar los torneos');
              }
          },
          eventClick: function(info) {
            // Evita que el navegador siga el enlace
            info.jsEvent.preventDefault();
            // Llena el modal con la información del evento
            document.getElementById('eventoNombre').textContent = info.event.title;
            document.getElementById('eventoInicio').textContent = info.event.startStr;
            document.getElementById('eventoFin').textContent = info.event.endStr || info.event.startStr;
            // Sede y estado desde extendedProps
            document.getElementById('eventoSede').textContent = info.event.extendedProps.sede || '';
            document.getElementById('eventoEstado').textContent = info.event.extendedProps.estado || '';
            // Muestra el modal (requiere Bootstrap JS)
            if (window.$ && $.fn.modal) {
              $('#eventoModal').modal('show');
            } else {
              alert('Nombre: ' + info.event.title + '\nInicio: ' + info.event.startStr + '\nFin: ' + (info.event.endStr || info.event.startStr) + '\nSede: ' + (info.event.extendedProps.sede || '') + '\nEstado: ' + (info.event.extendedProps.estado || ''));
            }
          }
        });




        calendar.render();

        // Reajustar tamaño al cambiar clases del menú
/*         const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'class') {
                    setTimeout(() => calendar.updateSize(), 310);
                }
            });
        });
        observer.observe(document.body, { attributes: true }); */

  
    });
