
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

const btnActualizarPuntos = async (id) => {
  document.getElementById("title").textContent = "Actualizar Puntos";
  document.getElementById("btnAccion").textContent = "Modificar";

  const url = base_url + "Juegos/editar/" + id;

  try {
    const response = await fetch(url);
    const res = await response.json();

    document.getElementById("juego_id").value = res.id;

    const equipo1 = res.equipo_id;
    const equipo2 = res.vs_equipo_id;

    const equiposSeleccionados = [equipo1, equipo2];

    await cargarEquiposJuegos(
      res.genero,
      res.torneo_id,
      res.grupo_id,
      ["act_equipo_id", "act_vs_equipo_id"],
      equiposSeleccionados
    );

    document.getElementById("puntos_equipo").value = res.puntos_equipo;
    document.getElementById("puntos_vs_equipo").value = res.puntos_vs_equipo;

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

  if (!juego_id || !equipo1 || !equipo2 || puntos1 === "" || puntos2 === "") {
    alertas("Faltan datos del juego o puntos", "warning");
    return;
  }

  // Enviar ambos registros, incluyendo el equipo rival en cada uno
  const datos = [
    {
      juego_id,
      equipo_id: equipo1,
      puntos: puntos1,
      vs_equipo_id: equipo2,
      puntos_vs_equipo: puntos2
    },
    {
      juego_id,
      equipo_id: equipo2,
      puntos: puntos2,
      vs_equipo_id: equipo1,
      puntos_vs_equipo: puntos1
    }
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
        // tblJuegos.ajax.reload(); // si usas DataTables
      } else {
        alertas(resp.msg || "Error al registrar puntos", "error");
      }
    })
    .catch(error => {
      console.error("Error:", error);
      alertas("Error de conexión al registrar puntos", "error");
    });
};
