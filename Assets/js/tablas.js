let tblUsuarios,
  tblTorneos,
  tblMateria,
  tblAutor,
  tblEditorial,
  tblLibros,
  tblPrestar,
  tblUbicacion,
  tblGrupos,
  tblJugadores,
  tblEquipos,
  tblJuegos,
  tblInscripciones,
  tblInscripcionesJugador;

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

  tblInscripcionesJugador = $("#tblInscripcionesJugador").DataTable({
    ajax: {
      url: base_url + "Jugadores/listarInscritos",
      dataSrc: "",
      error: function (xhr) {
        console.error("Error cargando Jugadores inscritos:", xhr.responseText);
      },
    },
    columns: [
      { data: "id" }, // ID de inscripción
      { data: "torneo" }, // Nombre del torneo
      { data: "equipo" }, // Nombre del equipo
      { data: "cedula" }, // Cédula del jugador
      { data: "nombre" }, // Nombre del jugador
      { data: "apellido" },
      { data: "genero" },
      { data: "estado" },

      { data: "acciones" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language,
  });

  tblInscripciones = $("#tblInscripciones").DataTable({
    ajax: {
      url: base_url + "Inscripciones/listar",
      dataSrc: "",
      error: function (xhr) {
        console.error("Error cargando inscripciones:", xhr.responseText);
      },
    },
    columns: [
      { data: "id" },
      { data: "torneo" },
      { data: "equipo" },
      {
        data: "grupo",
        render: function (data) {
          return data ? data : "Sin grupo";
        },
      },
      { data: "genero" },
      {
        data: "fecha_inscripcion",
        render: function (data) {
          const parts = data.split("-");
          const fecha = new Date(parts[0], parts[1] - 1, parts[2]);
          return fecha.toLocaleDateString("es-ES");
        },
      },
      // {
      //   data: "fecha_inscripcion",
      //   render: function (data) {
      //     return new Date(data).toLocaleDateString("es-ES");
      //   },
      // },
      { data: "estado" },
      { data: "acciones" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language,
  });

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
    // dom:
    //   "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
    //   "<'row'<'col-sm-12'tr>>" +
    //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    // buttons,
  });
  //Fin de la tabla usuarios
  //Tabla Jugadores
  tblJugadores = $("#tblJugadores").DataTable({
    ajax: {
      url: base_url + "Jugadores/listar",
      dataSrc: "data", // Ahora coincide con el formato del JSON
    },
    columns: [
      { data: "cedula" },
      { data: "nombre_completo" },
      { data: "fecha_formateada" }, // Fecha formateada
      { data: "edad" }, // Edad calculada
      { data: "email" },
      { data: "telefono" },
      { data: "genero" },
      { data: "estado" }, // Estado con HTML
      { data: "acciones" }, // Acciones con botones
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language, // Manteniendo tu configuración existente
    // dom:
    //   "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
    //   "<'row'<'col-sm-12'tr>>" +
    //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    // buttons, // Manteniendo tus botones existentes
  });
  //Fin de la tabla Jugadores
  //Tabla Equipos
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
      { data: "estado" },
      { data: "acciones" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language, // asumiendo que ya tienes esta variable configurada
    // dom:
    //   "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
    //   "<'row'<'col-sm-12'tr>>" +
    //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    // buttons, // asumiendo que ya tienes esta variable configurada
  });
  //Fin de la tabla Equipos
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
    // dom:
    //   "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
    //   "<'row'<'col-sm-12'tr>>" +
    //   "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    // buttons, // asumiendo que ya tienes esta variable configurada
  });
  //
  tblJuegos = $("#tblJuegos").DataTable({
    ajax: {
      url: base_url + "Juegos/listar",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "torneo" },
      { data: "equipo" },
      {
        data: "puntos_equipo",
        render: function (data) {
          return data ?? "0";
        },
      },
      { data: "vs_equipo" },
      {
        data: "puntos_vs_equipo",
        render: function (data) {
          return data ?? "0";
        },
      },
      {
        data: "genero",
        render: function (data) {
          return data ? data.charAt(0).toUpperCase() + data.slice(1) : "-";
        },
      },
      {
        data: "fecha_juego",
        render: function (data) {
          if (!data) return "-";
          const parts = data.split("-");
          const fecha = new Date(parts[0], parts[1] - 1, parts[2]);
          return fecha.toLocaleDateString("es-ES");
        },
      },
      {
        data: "hora",
        render: function (data) {
          if (!data) return "-";
          const [hour, minute, second] = data.split(":");
          const fecha = new Date();
          fecha.setHours(hour, minute, second);
          return fecha.toLocaleTimeString("es-VE", {
            hour: "2-digit",
            minute: "2-digit",
            hour12: true,
          });
        },
      },
      { data: "estado" },
      { data: "acciones" },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language,
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
  });
  //Fin de la tabla Torneos

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
  // if (document.getElementById("nombre_estudiante")) {
  //   const http = new XMLHttpRequest();
  //   const url = base_url + "Configuracion/verificar";
  //   http.open("GET", url);
  //   http.send();
  //   http.onreadystatechange = function () {
  //     if (this.readyState == 4 && this.status == 200) {
  //       const res = JSON.parse(this.responseText);
  //       let html = "";
  //       res.forEach((row) => {
  //         html += `
  //                   <a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-user-o fa-stack-1x fa-inverse"></i></span></span>
  //                       <div>
  //                           <p class="app-notification__message" id="nombre_estudiante">${row.nombre}</p>
  //                           <p class="app-notification__meta" id="fecha_entrega">${row.fecha_devolucion}</p>
  //                       </div>
  //                   </a>
  //                   `;
  //       });
  //       document.getElementById("nombre_estudiante").innerHTML = html;
  //     }
  //   };
  // }
});
//
