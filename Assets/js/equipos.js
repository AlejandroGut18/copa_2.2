const frmEquipos = () => {
  document.getElementById("title").textContent = "Nuevo Equipo";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmEquipos").reset();
  document.getElementById("id").value = "";

  cargarDelegados();
  cargarGeneros();
  cargarTiposEquipo();
  // Cargar delegados al abrir el modal
  $("#nuevoEquipo").modal("show");
};

const registrarEquipo = (e) => {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const delegado = document.getElementById("delegado");
  const genero = document.getElementById("genero");
  const tipo = document.getElementById("tipo_equipo");

  if (
    nombre.value.trim() === "" ||
    delegado.value === "" ||
    genero.value === "" ||
    tipo.value === ""
  ) {
    alertas("Todos los campos son requeridos", "warning");
    return;
  } else {
    const url = base_url + "Equipos/registrar";
    const frm = document.getElementById("frmEquipos");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevoEquipo").modal("hide");
        frm.reset();
        tblEquipos.ajax.reload();
        alertas(res.msg, res.icono);
      }
    };
  }
};

const btnEditarEquipo = (id) => {
  document.getElementById("title").textContent = "Actualizar Equipo";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Equipos/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4) {
      try {
        const res = JSON.parse(this.responseText);
        document.getElementById("id").value = res.id;
        document.getElementById("nombre").value = res.nombre;
        document.getElementById("delegado").value = res.delegado_equipo;
        cargarDelegados(res.delegado_equipo);
        cargarGeneros(res.genero); // 👈 pasa el valor actual
        cargarTiposEquipo(res.tipo_equipo);
        $("#nuevoEquipo").modal("show");
      } catch (err) {
        console.error("Error al parsear JSON:", err);
        console.warn("Respuesta del servidor:", this.responseText);
      }
    }
  };
};

const btnEliminarEquipo = (id) => {
  Swal.fire({
    title: "¿Está seguro de eliminar?",
    text: "El equipo no se eliminará de forma permanente, solo cambiará el estado a inactivo.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Equipos/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblEquipos.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};

const btnReingresarEquipo = (id) => {
  Swal.fire({
    title: "¿Está seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Equipos/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblEquipos.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};
let tblEquipos;
const cargarTiposEquipo = (selected = "", selectId = "") => {
  // Si no se especifica selectId, usamos "tipo_grupo"
  if (selectId === "") {
    selectId = "tipo_equipo";
  }
  const selectEquipo = document.getElementById(selectId);
  if (!selectEquipo) return;

  selectEquipo.innerHTML = `
    <option value="" disabled ${selected === "" ? "selected" : ""}>
      Seleccione un Tipo de Equipo
    </option>
    <option value="AF" ${selected === "AF" ? "selected" : ""}>
      Afiliado
    </option>
    <option value="IN" ${selected === "IN" ? "selected" : ""}>
      Invitado
    </option>
  `;
};
document.addEventListener("DOMContentLoaded", function () {
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
  //botones para generar los archivos
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

  tblEquipos = $("#tblEquipos").DataTable({
    ajax: {
      url: base_url + "Equipos/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "nombre" },
      { data: "delegado" },
      { data: "genero" },
      { data: "tipo_equipo" },
      { data: "estado" },
      { data: "acciones" },
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
    // asumiendo que ya tienes esta variable configurada
    // dom:
    //   "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
    //   "<'row'<'col-sm-12'tr>>" +
    //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    // buttons, // asumiendo que ya tienes esta variable configurada
  });
  // $(".delegado").select2({
  //   placeholder: "Buscar Delegado",
  //   minimumInputLength: 2,
  //   ajax: {
  //     url: base_url + "Jugadores/buscarDelegado",
  //     dataType: "json",
  //     delay: 250,
  //     data: function (params) {
  //       return {
  //         est: params.term,
  //       };
  //     },
  //     processResults: function (data) {
  //       return {
  //         results: data,
  //       };
  //     },
  //     cache: true,
  //   },
  // });
});
// $('#modalNombre').on('shown.bs.modal', function () {
//   $('.delegado').select2({
//     placeholder: 'Buscar Delegado',
//     minimumInputLength: 2,
//     ajax: {
//       url: base_url + 'Jugadores/buscarDelegado',
//       dataType: 'json',
//       delay: 250,
//       data: function (params) {
//         return {
//           est: params.term
//         };
//       },
//       processResults: function (data) {
//         return {
//           results: data
//         };
//       },
//       cache: true
//     }
//   });
// });
