const frmJugadores = () => {
  document.getElementById("title").textContent = "Nuevo Jugador";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmJugadores").reset();
  document.getElementById("listaEquipos").innerHTML = ""; // Limpia equipos anteriores
  cargarGeneros();
  $("#nuevoJugador").modal("show");
};
const registrarJugador = (e) => {
  e.preventDefault();
  const cedula = document.getElementById("cedula");
  const nombre = document.getElementById("nombre");
  const apellido = document.getElementById("apellido");
  const fechaNacimiento = document.getElementById("fecha_nacimiento");
  const email = document.getElementById("email");
  const telefono = document.getElementById("telefono");
  const genero = document.getElementById("genero");
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Validación básica de campos obligatorios
  if (
    cedula.value.trim() === "" ||
    nombre.value.trim() === "" ||
    apellido.value.trim() === "" ||
    fechaNacimiento.value.trim() === "" ||
    email.value.trim() === "" ||
    telefono.value.trim() === "" ||
    genero.value.trim() === ""
  ) {
    alertas("Todos los campos obligatorios son requeridos", "warning");
    return;
  } else if (!emailRegex.test(email.value)) {
    alertas("Por favor ingrese un email válido", "warning");
    return;
  } else if (!/^\d{7,10}$/.test(cedula.value.trim())) {
    alertas("La cédula debe contener entre 7 y 10 dígitos", "warning");
    return;
  } else if (!/^\d{7}$/.test(telefono.value.trim())) {
    alertas(
      "El teléfono debe tener exactamente 7 dígitos numéricos",
      "warning"
    );
    return;
  } else {
    const edad = calcularEdad(fechaNacimiento.value);
    if (edad < 18) {
      alertas("El jugador debe ser mayor de edad (18+)", "warning");
      return;
    }

    // ✅ Obtener código y concatenar con número
    const codigo = document.querySelector('select[name="codigo"]').value;
    telefono.value = codigo + telefono.value.trim();

    // Validar cantidad de equipos
    const equiposSeleccionados = document.querySelectorAll(
      'input[name="equipos[]"]:checked'
    );
    if (equiposSeleccionados.length === 0) {
      alertas("Debe seleccionar al menos un Equipo", "warning");
      return;
    } else if (equiposSeleccionados.length > 3) {
      alertas(
        "Un Jugador no puede pertenecer a más de 3 Equipos a la vez",
        "warning"
      );
      return;
    }

    const url = base_url + "Jugadores/registrar";
    const frm = document.getElementById("frmJugadores");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        try {
          const res = JSON.parse(this.responseText);
          $("#nuevoJugador").modal("hide");

          frm.reset();
          tblJugadores.ajax.reload();
          document.getElementById("listaEquipos").innerHTML = "";

          alertas(res.msg, res.icono);
        } catch (err) {
          console.error("❌ Error al parsear JSON:", err);
          console.warn("📥 Respuesta del servidor:", this.responseText);
          alertas("Error inesperado del servidor", "error");
        }
      }
    };
  }
};

const btnEditarJugador = (cedula) => {
  const url = base_url + "Jugadores/editar/" + cedula;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        const res = JSON.parse(this.responseText);

        // Cargar datos en el formulario
        document.getElementById("cedula_editar").value = res.cedula;
        document.getElementById("nombre_editar").value = res.nombre;
        document.getElementById("apellido_editar").value = res.apellido;
        document.getElementById("fecha_nacimiento_editar").value =
          res.fecha_nacimiento;
        document.getElementById("email_editar").value = res.email;
        document.getElementById("telefono_editar").value = res.telefono;
        document.getElementById("status_id_editar").value = res.status_id;

        // Cargar equipos
        cargarGeneros(res.genero, "genero_editar");
        cargarEquiposJugador(res.genero, res.equipos, "listaEquiposEditar"); // 'equipos' es el ID del div para editar

        // Mostrar modal
        $("#modalEditarJugador").modal("show");
      } catch (error) {
        alertas("Error al cargar datos del jugador", "error");
        console.error(error);
      }
    }
  };
};
const actualizarJugador = (e) => {
  e.preventDefault();
  const cedula = document.getElementById("cedula_editar");
  const nombre = document.getElementById("nombre_editar");
  const apellido = document.getElementById("apellido_editar");
  const fechaNacimiento = document.getElementById("fecha_nacimiento_editar");
  const email = document.getElementById("email_editar");
  const telefono = document.getElementById("telefono_editar");
  const genero = document.getElementById("genero_editar");
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Validaciones...
  if (
    cedula.value.trim() === "" ||
    nombre.value.trim() === "" ||
    apellido.value.trim() === "" ||
    fechaNacimiento.value.trim() === "" ||
    email.value.trim() === "" ||
    telefono.value.trim() === "" ||
    genero.value.trim() === ""
  ) {
    alertas("Todos los campos obligatorios son requeridos", "warning");
    return;
  }

  if (!emailRegex.test(email.value)) {
    alertas("Por favor ingrese un email válido", "warning");
    return;
  }
  console.log(cedula);

  if (!/^\d{7,10}$/.test(cedula.value.trim())) {
    alertas("La cédula debe contener entre 7 y 10 dígitos", "warning");
    return;
  }

  if (!/^\d{11}$/.test(telefono.value.trim())) {
    alertas("El teléfono debe tener exactamente 11 dígitos", "warning");
    return;
  }

  const edad = calcularEdad(fechaNacimiento.value);
  if (edad < 18) {
    alertas("El jugador debe ser mayor de edad (18+)", "warning");
    return;
  }

  const equiposSeleccionados = document.querySelectorAll(
    '#listaEquiposEditar input[name="equipos[]"]:checked'
  );
  if (equiposSeleccionados.length === 0) {
    alertas("Debe seleccionar al menos un equipo", "warning");
    return;
  } else if (equiposSeleccionados.length > 3) {
    alertas(
      "Un Jugador no puede pertenecer a más de 3 Equipos a la vez",
      "warning"
    );
    return;
  }

  // Aquí faltaba crear y enviar la petición
  const form = document.getElementById("frmEditarJugador");
  const url = base_url + "Jugadores/actualizar";
  const formData = new FormData(form);

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(formData);

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        const res = JSON.parse(this.responseText);
        // Solo en caso de éxito cerramos modal y recargamos tabla
        if (res.icono === "success") {
          $("#modalEditarJugador").modal("hide");
          form.reset();
          document.getElementById("listaEquiposEditar").innerHTML = "";
          tblJugadores.ajax.reload();
        }
        // Mostrar alerta siempre
        alertas(res.msg, res.icono);
      } catch (error) {
        console.error("Error al procesar respuesta:", this.responseText);
        alertas("Error inesperado del servidor", "error");
      }
    }
  };
};

const btnEliminarJugador = (id) => {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El Jugador no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Jugadores/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblJugadores.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};
const btnReingresarJugador = (id) => {
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
      const url = base_url + "Jugadores/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblJugadores.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};
const cargarEquiposJugador = (
  genero,
  selectedIds = [], // ahora un arreglo de IDs seleccionados
  selectId = "listaEquipos"
) => {
  if (!genero) {
    genero = document.getElementById("genero").value;
  }
  if (!genero) {
    document.getElementById(
      selectId
    ).innerHTML = `<p class="text-danger">Seleccione un género primero</p>`;
    return;
  }
  const url = base_url + `Equipos/listarActivos?genero=${genero}`;

  fetch(url)
    .then((res) => res.json())
    .then((data) => {
      let html = "";
      if (data.length > 0) {
        data.forEach((equipo) => {
          const checked = selectedIds.includes(equipo.id) ? "checked" : "";
          html += `
            <div class="col-12 col-md-6 mb-1">
              <div class="form-check form-check-sm d-flex align-items-center">
                <input class="form-check-input equipo-check" type="checkbox" name="equipos[]" id="equipo_${equipo.id}" value="${equipo.id}" ${checked} style="accent-color: #28a745;">
                <label class="form-check-label small ml-2" for="equipo_${equipo.id}">${equipo.nombre}</label>
              </div>
            </div>
          `;
        });
      } else {
        html = `<div class="col-12"><p class="text-danger">No hay equipos disponibles</p></div>`;
      }
      document.getElementById(selectId).innerHTML = html;

      // 🔁 Espera a que se carguen los checkboxes en el DOM
      setTimeout(() => {
        const checkboxes = document.querySelectorAll(
          `#${selectId} input[type="checkbox"].equipo-check`
        );

        const controlarChecks = () => {
          const seleccionados = Array.from(checkboxes).filter(
            (cb) => cb.checked
          );
          const maximoAlcanzado = seleccionados.length >= 3;
          checkboxes.forEach((cb) => {
            if (!cb.checked) {
              cb.disabled = maximoAlcanzado;
            }
          });
        };

        checkboxes.forEach((cb) => {
          cb.addEventListener("change", controlarChecks);
        });

        // Ejecutar al inicio en caso de que haya preseleccionados
        controlarChecks();
      }, 10);
    })
    .catch((err) => {
      console.error(err);
      document.getElementById(
        selectId
      ).innerHTML = `<p class="text-danger">Error al cargar equipos</p>`;
    });
};

const filtrarEquipos = () => {
  const genero = document.getElementById("genero").value;
  if (genero) {
    cargarEquiposJugador(genero, [], "listaEquipos");
  } else {
    document.getElementById(
      "listaEquipos"
    ).innerHTML = `<p class="text-danger">Seleccione un género primero</p>`;
  }
};

const filtrarEquiposEditar = () => {
  const genero = document.getElementById("genero_editar").value;
  if (genero) {
    cargarEquiposJugador(genero, [], "listaEquiposEditar");
  } else {
    document.getElementById(
      "listaEquiposEditar"
    ).innerHTML = `<p class="text-danger">Seleccione un género primero</p>`;
  }
};

function calcularEdad(fechaNacimiento) {
  const hoy = new Date();
  const nacimiento = new Date(fechaNacimiento);
  let edad = hoy.getFullYear() - nacimiento.getFullYear();
  const mes = hoy.getMonth() - nacimiento.getMonth();
  if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
    edad--;
  }
  return edad;
}
function verJugador(cedula) {
  const url = `${base_url}Jugadores/ver/${cedula}`;
  fetch(url)
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("ver_cedula").textContent = data.cedula;
      document.getElementById("ver_nombre").textContent = data.nombre;
      document.getElementById("ver_apellido").textContent = data.apellido;
      document.getElementById("ver_fecha_nacimiento").textContent =
        data.fecha_nacimiento;
      document.getElementById("ver_email").textContent = data.email;
      document.getElementById("ver_telefono").textContent = data.telefono;
      document.getElementById("ver_genero").textContent = data.genero;

      const lista = document.getElementById("ver_equipos");
      lista.innerHTML = "";
      if (data.equipos.length > 0) {
        data.equipos.forEach((e) => {
          const li = document.createElement("li");
          li.classList.add(
            "list-group-item",
            e.status_id == 1 ? "text-success" : "text-muted"
          );
          li.textContent = `${e.nombre} (${
            e.status_id == 1 ? "Activo" : "Inactivo"
          })`;
          lista.appendChild(li);
        });
      } else {
        lista.innerHTML =
          "<li class='list-group-item text-danger'>No tiene equipos asociados</li>";
      }

      $("#modalVerJugador").modal("show");
    })
    .catch((err) => {
      console.error("Error al cargar datos del jugador:", err);
    });
}

// tabla dinamica de datos juegadores:
let tblJugadores;
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
  $(".delegado").select2({
    placeholder: "Buscar Jugador Delegado",
    minimumInputLength: 2,
    ajax: {
      url: base_url + "Jugadores/buscarDelegado",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          est: params.term, // lo que el usuario escribe
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
