const frmTorneo = () => {
  document.getElementById("title").textContent = "Nuevo Torneo";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmTorneo").reset();
  document.getElementById("id").value = "";
  cargarUbicaciones();
  $("#nuevoTorneo").modal("show");
};

const registrarTorneo = (e) => {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const fecha_inicio = document.getElementById("fecha_inicio");
  const ubicacion_id = document.getElementById("ubicacion_id");
  const status_id = document.getElementById("status_id");
  console.log(fecha_inicio);
  if (
    nombre.value == "" ||
    fecha_inicio.value == "" ||
    ubicacion_id.value == "" ||
    status_id.value == ""
  ) {
    alertas("Todos los campos obligatorios son requeridos", "warning");
  } else {
    const url = base_url + "Torneos/registrar";
    const frm = document.getElementById("frmTorneo");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevoTorneo").modal("hide");
        frm.reset();
        tblTorneos.ajax.reload();
        alertas(res.msg, res.icono);
      }
    };
  }
};

const btnEditarTorneo = (id) => {
  document.getElementById("title").textContent = "Actualizar Torneo";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Torneos/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("fecha_inicio").value = res.fecha_inicio;
      document.getElementById("fecha_fin").value = res.fecha_fin || "";
      cargarUbicaciones(res.ubicacion_id);
      console.log(res.fecha_fin);
      $("#nuevoTorneo").modal("show");
    }
  };
};

const btnEliminarTorneo = (id) => {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El Torneo no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Torneos/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblTorneos.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};

const btnReingresarTorneo = (id) => {
  Swal.fire({
    title: "Esta seguro de reingresar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Torneos/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblTorneos.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};

function filtrarTorneos() {
  const fecha_desde = document.getElementById("filtro_fecha_desde").value;
  const fecha_hasta = document.getElementById("filtro_fecha_hasta").value;
  const estado = document.getElementById("filtro_estado").value;

  const datos = new URLSearchParams();
  datos.append("fecha_desde", fecha_desde);
  datos.append("fecha_hasta", fecha_hasta);
  datos.append("estado", estado);

  fetch(base_url + "Torneos/filtrar", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: datos.toString(),
  })
    .then((res) => res.json())
    .then((data) => {
      actualizarTabla(data);
    });
}

function limpiarFiltros() {
  document.getElementById("filtro_fecha_desde").value = "";
  document.getElementById("filtro_fecha_hasta").value = "";
  document.getElementById("filtro_estado").value = "";

  fetch(base_url + "Torneos/listar")
    .then((res) => res.json())
    .then((data) => {
      actualizarTabla(data);
    });
}

function actualizarTabla(data) {
  if ($.fn.DataTable.isDataTable("#tblTorneos")) {
    const table = $("#tblTorneos").DataTable();
    table.clear();
    table.rows.add(data);
    table.draw();
  }
}
document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("filtro_estado")
    .addEventListener("change", filtrarTorneos);
});

let tblTorneos;
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
  // botones para generar los archivos
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
  // Fin de la tabla Ubicacion
  //Tabla Torneos
  tblTorneos = $("#tblTorneos").DataTable({
    ajax: {
      url: base_url + "Torneos/listar",
      dataSrc: "",
      error: function (xhr) {
        console.error("Error cargando torneos:", xhr.responseText);
      },
    },
    columns: [
      { data: "id" },
      { data: "nombre" },
      {
        data: "fecha_inicio",
        render: function (data) {
          const parts = data.split("-");
          const fecha = new Date(parts[0], parts[1] - 1, parts[2]);
          return fecha.toLocaleDateString("es-ES");
        },
      },
      {
        data: "fecha_fin",
        render: function (data) {
          if (!data) return "N/A";
          const parts = data.split("-");
          const fecha = new Date(parts[0], parts[1] - 1, parts[2]);
          return fecha.toLocaleDateString("es-ES");
        },
      },
      { data: "ubicacion" },
      { data: "estado" },
      { data: "acciones" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language,
    // dom:
    //   "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
    //   "<'row'<'col-sm-12'tr>>" +
    //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    // buttons,
    // initComplete: function () {
    //   // console.log("Tabla de torneos inicializada");
    // },
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

  $(".torneo").select2({
    placeholder: "Buscar Torneo",
    minimumInputLength: 2,
    ajax: {
      url: base_url + "Torneos/buscarTorneo",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          est: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: true,
    },
  });
});
