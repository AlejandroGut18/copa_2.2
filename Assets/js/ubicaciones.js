
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
const btnReingresarUbicacion = (id) => {
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
      const url = base_url + "Ubicacion/reingresar/" + id;
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
