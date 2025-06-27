const cargarTorneos = (selectedId = "") => {
  return fetch(base_url + 'Torneos/listarActivos')
    .then(response => response.json())
    .then(data => {
      const select = document.getElementById("torneo_id");
      select.innerHTML = '<option value="" disabled selected>Seleccione un torneo</option>';
      
      data.forEach(torneo => {
        const option = document.createElement("option");
        option.value = torneo.id;
        option.textContent = torneo.nombre;
        if (torneo.id == selectedId) option.selected = true;
        select.appendChild(option);
      });
    })
    .catch(error => {
      console.error("Error cargando torneos:", error);
      alertas("Error al cargar torneos", "error");
    });
};

// 2. Función cargarGrupos (actualizada)
const cargarGrupos = (genero = null, torneo = null, selectedId = "") => {
  let url = base_url + "Grupos/listarActivos";
  if (genero && torneo) {
    url += `?genero=${genero}&torneo_id=${torneo}`;
  }

  return fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      const select = document.getElementById("grupo_id");
      select.innerHTML = '<option value="" disabled selected>Seleccione un grupo</option>';
      
      data.forEach(grupo => {
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
    .catch(error => {
      console.error("Error cargando grupos:", error);
      alertas("Error al cargar grupos", "error");
      // Crear opción vacía como fallback
      const select = document.getElementById("grupo_id");
      select.innerHTML = '<option value="" disabled selected>No se pudieron cargar grupos</option>';
    });
};
// 3. Función cargarEquipos (actualizada)
const cargarEquipos = (genero = null, torneo = null, selectedId = "", selectIds = "equipo_id", inscritos =true) => {
  if (genero && torneo) {
    if (inscritos) {
      url = base_url + "Equipos/ListarInscritos" + `?genero=${genero}&torneo_id=${torneo}`;
    } else {
      url = base_url + "Equipos/ListarNoInscritos" + `?genero=${genero}&torneo_id=${torneo}`;
    }
  } else if (genero) {
    url += `?genero=${genero}`;
  }

  return fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      // Soporte para múltiples IDs como array o uno solo como string
      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];

      ids.forEach(id => {
        const select = document.getElementById(id);
        if (!select) return;

        select.innerHTML = '<option value="" disabled selected>Seleccione un equipo</option>';

        data.forEach(equipo => {
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
      });
    })
    .catch(error => {
      console.error("Error cargando equipos:", error);
      alertas("Error al cargar equipos", "error");

      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];
      ids.forEach(id => {
        const select = document.getElementById(id);
        if (select) {
          select.innerHTML = '<option value="" disabled selected>No se pudieron cargar equipos</option>';
        }
      });
    });
};


const cargarDelegados = (selectedId = "") => {
  const selectDelegado = document.getElementById("delegado");
  // Limpiar el select manteniendo la opción inicial
  selectDelegado.innerHTML =
    '<option value="" disabled selected>Seleccione un Delegado</option>';

  // Realizar petición para cargar los delegados
  fetch(base_url + "Jugadores/listarDelegados")
    .then((response) => response.json())
    .then((data) => {
      if (Array.isArray(data)) {
        data.forEach((delegado) => {
          const option = document.createElement("option");
          option.value = delegado.cedula;
          option.textContent = `${delegado.nombre} ${delegado.apellido}`;
          if (delegado.cedula == selectedId) {
            option.selected = true;
          }
          selectDelegado.appendChild(option);
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

const cargarGeneros = (selected = "") => {
  const selectGenero = document.getElementById("genero");
  selectGenero.innerHTML = `
    <option value="" disabled ${selected === "" ? "selected" : ""}>Seleccione un género</option>
    <option value="M" ${selected === "M" ? "selected" : ""}>Masculino</option>
    <option value="F" ${selected === "F" ? "selected" : ""}>Femenino</option>
  `;
};
const cargarUbicaciones = (selectedId = "") => {
  $.ajax({
    url: base_url + "Ubicacion/listarActivos",
    type: "GET",
    dataType: "json",
    success: function(data) {
      const $select = $("#ubicacion_id");
      $select.empty().append('<option value="" disabled selected>Seleccionar ubicación</option>');

      data.forEach(ubicacion => {
        const selected = (selectedId !== "" && ubicacion.id == selectedId) ? "selected" : "";
        $select.append(`<option value="${ubicacion.id}" ${selected}>${ubicacion.nombre}</option>`);
      });

      if (selectedId === "") {
        $select.val("");
      }
    },
    error: function(xhr, status, error) {
      console.error("Error cargando ubicaciones:", error);
      alertas("Error al cargar ubicaciones", "error");
      $("#ubicacion_id").html('<option value="" disabled selected>No se pudieron cargar ubicaciones</option>');
    }
  });
};

const cargarJugadores = (genero = null, equipo = null, torneo = null, selectedId = "", selectIds = "jugador", inscritos = true) => {
  if (genero && equipo) {
    if (inscritos) {
      url = base_url + "Jugadores/ListarJugEquipo" + `?genero=${genero}&equipo_id=${equipo}`;
    } else {
      url = base_url + "Jugadores/ListarNoInscritos" + `?genero=${genero}&equipo_id=${equipo}&torneo_id=${torneo}`;
    }
  } else if (genero) {
    url += `?genero=${genero}`;
  }

  return fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];

      ids.forEach(id => {
        const select = document.getElementById(id);
        if (!select) return;

        select.innerHTML = '<option value="" disabled selected>Seleccione un Jugador</option>';

        data.forEach(jugador => {
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
    .catch(error => {
      console.error("Error cargando jugadores:", error);
      alertas("Error al cargar jugadores", "error");

      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];
      ids.forEach(id => {
        const select = document.getElementById(id);
        if (select) {
          select.innerHTML = '<option value="" disabled selected>No se pudieron cargar jugadores</option>';
        }
      });
    });
};


function actualizarFiltros() {
  const torneo = document.getElementById("torneo_id").value;
  const genero = document.getElementById("genero").value;
  
  if (torneo && genero) {
    cargarGrupos(genero, torneo);
    cargarEquipos(genero, torneo, "", "equipo_id", false);
    // cargarJugadores(genero);
  }
}
function actualizarFiltrosJug() {
  const torneo = document.getElementById("torneo_id").value;
  const genero = document.getElementById("genero").value;
  const equipo = document.getElementById("equipo_id").value;
  if (torneo && genero) {
    // Cargar equipos y cuando termine, mantener seleccionado y luego cargar jugadores
    cargarEquipos(genero, torneo, equipo).then(() => {
      // Después de cargar equipos y mantener seleccionado, cargamos los jugadores
      if (equipo) {
        cargarJugadores(genero, equipo, torneo, "", "jugador", false);
      }
    });
  }
}

const cargarEquiposJuegos = (genero = null, torneo = null, grupo = null, selectIds = ["equipo_id", "vs_equipo_id"], selectedIds = []) => {
  
  let url = "";

  if (genero && torneo && grupo) {
    url = base_url + "Equipos/ListarInscritos" + `?genero=${genero}&torneo_id=${torneo}&grupo_id=${grupo}`;
  }else{
    console.error();
  }

  return fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];
      const selected = Array.isArray(selectedIds) ? selectedIds : [];

      ids.forEach((id, index) => {
        const select = document.getElementById(id);
        if (!select) return;

        const selectedValue = selected[index] || "";

        select.innerHTML = '<option value="" disabled selected>Seleccione un equipo</option>';

        data.forEach(equipo => {
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
    .catch(error => {
      console.error("Error cargando equipos del juego:", error);
      alertas("Error al cargar equipos", "error");

      const ids = Array.isArray(selectIds) ? selectIds : [selectIds];
      ids.forEach(id => {
        const select = document.getElementById(id);
        if (select) {
          select.innerHTML = '<option value="" disabled selected>No se pudieron cargar equipos</option>';
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
    cargarGrupos(genero, torneo).then(() => {
      // Reasignar el valor seleccionado después de que se haya cargado el nuevo select
      grupoSelect.value = grupoSeleccionado;

      if (grupoSeleccionado) {
        cargarEquiposJuegos(genero, torneo, grupoSeleccionado, ["equipo_id", "vs_equipo_id"]);
      }
    });
  }
}



