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
