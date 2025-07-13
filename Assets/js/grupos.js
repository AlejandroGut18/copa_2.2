// document.addEventListener("DOMContentLoaded", () => {
//   cargarTorneos("", "filtro_torneo"); // Usa tu función
// });
const buttons = [
  {
    extend: "excel",
    footer: true,
    title: "Archivo",
    filename: "Export_File",
    text: '<i class="icon fa fa-file-excel-o"></i> Excel',
    className: "btn btn-outline-success buttons-excel btn-sm mr-2 dt-btn sec",
    /*   },
  {
    extend: "pdf",
    footer: true,
    title: "Archivo PDF",
    filename: "reporte",
    text: '<i class="icon fa fa-file-pdf-o"></i> PDF',
    className: "btn btn-outline-danger buttons-pdf btn-sm mr-2 dt-btn sec ",
    action: function (e, dt, button, config) {
      mostrarModalGrupos(); // tu función personalizada
    } */
  },
  {
    extend: "print",
    footer: true,
    title: "Reportes",
    filename: "Export_File_print",
    text: '<i class="fa fa-print mr-1"></i> Imprimir',
    className: "btn btn-outline-p buttons-print btn-sm dt-btn sec",
  },
];
const language = {
  decimal: "",
  emptyTable: "No hay información",
  info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
  infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
  infoFiltered: "(Filtrado de _MAX_ total entradas)",
  infoPostFix: "",
  thousands: ",",
  lengthMenu: "Mostrar _MENU_ Entradas",
  loadingRecords: "Cargando...",
  processing: "Procesando...",
  search: "Buscar:",
  zeroRecords: "Sin resultados encontrados",
  paginate: {
    first: "Primero",
    last: "Ultimo",
    next: "Siguiente",
    previous: "Anterior",
  },
};

function consultarGrupos() {
  const torneo = document.getElementById("filtro_torneo").value;
  const genero = document.getElementById("filtro_genero").value; // Ahora select
  const grupo = document.getElementById("filtro_grupo").value;

  if (!torneo) {
    alertas("Debe seleccionar un torneo", "warning");
    return;
  }

  const url = `${base_url}Grupos/listar?torneo=${torneo}&genero=${genero}&grupo=${grupo}`;

  if ($.fn.DataTable.isDataTable("#tblGrupos")) {
    $("#tblGrupos").DataTable().destroy();
  }

  $("#tblGrupos").DataTable({
    ajax: {
      url,
      dataSrc: "",
    },
    columns: [
      { data: "torneo" },
      { data: "grupo" },
      { data: "equipo" },
      { data: "genero" },
      { data: "estado" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[1, "asc"]],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons, // Manteniendo tus botones existentes
    initComplete: function () {
      const $botones = this.api().buttons().container();

      $botones.before(
        '<label class="mb-1 font-weight-bold d-block">Exportar <span> / Imprimir<span></label>'
      );

      $botones.find(".dt-btn").css({
        borderRadius: "24px",
      });
    },
  });

  document.getElementById("contenedorTablaGrupos").style.display = "block";
}

// Ajustar event listeners para el nuevo select de género
document.addEventListener("DOMContentLoaded", () => {
  cargarTorneos("", "filtro_torneo");

  document
    .getElementById("filtro_torneo")
    .addEventListener("change", consultarGrupos);
  document
    .getElementById("filtro_grupo")
    .addEventListener("change", consultarGrupos);
  document
    .getElementById("filtro_genero")
    .addEventListener("change", consultarGrupos); // cambio aquí para el select
});

function limpiarFiltroGrupos() {
  document.getElementById("filtro_torneo").selectedIndex = 0;
  document.getElementById("filtro_genero").selectedIndex = 0; // limpiar select género
  document.getElementById("filtro_grupo").selectedIndex = 0;
  document.getElementById("contenedorTablaGrupos").style.display = "none";
}
function mostrarModalGrupos() {
  const tabla = document.querySelector("#tblGrupos").cloneNode(true);
  tabla.classList.remove("dataTable"); // Quitar estilos DataTable si es necesario
  tabla.classList.add("table", "table-bordered", "mt-3");

  // Eliminar elementos innecesarios
  tabla
    .querySelectorAll(".sorting, .sorting_asc, .sorting_desc")
    .forEach((el) => {
      el.classList.remove("sorting", "sorting_asc", "sorting_desc");
    });

  document.getElementById("contenidoModalExportar").innerHTML = "";
  document.getElementById("contenidoModalExportar").appendChild(tabla);
  $("#modalExportarGrupos").modal("show");
}

//
function exportarPDF() {
  const elemento = document.getElementById("contenidoModalExportar");
  html2pdf()
    .from(elemento)
    .set({
      margin: 10,
      filename: "clasificacion_por_grupos.pdf",
      image: { type: "jpeg", quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
    })
    .save();
}
