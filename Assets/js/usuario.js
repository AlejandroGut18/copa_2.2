const frmUsuario = () => {
  document.getElementById("title").textContent = "Nuevo Usuario";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("claves").classList.remove("d-none");
  document.getElementById("frmUsuario").reset();
  document.getElementById("id").value = "";
  $("#nuevo_usuario").modal("show");
};

const registrarUser = (e) => {
  e.preventDefault();
  const usuario = document.getElementById("usuario");
  const nombre = document.getElementById("nombre");
  const clave = document.getElementById("clave");
  const confirmar = document.getElementById("confirmar");
  if (usuario.value == "" || nombre.value == "") {
    alertas("Todo los campos son requeridos", "warning");
  } else {
    const url = base_url + "Usuarios/registrar";
    const frm = document.getElementById("frmUsuario");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevo_usuario").modal("hide");
        frm.reset();
        tblUsuarios.ajax.reload();
        alertas(res.msg, res.icono);
      }
    };
  }
};
const btnEditarUser = (id) => {
  document.getElementById("title").textContent = "Actualizar usuario";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Usuarios/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("usuario").value = res.usuario;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("claves").classList.add("d-none");
      $("#nuevo_usuario").modal("show");
    }
  };
};
const btnEliminarUser = (id) => {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El usuario no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Usuarios/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblUsuarios.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};
const btnReingresarUser = (id) => {
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
      const url = base_url + "Usuarios/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblUsuarios.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};

const btnRolesUser = (id) => {
  const http = new XMLHttpRequest();
  const url = base_url + "Usuarios/permisos/" + id;
  http.open("GET", url);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("frmPermisos").innerHTML = this.responseText;
      $("#permisos").modal("show");
    }
  };
};
const registrarPermisos = (e) => {
  e.preventDefault();
  const http = new XMLHttpRequest();
  const frm = document.getElementById("frmPermisos");
  const url = base_url + "Usuarios/registrarPermisos";
  http.open("POST", url);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      $("#permisos").modal("hide");
      if (res == "ok") {
        alertas("Permisos Asignado", "success");
      } else {
        alertas("Error al asignar los permisos", "error");
      }
    }
  };
};

const modificarClave = (e) => {
  e.preventDefault();
  var formClave = document.querySelector("#frmCambiarPass");
  formClave.onsubmit = function (e) {
    e.preventDefault();
    const clave_actual = document.querySelector("#clave_actual").value;
    const nueva_clave = document.querySelector("#clave_nueva").value;
    const confirmar_clave = document.querySelector("#clave_confirmar").value;
    if (clave_actual == "" || nueva_clave == "" || confirmar_clave == "") {
      alertas("Todo los campos son requeridos", "warning");
    } else if (nueva_clave != confirmar_clave) {
      alertas("Las contraseñas no coinciden", "warning");
    } else {
      const http = new XMLHttpRequest();
      const frm = document.getElementById("frmPermisos");
      const url = base_url + "Usuarios/cambiarPas";
      http.open("POST", url);
      http.send(new FormData(formClave));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          $("#cambiarClave").modal("hide");
          alertas(res.msg, res.icono);
        }
      };
    }
  };
};

let tblUsuarios;
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

  //Tabla Usuarios
  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: base_url + "Usuarios/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "user_name" },
      { data: "nombre" },
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
});