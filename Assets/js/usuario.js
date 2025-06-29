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