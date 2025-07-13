const frmUbicacion = () => {
  document.getElementById("title").textContent = "Nueva Ubicación";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmUbicacion").reset();
  document.getElementById("id").value = "";
  $("#nuevaUbicacion").modal("show");
};

const registrarUbic = (e) => {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const direccion = document.getElementById("direccion");
  if (nombre.value == "" || direccion.value == "") {
    alertas("Todo los campos son requeridos", "warning");
  } else {
    const url = base_url + "Ubicacion/registrar";
    const frm = document.getElementById("frmUbicacion");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevaUbicacion").modal("hide");
        frm.reset();
        tblUbicacion.ajax.reload();
        alertas(res.msg, res.icono);
      }
    };
  }
};
const btnEditarUbic = (id) => {
  document.getElementById("title").textContent = "Actualizar Ubicacion";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Ubicacion/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("direccion").value = res.direccion;
      $("#nuevaUbicacion").modal("show");
    }
  };
};

const btnEliminarUbic = (id) => {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "La Ubicacion no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Ubicacion/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblUbicacion.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};
const btnReingresarUbicacion = (id) => {
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
      const url = base_url + "Ubicacion/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblUbicacion.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};
function buscarEnGoogleMaps() {
  const direccion = document.getElementById("direccion").value.trim();
  if (direccion !== "") {
    const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(
      direccion
    )}`;
    window.open(url, "_blank");
  } else {
    alert("Por favor ingrese una dirección primero");
  }
}

let tblUbicacion;
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
  // const buttons = [
  //   {
  //     extend: "excel",
  //     footer: true,
  //     title: "Archivo",
  //     filename: "Export_File",
  //     text: '<i class="icon fa fa-file-excel-o"></i> Excel',
  //     className: "btn btn-outline-success buttons-excel btn-sm mr-2 dt-btn sec",
  //     /*   },
  // {
  //   extend: "pdf",
  //   footer: true,
  //   title: "Archivo PDF",
  //   filename: "reporte",
  //   text: '<i class="icon fa fa-file-pdf-o"></i> PDF',
  //   className: "btn btn-outline-danger buttons-pdf btn-sm mr-2 dt-btn sec ",
  //   action: function (e, dt, button, config) {
  //     mostrarModalGrupos(); // tu función personalizada
  //   } */
  //   },
  //   {
  //     extend: "print",
  //     footer: true,
  //     title: "Reportes",
  //     filename: "Export_File_print",
  //     text: '<i class="fa fa-print mr-1"></i> Imprimir',
  //     className: "btn btn-outline-p buttons-print btn-sm dt-btn sec",
  //   },
  // ];
  // //Tabla Ubicacion
  tblUbicacion = $("#tblUbicacion").DataTable({
    ajax: {
      url: base_url + "Ubicacion/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "nombre" },
      { data: "direccion" },
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
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    // buttons, // Manteniendo tus botones existentes
    // initComplete: function () {
    //   const $botones = this.api().buttons().container();

    //   $botones.before(
    //     '<label class="mb-1 font-weight-bold d-block">Exportar <span> / Imprimir<span></label>'
    //   );

    //   $botones.find(".dt-btn").css({
    //     borderRadius: "24px",
    //   });
    // },
  });
  $(".ubicacion").select2({
    placeholder: "Buscar Ubicacion",
    minimumInputLength: 2,
    ajax: {
      url: base_url + "Ubicacion/buscarUbicacion",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          q: params.term,
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
