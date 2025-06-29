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
