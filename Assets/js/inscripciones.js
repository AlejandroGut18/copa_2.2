// inscripcion jugadores

const frmInscripcionJugador = () => {
  document.getElementById("title").textContent = "Inscribir Jugador";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmInscripcionJugador").reset();

  cargarTorneos(); // carga en #torneo_id
  cargarGeneros(); // carga en #genero
  // Los demás (equipos y jugadores) se actualizan con onchange: actualizarFiltrosJug()

  $("#inscribir_jugador").modal("show");
};

const registrarInscJugador = async (e) => {
  e.preventDefault();

  const torneo = document.getElementById("torneo_id").value;
  const genero = document.getElementById("genero").value;
  const equipo = document.getElementById("equipo_id").value;
  const jugador = document.getElementById("jugador").value;

  if (!torneo || !genero || !equipo || !jugador) {
    alertas("Todos los campos son obligatorios", "warning");
    return;
  }
  try {
    // 1. Buscar ID de inscripción (existente)
    const res = await fetch(
      `${base_url}Inscripciones/buscarInscripcion?torneo_id=${torneo}&genero=${genero}&equipo_id=${equipo}`
    );

    if (!res.ok) throw new Error("Error al buscar inscripción");

    const data = await res.json();
    if (!data?.[0]?.id) {
      alertas("No se encontró inscripción para ese equipo", "error");
      return;
    }

    // 2. Registrar jugador usando fetch
    const formData = new FormData(
      document.getElementById("frmInscripcionJugador")
    );
    formData.set("inscripcion_id", data[0].id); // Asignar ID obtenido

    const resRegistro = await fetch(
      base_url + "Inscripciones/registrarJugador",
      {
        method: "POST",
        body: formData,
      }
    );

    if (!resRegistro.ok) throw new Error("Error en registro");

    const result = await resRegistro.json();
    $("#inscribir_jugador").modal("hide");
    document.getElementById("frmInscripcionJugador").reset();
    tblInscripcionesJugador.ajax.reload();
    alertas(result.msg, result.icono);
  } catch (error) {
    console.error(error);
    alertas("Error en el proceso: " + error.message, "error");
  }
};

const btnEditarInscJugador = (id, jugador_id) => {
  document.getElementById("title").textContent = "Actualizar Inscripción";
  document.getElementById("btnAccion").textContent = "Modificar";

  const url = `${base_url}Inscripciones/editarInscJugador?id=${id}&cedula=${jugador_id}`;

  fetch(url)
    .then((response) => response.json())
    .then((res) => {
      document.getElementById("id").value = res.id;
      console.log("Respuesta del backend:", res);

      const torneoId = res.torneo_id;
      const genero = res.genero;
      const equipoId = res.equipo_id;
      const jugadorId = res.jugador_id;
      cargarTorneos(torneoId);
      cargarGeneros(genero);

      return Promise.all([
        cargarEquipos(genero, torneoId, equipoId),
        cargarJugadores(genero, equipoId, jugadorId),
      ]);
    })
    .then(() => {
      $("#inscribir_jugador").modal("show");
    })
    .catch((error) => {
      console.error("Error:", error);
      alertas("Error al cargar inscripción", "error");
    });
};

const btnEliminarInscJugador = (inscripcion_id, jugador_id) => {
  Swal.fire({
    title: "¿Está seguro de eliminar?",
    text: "El Jugador no se eliminará de forma permanente, solo cambiará el estado a inactivo.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url =
        base_url +
        `Inscripciones/eliminarInscJugador?id=${inscripcion_id}&cedula=${jugador_id}`;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblInscripcionesJugador.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};

const btnReingresarInscJugador = (inscripcion_id, jugador_id) => {
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
      const url =
        base_url +
        `Inscripciones/reingresarInscJugador?id=${inscripcion_id}&cedula=${jugador_id}`;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblInscripcionesJugador.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};
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
  const grupo = document.getElementById("grupo_id").value;
  const equipo = document.getElementById("equipo_id").value;

  if (torneo === "" || genero === "" || equipo === "") {
    alertas(" Todos los campos obligatorios son requeridos", "warning");
    return;
  }
  const url = base_url + "Inscripciones/registrar";
  const frm = document.getElementById("frmInscripcion");
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      const res = JSON.parse(this.responseText);
      $("#inscribir_equipo").modal("hide");
      frm.reset();
      tblInscripciones.ajax.reload();
      alertas(res.msg, res.icono);
    }
  };
};

const btnEditarInscripcion = (id) => {
  document.getElementById("title").textContent = "Actualizar Inscripción";
  document.getElementById("btnAccion").textContent = "Modificar";

  const url = base_url + "Inscripciones/editar/" + id;

  fetch(url)
    .then((response) => response.json())
    .then((res) => {
      // Establecer valores directos primero
      document.getElementById("id").value = res.id;
      cargarGeneros(res.genero); // 👈 pasa el valor actual

      document.getElementById("status_id").value = res.status_id;
      // Manejar caso donde grupo_id es null
      const grupoId = res.grupo_id || ""; // Convertir null a string vacío
      // Ejecutar todas las cargas en paralelo
      return Promise.all([
        cargarTorneos(res.torneo_id),
        cargarGrupos(res.genero, res.torneo_id, grupoId),
        cargarEquipos(
          res.genero,
          res.torneo_id,
          res.equipo_id,
          "equipo_id",
          false
        ),
      ]);
    })
    .then(() => {
      // Mostrar modal cuando todas las promesas se resuelvan
      $("#inscribir_equipo").modal("show");
    })
    .catch((error) => {
      console.error("Error:", error);
      alertas("Error al cargar datos de inscripción", "error");
    });
};
