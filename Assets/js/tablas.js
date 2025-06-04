let tblUsuarios,
  tblTorneos,
  tblMateria,
  tblAutor,
  tblEditorial,
  tblLibros,
  tblPrestar,
  tblUbicacion,
  tblGrupos;

// funciones para cargar datos en las tablas
document.addEventListener("DOMContentLoaded", function () {
  document.querySelector("#modalPass").addEventListener("click", function () {
    document.querySelector("#frmCambiarPass").reset();
    $("#cambiarClave").modal("show");
  });
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
      //Botón para Excel
      extend: "excel",
      footer: true,
      title: "Archivo",
      filename: "Export_File",

      //Aquí es donde generas el botón personalizado
      text: '<button class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>',
    },
    //Botón para PDF
    {
      extend: "pdf",
      footer: true,
      title: "Archivo PDF",
      filename: "reporte",
      text: '<button class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></button>',
    },
    //Botón para print
    {
      extend: "print",
      footer: true,
      title: "Reportes",
      filename: "Export_File_print",
      text: '<button class="btn btn-info"><i class="fa fa-print"></i></button>',
    },
  ];
  //Tabla Usuarios
  tblUsuarios = $("#tblUsuarios").DataTable({
    ajax: {
      url: base_url + "Usuarios/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "usuario" },
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
    buttons,
  });
  //Fin de la tabla usuarios
  //Tabla Grupos
  tblGrupos = $("#tblGrupos").DataTable({
    ajax: {
      url: base_url + "Grupos/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "nombre" },
      { data: "torneo" },
      { data: "genero" },
      { data: "estado" },
      { data: "acciones" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language, // asumiendo que ya tienes esta variable configurada
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons, // asumiendo que ya tienes esta variable configurada
  });

  //Tabla Ubicacion
  tblUbicacion = $("#tblUbicacion").DataTable({
    ajax: {
      url: base_url + "Ubicacion/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "nombre" },
      { data: "direccion" },
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
    buttons,
  });
  //Fin de la tabla Ubicacion
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
          return new Date(data).toLocaleDateString("es-ES");
        },
      },
      {
        data: "fecha_fin",
        render: function (data) {
          return data ? new Date(data).toLocaleDateString("es-ES") : "N/A";
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
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
    // initComplete: function () {
    //   // console.log("Tabla de torneos inicializada");
    // },
  });
  //Fin de la tabla Torneos
  tblMateria = $("#tblMateria").DataTable({
    ajax: {
      url: base_url + "Materia/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "materia",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //Fin de la tabla Materias
  tblAutor = $("#tblAutor").DataTable({
    ajax: {
      url: base_url + "Autor/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "imagen",
      },
      {
        data: "autor",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //Fin de la tabla Autor
  tblEditorial = $("#tblEditorial").DataTable({
    ajax: {
      url: base_url + "Editorial/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "editorial",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //Fin de la tabla editorial
  tblLibros = $("#tblLibros").DataTable({
    ajax: {
      url: base_url + "Libros/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "titulo",
      },
      {
        data: "cantidad",
      },
      {
        data: "autor",
      },
      {
        data: "editorial",
      },
      {
        data: "materia",
      },
      {
        data: "foto",
      },
      {
        data: "descripcion",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
  });
  //fin Libros
  tblPrestar = $("#tblPrestar").DataTable({
    ajax: {
      url: base_url + "Prestamos/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "titulo",
      },
      {
        data: "nombre",
      },
      {
        data: "fecha_prestamo",
      },

      {
        data: "fecha_devolucion",
      },
      {
        data: "cantidad",
      },
      {
        data: "observacion",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
    language,
    dom:
      "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons,
    resonsieve: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
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

  $(".libro").select2({
    placeholder: "Buscar Libro",
    minimumInputLength: 2,
    ajax: {
      url: base_url + "Libros/buscarLibro",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          lb: params.term,
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

  $(".ubicacion").select2({
    placeholder: "Buscar Autor",
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

  $(".autor").select2({
    placeholder: "Buscar Autor",
    minimumInputLength: 2,
    ajax: {
      url: base_url + "Autor/buscarAutor",
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

  $(".editorial").select2({
    placeholder: "Buscar Editorial",
    minimumInputLength: 2,
    ajax: {
      url: base_url + "Editorial/buscarEditorial",
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

  $(".materia").select2({
    placeholder: "Buscar Materia",
    minimumInputLength: 2,
    ajax: {
      url: base_url + "Materia/buscarMateria",
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

  if (document.getElementById("nombre_estudiante")) {
    const http = new XMLHttpRequest();
    const url = base_url + "Configuracion/verificar";
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        let html = "";
        res.forEach((row) => {
          html += `
                    <a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-user-o fa-stack-1x fa-inverse"></i></span></span>
                        <div>
                            <p class="app-notification__message" id="nombre_estudiante">${row.nombre}</p>
                            <p class="app-notification__meta" id="fecha_entrega">${row.fecha_devolucion}</p>
                        </div>
                    </a>
                    `;
        });
        document.getElementById("nombre_estudiante").innerHTML = html;
      }
    };
  }
});
//
