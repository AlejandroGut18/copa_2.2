const cargarTorneos = (selectedId = "", selectId = "", iniciado = false) => {
  if (selectId === "") {
    selectId = "torneo_id";
  }

  const select = document.getElementById(selectId);
  if (!select) {
    console.warn(`No se encontró el elemento con id="${selectId}"`);
    return;
  }

  const url = iniciado
    ? base_url + "Torneos/listarActivos?status=4"
    : base_url + "Torneos/listarActivos";

  return fetch(url)
    .then((response) => response.json())
    .then((data) => {
      select.innerHTML = "";

      if (data.length === 0) {
        select.innerHTML =
          "<option disabled selected>No hay torneos activos</option>";
        return;
      }

      // Si no se pasa selectedId, seleccionamos el primero por defecto
      const defaultId = selectedId !== "" ? selectedId : data[0].id;

      data.forEach((torneo) => {
        const option = document.createElement("option");
        option.value = torneo.id;
        option.textContent = torneo.nombre;
        if (torneo.id == defaultId) option.selected = true;
        select.appendChild(option);
      });
    })
    .catch((error) => {
      console.error("Error cargando torneos:", error);
      alertas("Error al cargar torneos", "error");
    });
};

// 2. Función cargarGrupos (actualizada)
const cargarGrupos = (torneo = null, genero = null, selectedId = "") => {
  let url = base_url + "Grupos/listarActivos";
  if (genero && torneo) {
    url += `?genero=${genero}&torneo_id=${torneo}`;
  }

  return fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      const select = document.getElementById("grupo_id");
      select.innerHTML =
        '<option value="" disabled selected>Seleccione un grupo</option>';

      data.forEach((grupo) => {
        const option = document.createElement("option");
        option.value = grupo.id;
        option.textContent = grupo.nombre;

        // Manejar comparación cuando selectedId es string vacío
        if (selectedId !== "" && grupo.id == selectedId) {
          option.selected = true;
        }
        select.appendChild(option);
      });

      // Manejar caso especial cuando grupo_id es null
      if (selectedId === "") {
        select.value = "";
      }
    })
    .catch((error) => {
      console.error("Error cargando grupos:", error);
      alertas("Error al cargar grupos", "error");
      // Crear opción vacía como fallback
      const select = document.getElementById("grupo_id");
      select.innerHTML =
        '<option value="" disabled selected>No se pudieron cargar grupos</option>';
    });
};
// 3. Función cargarEquipos (actualizada)
const cargarEquipos = (
  torneo = null,
  genero = null,
  selectedId = "",
  selectIds = "",
  inscritos = true
) => {
  if (selectIds === "") {
    selectIds = "equipo_id";
  }

  let url = base_url + "Equipos/Listar";

  if (genero && torneo) {
    if (inscritos) {
      url =
        base_url +
        "Equipos/ListarInscritos" +
        `?genero=${genero}&torneo_id=${torneo}`;
    } else {
      url =
        base_url +
        "Equipos/ListarNoInscritos" +
        `?genero=${genero}&torneo_id=${torneo}`;
    }
  } else if (genero) {
    url += `?genero=${genero}`;
  }

  return fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];

      ids.forEach((id) => {
        const select = document.getElementById(id);
        if (!select) return;

        // Limpiar opciones
        select.innerHTML =
          '<option value="" disabled selected>Seleccione un equipo</option>';

        data.forEach((equipo) => {
          const option = document.createElement("option");
          option.value = equipo.id;
          option.textContent = equipo.nombre;

          if (selectedId !== "" && equipo.id == selectedId) {
            option.selected = true;
          }

          select.appendChild(option);
        });

        if (selectedId === "") {
          select.value = "";
        }

        // Inicializar Select2 con dropdownParent dinámico
        const modalParent =
          id.includes("editar") || select.closest("#editar_inscripcion")
            ? $("#editar_inscripcion")
            : $("#inscribir_equipo");

        $(select).select2({
          placeholder: "Buscar equipo",
          width: "100%",
          dropdownParent: modalParent,
        });
      });
    })
    .catch((error) => {
      console.error("Error cargando equipos:", error);
      alertas("Error al cargar equipos", "error");

      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];
      ids.forEach((id) => {
        const select = document.getElementById(id);
        if (select) {
          select.innerHTML =
            '<option value="" disabled selected>No se pudieron cargar equipos</option>';
        }
      });
    });
};

const cargarDelegados = (selectedId = "") => {
  const selectDelegado = document.getElementById("delegado");

  // Limpiar opciones
  selectDelegado.innerHTML =
    '<option value="" disabled selected>Seleccione un Delegado</option>';

  // Obtener delegados del backend
  fetch(base_url + "Jugadores/listarDelegados")
    .then((response) => response.json())
    .then((data) => {
      if (Array.isArray(data)) {
        data.forEach((delegado) => {
          const option = document.createElement("option");
          option.value = delegado.cedula;
          option.textContent = `C.I:${delegado.cedula} - ${delegado.nombre} ${delegado.apellido}`;
          if (delegado.cedula == selectedId) {
            option.selected = true;
          }
          selectDelegado.appendChild(option);
        });

        // ✅ Inicializar Select2 dentro de modal con dropdownParent
        $("#delegado").select2({
          placeholder: "Buscar Delegado",
          width: "100%",
          dropdownParent: $("#nuevoEquipo"), // importante para que funcione en modales
        });
      } else {
        console.error("La respuesta de delegados no es un array:", data);
        alertas("No se pudieron cargar los delegados", "error");
      }
    })
    .catch((error) => {
      console.error("Error al obtener los delegados:", error);
      alertas("Error al cargar los delegados", "error");
    });
};
const cargarGeneros = (selected = "", selectId = "") => {
  // Si no se especifica selectId, usamos "genero"
  if (selectId === "") {
    selectId = "genero";
  }
  // Obtenemos el select por su ID dinámico
  const selectGenero = document.getElementById(selectId);
  if (!selectGenero) return; // Si no existe, salimos

  selectGenero.innerHTML = `
    <option value="" disabled ${selected === "" ? "selected" : ""}>
      Seleccione un género
    </option>
    <option value="M" ${selected === "M" ? "selected" : ""}>
      Masculino
    </option>
    <option value="F" ${selected === "F" ? "selected" : ""}>
      Femenino
    </option>
  `;
};

const cargarUbicaciones = (selectedId = "") => {
  $.ajax({
    url: base_url + "Ubicacion/listarActivos",
    type: "GET",
    dataType: "json",
    success: function (data) {
      const $select = $("#ubicacion_id");
      $select
        .empty()
        .append('<option value="" disabled selected>Seleccionar Sede</option>');

      data.forEach((ubicacion) => {
        const selected =
          selectedId !== "" && ubicacion.id == selectedId ? "selected" : "";
        $select.append(
          `<option value="${ubicacion.id}" ${selected}>${ubicacion.nombre}</option>`
        );
      });

      if (selectedId === "") {
        $select.val("");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error cargando ubicaciones:", error);
      alertas("Error al cargar ubicaciones", "error");
      $("#ubicacion_id").html(
        '<option value="" disabled selected>No se pudieron cargar las Sedes</option>'
      );
    },
  });
};

const cargarJugadores = (
  genero = null,
  equipo = null,
  torneo = null,
  selectedId = "",
  selectIds = "jugador",
  inscritos = true
) => {
  if (genero && equipo) {
    if (inscritos) {
      url =
        base_url +
        "Jugadores/ListarJugEquipo" +
        `?genero=${genero}&equipo_id=${equipo}`;
    } else {
      url =
        base_url +
        "Jugadores/ListarNoInscritos" +
        `?genero=${genero}&equipo_id=${equipo}&torneo_id=${torneo}`;
    }
  } else if (genero) {
    url += `?genero=${genero}`;
  }

  return fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];

      ids.forEach((id) => {
        const select = document.getElementById(id);
        if (!select) return;

        select.innerHTML =
          '<option value="" disabled selected>Seleccione un Jugador</option>';

        data.forEach((jugador) => {
          const option = document.createElement("option");
          option.value = jugador.cedula;
          option.textContent = `C.I: ${jugador.cedula} - ${jugador.nombre} ${jugador.apellido}`;

          if (selectedId !== "" && jugador.cedula == selectedId) {
            option.selected = true;
          }

          select.appendChild(option);
        });

        if (selectedId === "") {
          select.value = "";
        }
      });
    })
    .catch((error) => {
      console.error("Error cargando jugadores:", error);
      alertas("Error al cargar jugadores", "error");

      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];
      ids.forEach((id) => {
        const select = document.getElementById(id);
        if (select) {
          select.innerHTML =
            '<option value="" disabled selected>No se pudieron cargar jugadores</option>';
        }
      });
    });
};

const cargarEquiposJuegos = (
  genero = null,
  torneo = null,
  grupo = null,
  selectIds = ["equipo_id", "vs_equipo_id"],
  selectedIds = []
) => {
  let url = "";

  if (genero && torneo && grupo) {
    url =
      base_url +
      "Equipos/ListarInscritos" +
      `?genero=${genero}&torneo_id=${torneo}&grupo_id=${grupo}`;
  } else {
    console.error();
  }

  return fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];
      const selected = Array.isArray(selectedIds) ? selectedIds : [];

      ids.forEach((id, index) => {
        const select = document.getElementById(id);
        if (!select) return;

        const selectedValue = selected[index] || "";

        select.innerHTML =
          '<option value="" disabled selected>Seleccione un equipo</option>';

        data.forEach((equipo) => {
          const option = document.createElement("option");
          option.value = equipo.id;
          option.textContent = equipo.nombre;

          if (equipo.id == selectedValue) {
            option.selected = true;
          }

          select.appendChild(option);
        });

        if (!selectedValue) {
          select.value = "";
        }
      });
    })
    .catch((error) => {
      console.error("Error cargando equipos del juego:", error);
      alertas("Error al cargar equipos", "error");

      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];
      ids.forEach((id) => {
        const select = document.getElementById(id);
        if (select) {
          select.innerHTML =
            '<option value="" disabled selected>No se pudieron cargar equipos</option>';
        }
      });
    });
};

function actualizarFiltrosJuegos() {
  const torneo = document.getElementById("torneo_id").value;
  const genero = document.getElementById("genero").value;
  const grupoSelect = document.getElementById("grupo_id");
  const grupoSeleccionado = grupoSelect.value;

  if (torneo && genero) {
    cargarGrupos(torneo, genero).then(() => {
      // Reasignar el valor seleccionado después de que se haya cargado el nuevo select
      grupoSelect.value = grupoSeleccionado;

      if (grupoSeleccionado) {
        cargarEquiposJuegos(genero, torneo, grupoSeleccionado, [
          "equipo_id",
          "vs_equipo_id",
        ]);
      }
    });
  }
}
