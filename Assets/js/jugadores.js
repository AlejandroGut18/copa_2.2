const frmJugadores = () => {
  document.getElementById("title").textContent = "Nuevo Jugador";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmJugadores").reset();
  cargarGeneros();
  $("#nuevoJugador").modal("show");
};

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
