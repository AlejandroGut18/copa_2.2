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
    const formData = new FormData(document.getElementById("frmInscripcionJugador"));
    formData.set("inscripcion_id", data[0].id);  // Asignar ID obtenido
    
    const resRegistro = await fetch(base_url + "Inscripciones/registrarJugador", {
      method: "POST",
      body: formData
    });
    
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


const btnEditarInscJugador = (id) => {
  document.getElementById("title").textContent = "Actualizar Inscripción";
  document.getElementById("btnAccion").textContent = "Modificar";

  const url = base_url + "Inscripciones/editarInscJugador/" + id;

  fetch(url)
    .then(response => response.json())
    .then(res => {
      document.getElementById("id").value = res.id;
      console.log("Respuesta del backend:", res);

      const torneoId = res.torneo_id;
      const genero = res.genero;
      const equipoId = res.equipo_id;
      const jugadorId = res.jugador_id; // ✅ Correcto
      cargarTorneos(torneoId);
      cargarGeneros(genero);

      return Promise.all([
        cargarEquipos(genero, torneoId, equipoId),
        cargarJugadores(genero, equipoId, jugadorId)
      ]);
    })
    .then(() => {
      $("#inscribir_jugador").modal("show");
    })
    .catch(error => {
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
      const url = base_url + `Inscripciones/eliminarInscJugador?id=${inscripcion_id}&cedula=${jugador_id}`;
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

const btnReingresarInscJugador = (inscripcion_id,jugador_id) => {
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
      const url = base_url + `Inscripciones/reingresarInscJugador?id=${inscripcion_id}&cedula=${jugador_id}`;
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
    .then(response => response.json())
    .then(res => {
      // Establecer valores directos primero
      document.getElementById("id").value = res.id;
      cargarGeneros(res.genero); // 👈 pasa el valor actual

      document.getElementById("status_id").value = res.status_id;
      // Manejar caso donde grupo_id es null
      const grupoId = res.grupo_id || "";  // Convertir null a string vacío
      // Ejecutar todas las cargas en paralelo
      return Promise.all([
        cargarTorneos(res.torneo_id),
        cargarGrupos(res.genero, res.torneo_id, grupoId),
        cargarEquipos(res.genero, res.torneo_id, res.equipo_id, "equipo_id", false)
      ]);
    })
    .then(() => {
      // Mostrar modal cuando todas las promesas se resuelvan
      $("#inscribir_equipo").modal("show");
    })
    .catch(error => {
      console.error("Error:", error);
      alertas("Error al cargar datos de inscripción", "error");
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
  const status_id = document.getElementById("status_id").value;

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
const frmActualizarPuntos = () => {
  document.getElementById("title").textContent = "Actualizar Puntos";
  document.getElementById("btnAccion").textContent = "Actualizar";
  document.getElementById("frmPuntos").reset();
  document.getElementById("juego_id").value = "";

  $("#actualizarPuntos").modal("show");
};

const btnActualizarPuntos = async (id) => { // Haz la función asíncrona
  document.getElementById("title").textContent = "Actualizar Inscripción";
  document.getElementById("btnAccion").textContent = "Modificar";

  const url = base_url + "Juegos/editar/" + id;

  try {
    const response = await fetch(url);
    const res = await response.json();
    
    document.getElementById("juego_id").value = res.id;
    const equipo1 = res.equipo_id;
    const equipo2 = res.vs_equipo_id;
    let equiposseleccionados = [equipo1, equipo2];

    // Espera a que se completen las operaciones de carga
    await cargarEquiposJuegos(
      res.genero,
      res.torneo_id,
      res.grupo_id,
      ["act_equipo_id", "act_vs_equipo_id"],
      equiposseleccionados
    );

    // Muestra el modal después de cargar los datos
    $("#actualizarPuntos").modal("show");
    
  } catch (error) {
    console.error("Error:", error);
    alertas("Error al cargar datos de inscripción", "error");
  }
};
const registrarPuntos = (e) => {
  e.preventDefault();

  const juego_id = document.getElementById("juego_id").value;
  const equipo1 = document.getElementById("act_equipo_id").value;
  const puntos1 = document.getElementById("puntos_equipo").value;
  const equipo2 = document.getElementById("act_vs_equipo_id").value;
  const puntos2 = document.getElementById("puntos_vs_equipo").value;

  if (!juego_id || !equipo1 || !equipo2) {
    alertas("Faltan datos del juego o equipos", "warning");
    return;
  }

  // Estructura de los puntos a registrar
  const datos = [
    { juego_id, equipo_id: equipo1, puntos: puntos1 },
    { juego_id, equipo_id: equipo2, puntos: puntos2 }
  ];

  fetch(base_url + "Juegos/registrarPuntos", {
    method: "POST",
    body: JSON.stringify(datos),
    headers: {
      "Content-Type": "application/json"
    }
  })
  .then(res => res.json())
  .then(resp => {
    if (resp.ok) {
      alertas("Puntos registrados correctamente", "success");
      $("#actualizarPuntos").modal("hide");
      // Opcional: refrescar tabla o vista
      // tblJuegos.ajax.reload();
    } else {
      alertas(resp.msg || "Error al registrar puntos", "error");
    }
  })
  .catch(error => {
    console.error("Error:", error);
    alertas("Error de conexión al registrar puntos", "error");
  });
};

function btnAgregarResultados(id) {
  fetch(base_url + "Juegos/editar/" + id)
    .then(res => res.json())
    .then(data => {
      // Llena el formulario
      document.getElementById("id").value = data.id;
      document.getElementById("torneo_id").value = data.torneo_id;
      document.getElementById("genero").value = data.genero;
      document.getElementById("grupo_id").value = data.grupo_id;
      document.getElementById("equipo_id").value = data.equipo_id;
      document.getElementById("vs_equipo_id").value = data.vs_equipo_id;
      document.getElementById("fecha").value = data.fecha;
      document.getElementById("hora").value = data.hora;
      document.getElementById("status_id").value = data.status_id;

      // Si tienes campos de puntos, muéstralos y actívalos para edición
      document.getElementById("puntos_equipo")?.removeAttribute("disabled");
      document.getElementById("puntos_vs_equipo")?.removeAttribute("disabled");

      // Cambia el título del modal si quieres
      document.getElementById("title").textContent = "Agregar Resultados";

      // Mostrar el modal
      $("#nuevoJuego").modal("show");

      // (Opcional) Si tienes pestañas dentro del modal, activa la pestaña de resultados
      $('#nav-tab a[href="#tabPuntos"]').tab("show");
    });
}



const frmEquipos = () => {
  document.getElementById("title").textContent = "Nuevo Equipo";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmEquipos").reset();
  document.getElementById("id").value = "";

  cargarDelegados();
  cargarGeneros();
  // Cargar delegados al abrir el modal
  $("#nuevoEquipo").modal("show");
};

const registrarEquipo = (e) => {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const delegado = document.getElementById("delegado");
  const genero = document.getElementById("genero");

  if (
    nombre.value.trim() === "" ||
    delegado.value === "" ||
    genero.value === ""
  ) {
    alertas("Todos los campos son requeridos", "warning");
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

const frmJugadores = () => {
  document.getElementById("title").textContent = "Nuevo Jugador";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmJugadores").reset();
  cargarGeneros();
  $("#nuevoJugador").modal("show");
};

// Función para registrar o actualizar jugadores
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
  } else if (!emailRegex.test(email.value)) {
    alertas("Por favor ingrese un email válido", "warning");
  } else if (!/^\d{7,10}$/.test(cedula.value.trim())) {
    alertas("La cédula debe contener entre 7 y 10 dígitos", "warning");
  } else if (!/^\d{11}$/.test(telefono.value.trim())) {
    alertas(
      "El teléfono debe tener exactamente 11 dígitos numéricos",
      "warning"
    );
  } else {
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
const btnEditarJugador = (id) => {
  document.getElementById("frmEditarJugador").reset();
  const url = base_url + "Jugadores/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("cedula_editar").value = res.cedula;
      document.getElementById("nombre_editar").value = res.nombre;
      document.getElementById("apellido_editar").value = res.apellido;
      document.getElementById("fecha_nacimiento_editar").value = res.fecha_nacimiento;
      document.getElementById("email_editar").value = res.email;
      document.getElementById("telefono_editar").value = res.telefono;
      document.getElementById("genero_editar").value = res.genero;
      document.getElementById("status_id_editar").value = res.status_id;

      $("#modalEditarJugador").modal("show");
    }
  };
};

const actualizarJugador = (e) => {
  e.preventDefault();
  const form = document.getElementById("frmEditarJugador");
  const url = base_url + "Jugadores/actualizar";
  const formData = new FormData(form);
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(formData);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      $("#modalEditarJugador").modal("hide");
      form.reset();
      tblJugadores.ajax.reload();
      alertas(res.msg, res.icono);
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

const frmGrupos = () => {
  document.getElementById("title").textContent = "Nueva Grupo";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmGrupos").reset();
  document.getElementById("id").value = "";

  cargarGeneros();
  cargarTorneos(); // Cargar torneos al abrir el modal
  $("#nuevoGrupo").modal("show");
};

const registrarGrupo = (e) => {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const torneo = document.getElementById("torneo");
  const genero = document.getElementById("genero");

  if (
    nombre.value.trim() === "" ||
    torneo.value === "" ||
    genero.value === ""
  ) {
    alertas("Todos los campos son requeridos", "warning");
  } else {
    const url = base_url + "Grupos/registrar";
    const frm = document.getElementById("frmGrupos");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevoGrupo").modal("hide");
        frm.reset();
        tblGrupos.ajax.reload();
        alertas(res.msg, res.icono);
      }
    };
  }
};

const btnEditarGrupo = (id) => {
  // console.log("Editando grupo con ID:", id); // ✅ prueba

  document.getElementById("title").textContent = "Actualizar Grupo";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Grupos/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4) {
      try {
        const res = JSON.parse(this.responseText);
        document.getElementById("id").value = res.id;
        document.getElementById("nombre").value = res.nombre;
        document.getElementById("torneo").value = res.torneo_id;
        document.getElementById("genero").value = res.genero;
        cargarTorneos(res.torneo_id);
        $("#nuevoGrupo").modal("show");
      } catch (err) {
        console.error("Error al parsear JSON:", err);
        console.warn("Respuesta del servidor:", this.responseText);
      }
    }
  };
};

const btnEliminarGrupo = (id) => {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El Grupo no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Grupos/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblGrupos.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};
const btnReingresarGrupo = (id) => {
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
      const url = base_url + "Grupos/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblGrupos.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
};

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
//Fin Usuarios
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
      cargarUbicaciones(res.ubicacion_id)
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

function preview(e) {
  var input = document.getElementById("imagen");
  var filePath = input.value;
  var extension = /(\.png|\.jpeg|\.jpg)$/i;
  if (!extension.exec(filePath)) {
    alertas("Seleccione un archivo valido", "warning");
    deleteImg();
    return false;
  } else {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `
        <button class="btn btn-danger" onclick="deleteImg()"><i class="fa fa-times-circle"></i></button>
        `;
  }
}
function deleteImg() {
  document.getElementById("icon-cerrar").innerHTML = "";
  document.getElementById("icon-image").classList.remove("d-none");
  document.getElementById("img-preview").src = "";
  document.getElementById("imagen").value = "";
  document.getElementById("foto_actual").value = "";
}
function frmConfig(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const telefono = document.getElementById("telefono");
  const direccion = document.getElementById("direccion");
  const correo = document.getElementById("correo");
  if (
    nombre.value == "" ||
    telefono.value == "" ||
    direccion.value == "" ||
    correo.value == ""
  ) {
    alertas("Todo los campos son requeridos", "warning");
  } else {
    const url = base_url + "Configuracion/actualizar";
    const frm = document.getElementById("frmConfig");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        alertas(res.msg, res.icono);
      }
    };
  }
}
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
if (document.getElementById("reportePrestamo")) {
  const url = base_url + "Configuracion/grafico";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const data = JSON.parse(this.responseText);
      let nombre = [];
      let cantidad = [];
      for (let i = 0; i < data.length; i++) {
        nombre.push(data[i]["titulo"]);
        cantidad.push(data[i]["cantidad"]);
      }
      var ctx = document.getElementById("reportePrestamo");
      var myPieChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: nombre,
          datasets: [
            {
              label: "Libros",
              data: cantidad,
              backgroundColor: function (context) {
                const chart = context.chart;
                const { ctx, chartArea } = chart;
                if (!chartArea) {
                  // This case happens on initial chart render
                  return null;
                }
                // Crear un degradado vertical de azul a verde
                const gradient = ctx.createLinearGradient(
                  0,
                  chartArea.top,
                  0,
                  chartArea.bottom
                );
                gradient.addColorStop(0, "rgb(8, 8, 59)");
                gradient.addColorStop(1, "rgb(0, 200, 83)");
                return gradient;
              },
            },
          ],
        },
      });
    }
  };
}
function alertas(msg, icono) {
  Swal.fire({
    position: "center",
    icon: icono,
    title: msg,
    showConfirmButton: false,
    timer: 3000,
  });
}
document.getElementById("btnSalir").addEventListener("click", function (e) {
  e.preventDefault(); // Evita que se vaya directamente

  Swal.fire({
    title: "¿Estás seguro de salir?",
    text: "Tu sesión se cerrará.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, salir",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = base_url + "Usuarios/salir";
    }
  });
});
