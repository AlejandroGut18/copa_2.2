
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