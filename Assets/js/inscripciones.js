// inscripcion equipos

const frmInscripcion = () => {
  document.getElementById("title").textContent = "Inscribir Equipo";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmInscripcion").reset();

  cargarTorneos();
  cargarGeneros();

  $("#inscribir_equipo").modal("show");
};
const registrarInscripcion = (e) => {
  e.preventDefault();

  const torneo = document.getElementById("torneo_id").value;
  const genero = document.getElementById("genero").value;
  const equipo = document.getElementById("equipo_id").value;

  // Validación de campos obligatorios
  if (torneo === "" || genero === "" || equipo === "") {
    alertas("Todos los campos obligatorios son requeridos", "warning");
    return;
  }

  // Validación de jugadores seleccionados
  const jugadoresSeleccionados = document.querySelectorAll(
    'input[name="jugadores[]"]:checked'
  );

  if (jugadoresSeleccionados.length < 5) {
    alertas(
      "Debe seleccionar al menos 5 jugadores para inscribir el equipo",
      "warning"
    );
    return;
  }

  const url = base_url + "Inscripciones/registrar";
  const frm = document.getElementById("frmInscripcion");
  const http = new XMLHttpRequest();

  http.open("POST", url, true);
  http.send(new FormData(frm));

  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      try {
        const res = JSON.parse(this.responseText);
        $("#inscribir_equipo").modal("hide");

        frm.reset();
        document.getElementById("equipo_id").innerHTML =
          '<option value="" disabled selected>Seleccione un Equipo</option>';
        document.getElementById("listaJugadores").innerHTML = "";

        tblInscripciones.ajax.reload();
        alertas(res.msg, res.icono);
      } catch (err) {
        console.error("❌ Error al parsear JSON:", err);
        console.warn("📥 Respuesta del servidor:", this.responseText);
        alertas("Error inesperado del servidor", "error");
      }
    }
  };
};

$("#inscribir_equipo").on("hidden.bs.modal", function () {
  const form = document.getElementById("frmInscripcion");

  // Resetea el formulario básico
  form.reset();

  // Limpia selects cargados dinámicamente
  const selects = ["torneo_id", "genero", "equipo_id"];
  selects.forEach((id) => {
    const select = document.getElementById(id);
    if (select) {
      select.innerHTML =
        '<option value="" disabled selected>Seleccione una opción</option>';
    }
  });

  // Limpia checkboxes de jugadores
  const listaJugadores = document.getElementById("listaJugadores");
  if (listaJugadores) {
    listaJugadores.innerHTML = "";
  }

  // Si vas a mostrar de nuevo, recarga los datos desde cero
  // Opcional: cargarTorneos(); cargarGeneros(); ... puedes volverlos a llamar desde frmInscripcion si quieres
});

const btnEditarInscripcion = (id) => {
  const url = base_url + "Inscripciones/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        const res = JSON.parse(this.responseText);
        console.log(res); // <-- para verificar qué viene realmente

        document.getElementById("editar_id").value = res.id;
        document.getElementById("editar_status_id").value = res.status_id;

        // Torneo (bloqueado)
        cargarTorneos(res.torneo_id, "editar_torneo_id").then(() => {
          document.getElementById("editar_torneo_id").disabled = true;
        });

        // Género y equipo
        cargarGeneros(res.genero, "editar_genero"); // marcar opción actual
        setTimeout(() => {
          cargarEquipos(
            res.torneo_id,
            res.genero,
            res.equipo_id,
            "editar_equipo_id"
          );
        }, 100); // pequeño delay para asegurar que se cargue después del género
        // Jugadores preseleccionados

        const cedulas = res.jugadores.map((j) => j.toString()); // Asegurar que sean strings
        console.log("antes: ", res.jugadores);
        cargarJugadoresNoInscritos(
          res.genero,
          res.equipo_id,
          res.torneo_id,
          cedulas,
          "editar_listaJugadores",
          true
        );

        document.getElementById("title").textContent = "Editar Inscripción";
        document.getElementById("btnAccion").textContent = "Modificar";

        $("#editar_inscripcion").modal("show");
      } catch (error) {
        console.error("Error al parsear respuesta:", error);
        alertas("Error al cargar datos de la inscripción", "error");
      }
    }
  };
};

const actualizarInscripcion = (e) => {
  e.preventDefault();

  const id = document.getElementById("editar_id").value;
  const torneo = document.getElementById("editar_torneo_id").value;
  const genero = document.getElementById("editar_genero").value;
  const equipo = document.getElementById("editar_equipo_id").value;

  // copiar a hidden
  document.getElementById("torneo_hidden").value = torneo;

  const jugadoresSeleccionados = Array.from(
    document.querySelectorAll(
      '#editar_listaJugadores input[name="jugadores[]"]:checked'
    )
  ).map((cb) => cb.value);

  console.log("despues: ", jugadoresSeleccionados);

  if (!torneo || !genero || !equipo) {
    alertas("Todos los campos son obligatorios", "warning");
    return;
  }

  if (jugadoresSeleccionados.length < 5) {
    alertas("Debe seleccionar al menos 5 jugadores", "warning");
    return;
  }

  if (jugadoresSeleccionados.length > 10) {
    alertas("No puede seleccionar más de 10 jugadores", "warning");
    return;
  }

  const form = document.getElementById("frmEditarInscripcion");
  const url = base_url + "Inscripciones/actualizar";
  const formData = new FormData(form);

  // Eliminar posibles previos y evitar duplicados
  formData.delete("jugadores[]");
  [...new Set(jugadoresSeleccionados)].forEach((j) =>
    formData.append("jugadores[]", j)
  );

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(formData);

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        const res = JSON.parse(this.responseText);
        if (res.icono === "success") {
          $("#editar_inscripcion").modal("hide");
          form.reset();
          document.getElementById("listaJugadores").innerHTML = "";
          tblInscripciones.ajax.reload();
        }
        alertas(res.msg, res.icono);
      } catch (error) {
        console.error("Error al procesar respuesta:", this.responseText);
        alertas("Error inesperado del servidor", "error");
      }
    }
  };
};
const btnEliminarInscripcion = (id) => {
  Swal.fire({
    title: "¿Está seguro de dar de baja esta inscripción?",
    text: "La inscripción no se eliminará permanentemente, solo cambiará su estado a inactivo.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Inscripciones/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblInscripciones.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};

const btnReingresarInscripcion = (id, genero) => {
  Swal.fire({
    title: "¿Está seguro de reactivar esta inscripción?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Inscripciones/reingresar";

      const formData = new FormData();
      formData.append("id", id);
      formData.append("genero", genero);

      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblInscripciones.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
      http.send(formData);
    }
  });
};

function verInscripcion(id) {
  var url = base_url + "Inscripciones/ver/" + id;
  var http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      var data = JSON.parse(this.responseText);

      // Llenar campos
      // document.getElementById("ver_inscripcion_id").textContent     = data.id;
      document.getElementById("ver_torneo").textContent = data.torneo;
      document.getElementById("ver_genero").textContent = data.genero;
      document.getElementById("ver_equipo").textContent = data.equipo;
      document.getElementById("ver_status_inscripcion").innerHTML =
        data.status_id == 1
          ? '<span class="badge badge-success">Activo</span>'
          : '<span class="badge badge-danger">Inactivo</span>';

      // Lista de jugadores
      var ul = document.getElementById("ver_jugadores");
      ul.innerHTML = "";
      if (data.jugadores && data.jugadores.length) {
        data.jugadores.forEach(function (j) {
          var li = document.createElement("li");
          li.className =
            "list-group-item " +
            (j.status_id == 1 ? "text-success" : "text-muted");
          li.textContent =
            j.nombre + " (" + (j.status_id == 1 ? "Activo" : "Inactivo") + ")";
          ul.appendChild(li);
        });
      } else {
        ul.innerHTML =
          '<li class="list-group-item text-danger">No hay jugadores asociados</li>';
      }

      // Mostrar modal
      $("#modalVerInscripcion").modal("show");
    }
  };
}

function descargarPDFInscripcion() {
  var element = document.getElementById("contenidoPDFInscripcion");
  html2pdf()
    .set({
      margin: 0.5,
      filename: "inscripcion.pdf",
      image: { type: "jpeg", quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
    })
    .from(element)
    .save();
}

function actualizarFiltros() {
  const torneo = document.getElementById("torneo_id").value;
  const genero = document.getElementById("genero").value;
  const equipo = document.getElementById("equipo_id").value;

  if (torneo && genero) {
    cargarEquipos(torneo, genero, equipo, "equipo_id", false).then(() => {
      if (equipo) {
        cargarJugadoresNoInscritos(
          genero,
          equipo,
          torneo,
          [],
          "listaJugadores"
        );
      }
    });
  }
}
function actualizarFiltrosEditar() {
  const torneo = document.getElementById("editar_torneo_id").value;
  const genero = document.getElementById("editar_genero").value;
  const equipo = document.getElementById("editar_equipo_id").value;

  if (torneo && genero) {
    cargarEquipos(torneo, genero, equipo, "editar_equipo_id", false).then(
      () => {
        if (equipo) {
          cargarJugadoresNoInscritos(
            genero,
            equipo,
            torneo,
            [],
            "editar_listaJugadores"
          );
        }
      }
    );
  }
}

/**
 * Carga checkboxes de jugadores no inscritos en un torneo dentro de un equipo.
 *
 * @param {string} genero           — Código de género ("M" o "F").
 * @param {string|number} equipoId  — ID del equipo seleccionado.
 * @param {string|number} torneoId  — ID del torneo seleccionado.
 * @param {Array<string|number>} selectedIds — IDs de jugadores que deben ir marcados.
 * @param {string} selectId         — ID del contenedor donde inyectar los checkboxes.
 */
// SOLUCIÓN COMPLETA (código corregido)
const cargarJugadoresNoInscritos = (
  genero,
  equipoId,
  torneoId,
  selectedIds = [],
  selectId = "",
  inscritos = false
) => {
  if (selectId === "") {
    selectId = "listaJugadores";
  }
  if (!genero) {
    genero = document.getElementById("genero").value;
  }

  if (!genero || !equipoId || !torneoId) {
    document.getElementById(
      selectId
    ).innerHTML = `<p class="text-danger">Seleccione torneo, género y equipo primero</p>`;
    return;
  }

  let url = "";
  if (inscritos === true) {
    url =
      base_url +
      `Jugadores/ListarJugEquipo?genero=${encodeURIComponent(genero)}` +
      `&equipo_id=${encodeURIComponent(equipoId)}`;
  } else {
    url =
      base_url +
      `Jugadores/ListarNoInscritos?genero=${encodeURIComponent(genero)}` +
      `&equipo_id=${encodeURIComponent(equipoId)}` +
      `&torneo_id=${encodeURIComponent(torneoId)}`;
  }

  fetch(url)
    .then((res) => res.json())
    .then((data) => {
      // 1) Inyecto el HTML
      let html = "";
      if (data.length > 0) {
        html = `<div class="row">`;
        data.forEach((j) => {
          const isChecked = selectedIds.some((id) => id == j.cedula);
          html += `
            <div class="col-12 mb-1 d-flex align-items-center">
              <input class="form-check-input equipo-check" type="checkbox"
                     name="jugadores[]"
                     id="jugador_${j.cedula}"
                     value="${j.cedula}"
                     ${isChecked ? "checked" : ""}
                     style="accent-color: #28a745;">
              <label class="small ml-2" for="jugador_${j.cedula}"
                     style="color: ${isChecked ? "#28a745" : "#222"};
                            font-weight: ${isChecked ? "bold" : "normal"};">
                C.I: ${j.cedula} <br> ${j.nombre} ${j.apellido}
              </label>
            </div>
          `;
        });
        html += `</div>`;
      } else {
        html = `<div class="col-12"><p class="text-danger">No hay jugadores disponibles</p></div>`;
      }
      const container = document.getElementById(selectId);
      container.innerHTML = html;

      // 2) Marca manualmente los selectedIds (por si algo falló en el template)
      selectedIds.forEach((cedula) => {
        const cb = container.querySelector(`#jugador_${cedula}`);
        if (cb) cb.checked = true;
      });

      // 3) Aplica lógica de límite y estilos SOLO DENTRO DEL container
      const checkboxes = container.querySelectorAll(".equipo-check");
      const manejarCambio = () => {
        const seleccionados = Array.from(checkboxes).filter((c) => c.checked);
        const maximoAlcanzado = seleccionados.length >= 10;

        checkboxes.forEach((c) => {
          // deshabilito solo los que NO estén marcados
          if (!c.checked) {
            c.disabled = maximoAlcanzado;
          }
          // estilos de label
          const label = container.querySelector(`label[for="${c.id}"]`);
          if (c.checked) {
            label.style.color = "#28a745";
            label.style.fontWeight = "bold";
          } else {
            label.style.color = "#222";
            label.style.fontWeight = "normal";
          }
        });
      };

      checkboxes.forEach((cb) => cb.addEventListener("change", manejarCambio));
      manejarCambio();
    })
    .catch((err) => {
      console.error("Error al cargar jugadores:", err);
      document.getElementById(
        selectId
      ).innerHTML = `<p class="text-danger">Error al cargar jugadores</p>`;
    });
};
function actualizarEquiposInscritos() {
  const torneoId = document.getElementById("torneo_grupo").value;
  const genero = document.querySelector('input[name="genero"]:checked')?.value;

  if (torneoId && genero) {
    cargarEquiposInscritos(torneoId, genero);
  } else {
    document.getElementById(
      "listaEquiposCheckboxes"
    ).innerHTML = ` <span style="color:rgb(189, 5, 5); font-weight: bold; vertical-align: middle; margin-left: 0.8em;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.3em; height: 1.3em; vertical-align: middle; margin-right: 0.4em; margin-top: -0.3em;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke="rgb(189, 5, 5)" stroke-width="2" fill="none"/>
                            <path stroke=" rgb(189, 5, 5)" stroke-width="2" stroke-linecap="round" d="M12 8v4m0 4h.01"/>
                        </svg>
                    </span>
                    <p class="text-danger">Seleccione el torneo y el género</p>`;
  }
}

// carga la lista de equipos inscritos para asignar los grupos
const cargarEquiposInscritos = (
  torneoId,
  genero,
  selectId = "listaEquiposCheckboxes"
) => {
  const url = `${base_url}Inscripciones/listarEquiposInscritos?torneo_id=${torneoId}&genero=${genero}`;

  fetch(url)
    .then((res) => res.json())
    .then((data) => {
      let html = "";
      if (data.length > 0) {
        data.forEach((equipo) => {
          html += `
            <div class="col-12 col-md-6 mb-1">
              <div class="form-check form-check-sm d-flex align-items-center">
                <input class="form-check-input equipo-check" type="checkbox" name="equipos[]" id="equipo_${equipo.id}" value="${equipo.id}" checked disabled style="accent-color: #28a745;">
                <label class="form-check-label small ml-2" for="equipo_${equipo.id}">${equipo.nombre}</label>
              </div>
            </div>
          `;
        });
      } else {
        html = `
                    <div class="col-12"><p class="text-danger"><span style="color:rgb(189, 5, 5); font-weight: bold; vertical-align: middle;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.3em; height: 1.3em; vertical-align: middle; margin-right: 0.4em; margin-top: -0.3em;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke="rgb(189, 5, 5)" stroke-width="2" fill="none"/>
                            <path stroke=" rgb(189, 5, 5)" stroke-width="2" stroke-linecap="round" d="M12 8v4m0 4h.01"/>
                        </svg>
                    </span>No hay equipos inscritos</p></div>`;
      }
      document.getElementById(selectId).innerHTML = html;
    })
    .catch((err) => {
      console.error(err);
      document.getElementById(
        selectId
      ).innerHTML = `<p class="text-danger">Error al cargar los equipos</p>`;
    });
};
$("#modalAsignarGrupos").on("shown.bs.modal", function () {
  cargarTorneos("", "torneo_grupo").then(() => {
    actualizarEquiposInscritos();
  });
});

// funcion para asignar los equipos a sus respectivos grupos
const asignarEquiposAGrupos = () => {
  const torneo = document.getElementById("torneo_grupo").value;
  const genero = document.querySelector('input[name="genero"]:checked')?.value;
  const checkboxes = document.querySelectorAll(
    '#listaEquiposCheckboxes input[type="checkbox"]:checked'
  );

  if (!torneo || !genero || checkboxes.length === 0) {
    alertas(
      "Complete todos los campos y seleccione al menos un equipo",
      "warning"
    );
    return;
  }

  const equiposSeleccionados = Array.from(checkboxes).map((cb) => cb.value);

  console.log(equiposSeleccionados);
  if (equiposSeleccionados.length !== 28) {
    alertas("Deben seleccionarse exactamente 28 equipos", "warning");
    return;
  }

  Swal.fire({
    title: "¿Estás seguro?",
    text: "Se asignarán los equipos seleccionados a los grupos automáticamente.",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Sí, asignar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append("torneo_id", torneo);
      formData.append("genero", genero);
      equiposSeleccionados.forEach((eq) => formData.append("equipos[]", eq));

      const http = new XMLHttpRequest();
      http.open(
        "POST",
        base_url + "Inscripciones/asignarGruposAleatorio",
        true
      );
      http.send(formData);

      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          try {
            const res = JSON.parse(this.responseText);
            if (res.icono === "success") {
              $("#modalAsignarGrupos").modal("hide");
              document.getElementById("frmAsignarGrupos").reset();
            }
            alertas(res.msg, res.icono);
            tblInscripciones.ajax.reload();
            console.table(res.asignaciones || []); // Opcional para desarrollo
          } catch (error) {
            console.error("Error en respuesta:", this.responseText);
            alertas("Respuesta inesperada del servidor", "error");
          }
        }
      };
    }
  });
};

// filtro de inscripciones
function filtrarInscripciones() {
  const torneo = document.getElementById("filtro_torneo").value;
  const genero = document.getElementById("filtro_genero").value;
  const grupo = document.getElementById("filtro_grupo").value;
  const estado = document.getElementById("filtro_estado").value;

  const datos = new URLSearchParams();
  datos.append("torneo", torneo);
  datos.append("genero", genero);
  datos.append("grupo", grupo);
  datos.append("estado", estado);

  fetch(base_url + "Inscripciones/filtrar", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: datos.toString(),
  })
    .then((res) => res.json())
    .then((data) => {
      actualizarTablaInscripciones(data);
    });
}

function limpiarFiltrosInscripciones() {
  document.getElementById("filtro_torneo").selectedIndex = 0;
  document.getElementById("filtro_grupo").selectedIndex = 0;
  document.getElementById("filtro_estado").selectedIndex = 0;
  document.getElementById("filtro_genero").selectedIndex = 0;

  fetch(base_url + "Inscripciones/listar")
    .then((res) => res.json())
    .then((data) => {
      actualizarTablaInscripciones(data);
    });
}

function actualizarTablaInscripciones(data) {
  if ($.fn.DataTable.isDataTable("#tblInscripciones")) {
    const table = $("#tblInscripciones").DataTable();
    table.clear();
    table.rows.add(data);
    table.draw();
  }
}

// ✅ Agrega este listener para que filtre automáticamente al cambiar género
document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("filtro_genero")
    .addEventListener("change", filtrarInscripciones);
  document
    .getElementById("filtro_grupo")
    .addEventListener("change", filtrarInscripciones);
  document
    .getElementById("filtro_estado")
    .addEventListener("change", filtrarInscripciones);
  document
    .getElementById("filtro_torneo")
    .addEventListener("change", filtrarInscripciones);
});

// tabla de datos inscripciones
let tblInscripciones;
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
});
