const btnEditarJuego = (id) => {
  const url = base_url + "Juegos/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        const res = JSON.parse(this.responseText);
        console.log("Datos del juego:", res);
        document.getElementById("nombre_equipo1").textContent = res.equipo1;
        document.getElementById("nombre_equipo2").textContent = res.equipo2;
        const basePath = base_url + "Assets/logos/"; // o donde tengas las imágenes

        document.getElementById("logo_equipo1").src = res.logo1
          ? basePath + res.logo1
          : basePath + "default1.png";
        document.getElementById("logo_equipo2").src = res.logo2
          ? basePath + res.logo2
          : basePath + "default2.png";

        // Rellenar campos del modal
        document.getElementById("juego_id").value = res.id;
        document.getElementById("fecha_juego").value = res.fecha_juego || "";
        document.getElementById("hora_juego").value = res.hora || "";

        // Mostrar modal
        document.getElementById("modalEditarJuegoLabel").textContent =
          "Editar Fecha y Hora del Juego";
        $("#modalEditarJuego").modal("show");
      } catch (error) {
        console.error("Error al parsear respuesta del juego:", error);
        alertas("Error al cargar datos del juego", "error");
      }
    }
  };
};

const actualizarJuego = (e) => {
  e.preventDefault();

  const id = document.getElementById("juego_id").value;
  const fecha = document.getElementById("fecha_juego").value;
  const hora = document.getElementById("hora_juego").value;

  if (!fecha || !hora) {
    alertas("Fecha y hora son obligatorios", "warning");
    return;
  }

  const form = document.getElementById("formEditarJuego");
  const url = base_url + "Juegos/actualizarFechaHora";
  const formData = new FormData(form);

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(formData);

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {
        const res = JSON.parse(this.responseText);
        if (res.icono === "success") {
          $("#modalEditarJuego").modal("hide");
          form.reset();
          if (typeof tblJuegos !== "undefined") {
            tblJuegos.ajax.reload();
          }
        }
        alertas(res.msg, res.icono);
      } catch (error) {
        console.error("Error al procesar respuesta:", this.responseText);
        alertas("Error inesperado del servidor", "error");
      }
    }
  };
};

// funcion para cargar y poder actualizarlo los detalles del juego
// Abrir y poblar el modal con datos del servidor
const btnActualizarPuntos = (id) => {
  fetch(`${base_url}Juegos/editarDetallesJuego/${id}`)
    .then((res) => res.json())
    .then((data) => {
      if (data.msg) {
        // Error retornado por el controlador
        return alertas(data.msg, "error");
      }

      // Logos y nombres de equipos
      document.getElementById("nombre_equipo1_detalle").textContent =
        data.equipo1.nombre;
      document.getElementById("nombre_equipo2_detalle").textContent =
        data.equipo2.nombre;
      document.getElementById("logo_equipo1_detalle").src =
        data.equipo1.logo || "ruta/logo_defecto1.png";
      document.getElementById("logo_equipo2_detalle").src =
        data.equipo2.logo || "ruta/logo_defecto2.png";

      // Títulos encima de cada tabla
      document.getElementById("nombre_equipo1_titulo").textContent =
        data.equipo1.nombre;
      document.getElementById("nombre_equipo2_titulo").textContent =
        data.equipo2.nombre;

      // Puntos actuales
      document.getElementById("juego_id_detalle").value = data.juego.id;
      document.getElementById("inscripcion_equipo1_id").value =
        data.equipo1.inscripcion_id;
      document.getElementById("inscripcion_equipo2_id").value =
        data.equipo2.inscripcion_id;
      document.getElementById("puntos_equipo1").value = data.juego.puntos;
      document.getElementById("puntos_equipo2").value = data.juego.puntos_vs;

      // Carga jugadores equipo 1
      const tbody1 = document.getElementById("tbodyJugadoresEquipo1");
      tbody1.innerHTML = "";
      data.equipo1.jugadores.forEach((j) => {
        tbody1.innerHTML += generarCamposJugador(
          j,
          "equipo1",
          data.juego.id,
          data.equipo1.inscripcion_id
        );
      });

      // Carga jugadores equipo 2
      const tbody2 = document.getElementById("tbodyJugadoresEquipo2");
      tbody2.innerHTML = "";
      data.equipo2.jugadores.forEach((j) => {
        tbody2.innerHTML += generarCamposJugador(
          j,
          "equipo2",
          data.juego.id,
          data.equipo2.inscripcion_id
        );
      });

      // Mostrar modal
      $("#modalActualizarPuntos").modal("show");
    })
    .catch((err) => {
      console.error("Error cargando juego:", err);
      alertas("No se pudo cargar la información del juego", "error");
    });
};

// Genera el bloque de inputs para cada jugador
function generarCamposJugador(jugador, grupo, juego_id, inscripcion_id) {
  return `
    <tr>
      <td>${jugador.nombre} ${jugador.apellido}</td>
      <td>
        <input type="number" name="rendimiento[${grupo}][${jugador.cedula}][arrimesL]"
               class="form-control form-control-sm" min="0" value="${jugador.arrimesL}">
      </td>
      <td>
        <input type="number" name="rendimiento[${grupo}][${jugador.cedula}][arrimesB]"
               class="form-control form-control-sm" min="0" value="${jugador.arrimesB}">
      </td>
      <td>
        <input type="number" name="rendimiento[${grupo}][${jugador.cedula}][bochesL]"
               class="form-control form-control-sm" min="0" value="${jugador.bochesL}">
      </td>
      <td>
        <input type="number" name="rendimiento[${grupo}][${jugador.cedula}][bochesB]"
               class="form-control form-control-sm" min="0" value="${jugador.bochesB}">
      </td>
      <td>
        <input type="number" name="rendimiento[${grupo}][${jugador.cedula}][rastererosL]"
               class="form-control form-control-sm" min="0" value="${jugador.rastererosL}">
      </td>
      <td>
        <input type="number" name="rendimiento[${grupo}][${jugador.cedula}][rastrerosB]"
               class="form-control form-control-sm" min="0" value="${jugador.rastrerosB}">
      </td>
    </tr>
  `;
}

// Handler del submit: guarda puntos y planilla
const guardarDetalleJuego = (e) => {
  e.preventDefault();
  const form = document.getElementById("formActualizarPuntos");

  // 1) Validar puntos de equipo
  const p1Field = document.getElementById("puntos_equipo1");
  const p2Field = document.getElementById("puntos_equipo2");
  const p1 = parseInt(p1Field.value, 10);
  const p2 = parseInt(p2Field.value, 10);

  if (isNaN(p1) || isNaN(p2)) {
    return Swal.fire({
      icon: "warning",
      title: "Error de validación",
      text: "Los puntos de equipo deben ser números",
      showConfirmButton: true,
      timer: 3000,
      timerProgressBar: true,
    });
  }
  if (p1 < 0 || p2 < 0) {
    return Swal.fire({
      icon: "warning",
      title: "Error de validación",
      text: "Los puntos no pueden ser negativos",
      showConfirmButton: true,
      timer: 3000,
      timerProgressBar: true,
    });
  }
  if (p1 > 100 || p2 > 100) {
    return Swal.fire({
      icon: "warning",
      title: "Error de validación",
      text: "Los puntos no pueden superar 100",
      showConfirmButton: true,
      timer: 3000,
      timerProgressBar: true,
    });
  }

  // 2) Validar cada planilla de jugadores
  const validarRow = (row, equipoName) => {
    const al = row.querySelector('input[name*="[arrimesL]"]');
    const ab = row.querySelector('input[name*="[arrimesB]"]');
    const bl = row.querySelector('input[name*="[bochesL]"]');
    const bb = row.querySelector('input[name*="[bochesB]"]');
    const rl = row.querySelector('input[name*="[rastererosL]"]');
    const rb = row.querySelector('input[name*="[rastrerosB]"]');

    const v = {
      al: parseInt(al.value, 10),
      ab: parseInt(ab.value, 10),
      bl: parseInt(bl.value, 10),
      bb: parseInt(bb.value, 10),
      rl: parseInt(rl.value, 10),
      rb: parseInt(rb.value, 10),
    };

    // números y ≥ 0
    for (let key of ["al", "ab", "bl", "bb", "rl", "rb"]) {
      if (isNaN(v[key]) || v[key] < 0) {
        throw `Valores inválidos en ${equipoName}, jugador ${
          row.querySelector("td").textContent
        }`;
      }
    }
    // comparaciones
    if (v.al < v.ab)
      throw `Arrimes L no pueden ser menor a Arrimes B en ${equipoName}, jugador ${
        row.querySelector("td").textContent
      }`;
    if (v.bl < v.bb)
      throw `Boches L no pueden ser menor a Boches B en ${equipoName}, jugador ${
        row.querySelector("td").textContent
      }`;
    if (v.rl < v.rb)
      throw `Rastreros L no pueden ser menor a Rastreros B en ${equipoName}, jugador ${
        row.querySelector("td").textContent
      }`;
  };

  try {
    document
      .querySelectorAll("#tbodyJugadoresEquipo1 tr")
      .forEach((row) => validarRow(row, "Equipo 1"));
    document
      .querySelectorAll("#tbodyJugadoresEquipo2 tr")
      .forEach((row) => validarRow(row, "Equipo 2"));
  } catch (msg) {
    return Swal.fire({
      icon: "warning",
      title: "Error de validación",
      text: msg,
      showConfirmButton: true,
      timer: 10000,
      timerProgressBar: true,
    });
  }

  // 3) Enviar al servidor
  const data = new FormData(form);
  fetch(base_url + "Juegos/guardarDetalleJuego", {
    method: "POST",
    body: data,
  })
    .then((res) => res.json())
    .then((res) => {
      Swal.fire({
        icon: res.icono,
        title: res.icono === "success" ? "Éxito" : "Error",
        text: res.msg,
        showConfirmButton: true,
        timer: res.icono === "success" ? 2000 : 4000,
        timerProgressBar: true,
      }).then(() => {
        if (res.icono === "success") {
          $("#modalActualizarPuntos").modal("hide");
          tblJuegos.ajax.reload();
        }
      });
    })
    .catch((err) => {
      console.error("Error guardando detalle:", err);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Error al guardar los datos",
        showConfirmButton: true,
        timer: 4000,
        timerProgressBar: true,
      });
    });
};

const frmJuegos = () => {
  document.getElementById("title").textContent = "Registro de Juego";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmJuegos").reset();
  document.getElementById("id").value = "";

  cargarTorneos();
  cargarGeneros();
  // cargarEquipos(null, null, "", ["equipo_id", "vs_equipo_id"]);

  $("#nuevoJuego").modal("show");
};

const registrarJuego = (e) => {
  e.preventDefault();
  const frm = document.getElementById("frmJuegos");

  if (!frm) {
    console.error("No se encontró el formulario 'frmJuegos'");
    return;
  }

  const torneo = document.getElementById("torneo_id").value;
  const grupo = document.getElementById("grupo_id").value;
  const equipo1 = document.getElementById("equipo_id").value;
  const equipo2 = document.getElementById("vs_equipo_id").value;
  const genero = document.getElementById("genero").value;
  const fecha = document.getElementById("fecha").value;
  const hora = document.getElementById("hora").value;
  // const status_id = document.getElementById("status_id").value;

  if (!torneo || !grupo || !equipo1 || !equipo2 || !genero || !fecha || !hora) {
    alertas("Todos los campos son requeridos", "warning");
    return;
  }

  // 🚫 Validación adicional: los equipos no pueden ser el mismo
  if (equipo1 === equipo2) {
    alertas("Los equipos no pueden ser iguales", "error");
    return;
  }

  const url = base_url + "Juegos/registrar";
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      const res = JSON.parse(this.responseText);
      console.log(res); // 👈 Verifica que esto imprime el objeto

      $("#nuevoJuego").modal("hide");
      frm.reset();
      tblJuegos.ajax.reload();
      alertas(res.msg, res.icono);
    }
  };
};
// const frmActualizarPuntos = () => {
//   document.getElementById("title").textContent = "Actualizar Puntos";
//   document.getElementById("btnAccion").textContent = "Actualizar";
//   document.getElementById("frmPuntos").reset();
//   document.getElementById("juego_id").value = "";

//   $("#actualizarPuntos").modal("show");
// };

// const btnActualizarPuntos = async (id) => {
//   document.getElementById("title").textContent = "Actualizar Puntos";
//   document.getElementById("btnAccion").textContent = "Modificar";

//   const url = base_url + "Juegos/editar/" + id;

//   try {
//     const response = await fetch(url);
//     const res = await response.json();

//     document.getElementById("juego_id").value = res.id;

//     const equipo1 = res.equipo_id;
//     const equipo2 = res.vs_equipo_id;

//     const equiposSeleccionados = [equipo1, equipo2];

//     await cargarEquiposJuegos(
//       res.genero,
//       res.torneo_id,
//       res.grupo_id,
//       ["act_equipo_id", "act_vs_equipo_id"],
//       equiposSeleccionados
//     );

//     document.getElementById("puntos_equipo").value = res.puntos_equipo;
//     document.getElementById("puntos_vs_equipo").value = res.puntos_vs_equipo;

//     $("#actualizarPuntos").modal("show");
//   } catch (error) {
//     console.error("Error:", error);
//     alertas("Error al cargar datos de inscripción", "error");
//   }
// };

// const registrarPuntos = (e) => {
//   e.preventDefault();

//   const juego_id = document.getElementById("juego_id").value;
//   const equipo1 = document.getElementById("act_equipo_id").value;
//   const puntos1 = document.getElementById("puntos_equipo").value;
//   const equipo2 = document.getElementById("act_vs_equipo_id").value;
//   const puntos2 = document.getElementById("puntos_vs_equipo").value;

//   if (!juego_id || !equipo1 || !equipo2 || puntos1 === "" || puntos2 === "") {
//     alertas("Faltan datos del juego o puntos", "warning");
//     return;
//   }

//   // Enviar ambos registros, incluyendo el equipo rival en cada uno
//   const datos = [
//     {
//       juego_id,
//       equipo_id: equipo1,
//       puntos: puntos1,
//       vs_equipo_id: equipo2,
//       puntos_vs_equipo: puntos2,
//     },
//     {
//       juego_id,
//       equipo_id: equipo2,
//       puntos: puntos2,
//       vs_equipo_id: equipo1,
//       puntos_vs_equipo: puntos1,
//     },
//   ];

//   fetch(base_url + "Juegos/registrarPuntos", {
//     method: "POST",
//     body: JSON.stringify(datos),
//     headers: {
//       "Content-Type": "application/json",
//     },
//   })
//     .then((res) => res.json())
//     .then((resp) => {
//       if (resp.ok) {
//         alertas("Puntos registrados correctamente", "success");
//         $("#actualizarPuntos").modal("hide");
//         // tblJuegos.ajax.reload(); // si usas DataTables
//       } else {
//         alertas(resp.msg || "Error al registrar puntos", "error");
//       }
//     })
//     .catch((error) => {
//       console.error("Error:", error);
//       alertas("Error de conexión al registrar puntos", "error");
//     });
// };

// filtros

function filtrarJuegos() {
  const torneo = document.getElementById("filtro_torneo_juego").value;
  const equipo = document.getElementById("filtro_equipo_juego").value;
  const genero = document.getElementById("filtro_genero_juego").value || "";
  const estado = document.getElementById("filtro_estado_juego").value;

  const datos = new URLSearchParams();
  datos.append("torneo", torneo);
  datos.append("equipo", equipo);
  datos.append("genero", genero);
  datos.append("estado", estado);

  fetch(base_url + "Juegos/filtrar", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: datos.toString(),
  })
    .then((res) => res.json())
    .then((data) => {
      actualizarTablaJuegos(data);
    });
}

function limpiarFiltrosJuegos() {
  document.getElementById("filtro_torneo_juego").selectedIndex = 0;
  document.getElementById("filtro_equipo_juego").selectedIndex = 0;
  document.getElementById("filtro_estado_juego").selectedIndex = 0;
  document.getElementById("filtro_genero_juego").selectedIndex = 0;

  fetch(base_url + "Juegos/listar")
    .then((res) => res.json())
    .then((data) => actualizarTablaJuegos(data));
}

function actualizarTablaJuegos(data) {
  if ($.fn.DataTable.isDataTable("#tblJuegos")) {
    const table = $("#tblJuegos").DataTable();
    table.clear();
    table.rows.add(data);
    table.draw();
  }
}
// cargar los equipos de acuerdo al torneo

function cargarEquiposFiltroJuegos() {
  const torneo = document.getElementById("filtro_torneo_juego").value;
  const genero = document.getElementById("filtro_genero_juego").value || "";

  if (!torneo || !genero) {
    document.getElementById("filtro_equipo_juego").innerHTML =
      '<option value="">Seleccione</option>';
    return;
  }

  const datos = new URLSearchParams();
  datos.append("torneo", torneo);
  datos.append("genero", genero);

  fetch(
    base_url +
      "Equipos/ListarInscritos" +
      `?genero=${genero}&torneo_id=${torneo}`,
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: datos.toString(),
    }
  )
    .then((res) => res.json())
    .then((data) => {
      const select = document.getElementById("filtro_equipo_juego");
      select.innerHTML = '<option value="">Todos</option>';
      data.forEach((equipo) => {
        select.innerHTML += `<option value="${equipo.id}">${equipo.nombre}</option>`;
      });
    });
}

// Escuchar cambios
document
  .getElementById("filtro_torneo_juego")
  .addEventListener("change", cargarEquiposFiltroJuegos);

document
  .getElementById("filtro_genero_juego")
  .addEventListener("change", cargarEquiposFiltroJuegos);

//muestra los equipos por grupo y genero de un  torneo

function actualizarEquiposPorGrupo() {
  const torneo = document.getElementById("torneo_juego").value;
  const genero = document.querySelector('input[name="genero"]:checked')?.value;
  const contenedor = document.getElementById("contenedorEquiposPorGrupo");

  contenedor.innerHTML = "";

  if (!torneo || !genero) return;

  fetch(
    `${base_url}Inscripciones/equiposPorGrupo?torneo=${torneo}&genero=${genero}`
  )
    .then((res) => res.json())
    .then((data) => {
      if (!data || data.length === 0) {
        alertas(
          "No hay equipos inscritos en grupos para este torneo y género",
          "warning"
        );
        return;
      }

      // Mostrar alerta si hay menos de 28
      if (data.length < 28) {
        alertas(
          `Faltan equipos para completar los 28. Actualmente hay ${data.length} inscritos en grupos.`,
          "info"
        );
      }

      // Agrupar por letra de grupo (A, B, C, D)
      const grupos = {};
      data.forEach((equipo) => {
        if (!grupos[equipo.grupo]) grupos[equipo.grupo] = [];
        grupos[equipo.grupo].push(equipo);
      });

      for (const letra in grupos) {
        const grupoHTML = `
          <div class="col-md-6 mb-3">
            <div class="border p-2 rounded">
              <h6>Grupo ${letra}</h6>
              ${grupos[letra]
                .map(
                  (eq) => `
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" checked disabled name="equipos[]" value="${eq.equipo_id}">
                  <label class="form-check-label">${eq.nombre}</label>
                </div>`
                )
                .join("")}
            </div>
          </div>
        `;
        contenedor.innerHTML += grupoHTML;
      }
    })
    .catch((error) => {
      console.error("Error al cargar equipos por grupo:", error);
      alertas("Error al consultar los equipos. Intenta nuevamente", "error");
    });
}

//
function generarEnfrentamientos() {
  const torneo = document.getElementById("torneo_juego").value;
  const genero = document.querySelector('input[name="genero"]:checked')?.value;

  if (!torneo || !genero) {
    alertas("Seleccione torneo y género", "warning");
    return;
  }

  Swal.fire({
    title: "¿Generar enfrentamientos?",
    text: "Se crearán automáticamente los juegos entre los equipos del grupo.",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Sí, generar",
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append("torneo_id", torneo);
      formData.append("genero", genero);

      fetch(`${base_url}Juegos/generarRoundRobin`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          alertas(res.msg, res.icono);
          if (res.icono === "success") {
            $("#modalGenerarEnfrentamientos").modal("hide");
            tblJuegos.ajax.reload();
          }
        });
    }
  });
}

let tblJuegos;
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
