let tblAuditoria;
document.addEventListener("DOMContentLoaded", function () {
    const language = {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      infoEmpty: "Mostrando 0 a 0 de 0 entradas",
      infoFiltered: "(filtrado de _MAX_ entradas totales)",
      lengthMenu: "Mostrar _MENU_ entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "No se encontraron resultados",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior"
      }
    };
  
    const buttons = [
      {
        extend: "excel",
        footer: true,
        title: "Auditoría",
        filename: "Auditoria_Export",
        text: '<i class="icon fa fa-file-excel-o"></i> Excel',
        className: "btn btn-outline-success buttons-excel btn-sm mr-2 dt-btn sec"
      },
      {
        extend: "print",
        footer: true,
        title: "Auditoría",
        filename: "Auditoria_Print",
        text: '<i class="fa fa-print mr-1"></i> Imprimir',
        className: "btn btn-outline-p buttons-print btn-sm dt-btn sec"
      }
    ];
  
    tblAuditoria = $("#tblAuditoria").DataTable({
      ajax: {
        url: base_url + "Auditoria/listar", // Asegúrate de tener este método en el controlador
        dataSrc: ""
      },
      columns: [
        { data: "id" },
        { data: "usuario" },
        { data: "accion" },
        { data: "detalle" },
        { data: "fecha" }
      ],
      responsive: true,
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
      language,
      dom:
        "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons,
      initComplete: function () {
        const $botones = this.api().buttons().container();
        $botones.before(
          '<label class="mb-1 font-weight-bold d-block">Exportar <span> / Imprimir<span></label>'
        );
        $botones.find(".dt-btn").css({
          borderRadius: "24px"
        });
      }
    });
  });
  