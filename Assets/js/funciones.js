function frmGrupos() {
  document.getElementById("title").textContent = "Nueva Grupo";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmGrupos").reset();
  document.getElementById("id").value = "";

  const selectTorneo = document.getElementById('torneo');
  // Limpiar el select manteniendo la opción inicial
  selectTorneo.innerHTML = '<option value="" disabled selected>Seleccione un Torneo</option>';
  // Realizar petición para cargar los torneos
  fetch(base_url + 'Torneos/listarActivos')
    .then(response => response.json())
    .then(data => {
      if (Array.isArray(data)) {
        // Llenar el select con los torneos
        data.forEach(torneo => {
          const option = document.createElement('option');
          option.value = torneo.id;
          option.textContent = torneo.nombre;
          selectTorneo.appendChild(option);
        });
      } else {
        console.error('La respuesta de torneos no es un array:', data);
        alertas('No se pudieron cargar los torneos', 'error');
      }
    })
    .catch(error => {
      console.error('Error al obtener los torneos:', error);
      alertas('Error al cargar los torneos', 'error');
    });
  $("#nuevoGrupo").modal("show");
}

function registrarGrupo(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const torneo = document.getElementById("torneo");
  const genero = document.getElementById("genero");
  
  if (nombre.value.trim() === "" || torneo.value === "" || genero.value === "") {
    alertas("Todos los campos son requeridos", "warning");
  }else {
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
}
// function btnEditarUbic(id) {
//   document.getElementById("title").textContent = "Actualizar Ubicacion";
//   document.getElementById("btnAccion").textContent = "Modificar";
//   const url = base_url + "Ubicacion/editar/" + id;
//   const http = new XMLHttpRequest();
//   http.open("GET", url, true);
//   http.send();
//   http.onreadystatechange = function () {
//     if (this.readyState == 4 && this.status == 200) {
//       const res = JSON.parse(this.responseText);
//       document.getElementById("id").value = res.id;
//       document.getElementById("nombre").value = res.nombre;
//       document.getElementById("direccion").value = res.direccion;
//       $("#nuevaUbicacion").modal("show");
//     }
//   };
// }

// function btnEliminarUbic(id) {
//   Swal.fire({
//     title: "Esta seguro de eliminar?",
//     text: "La ubicacion se eliminará de forma permanente!",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "Si!",
//     cancelButtonText: "No",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       const url = base_url + "Ubicacion/eliminar/" + id;
//       const http = new XMLHttpRequest();
//       http.open("GET", url, true);
//       http.send();
//       http.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//           const res = JSON.parse(this.responseText);
//           tblUbicacion.ajax.reload();
//           alertas(res.msg, res.icono);
//         }
//       };
//     }
//   });
// }
function frmUbicacion() {
  document.getElementById("title").textContent = "Nueva Ubicación";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmUbicacion").reset();
  document.getElementById("id").value = "";
  $("#nuevaUbicacion").modal("show");
}

function registrarUbic(e) {
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
}
function btnEditarUbic(id) {
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
}

function btnEliminarUbic(id) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "La ubicacion se eliminará de forma permanente!",
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
}

function frmUsuario() {
  document.getElementById("title").textContent = "Nuevo Usuario";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("claves").classList.remove("d-none");
  document.getElementById("frmUsuario").reset();
  document.getElementById("id").value = "";
  $("#nuevo_usuario").modal("show");
}
function registrarUser(e) {
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
}
function btnEditarUser(id) {
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
}
function btnEliminarUser(id) {
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
}
function btnReingresarUser(id) {
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
}
//Fin Usuarios
function frmTorneo() {
  document.getElementById("title").textContent = "Nuevo Torneo";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmTorneo").reset();
  document.getElementById("id").value = "";
  // Cargar ubicaciones dinámicamente
  // const selectUbicacion = document.getElementById("ubicacion_id");
  // selectUbicacion.innerHTML =
  //   '<option value="">Cargando ubicaciones...</option>';

  // const url = base_url + "Ubicacion/listarActivos";
  // const http = new XMLHttpRequest();
  // http.open("GET", url, true);
  // http.send();
  // http.onreadystatechange = function () {
  //   if (this.readyState == 4 && this.status == 200) {
  //     try {
  //       const res = JSON.parse(this.responseText);
  //       selectUbicacion.innerHTML =
  //         '<option value="">Seleccionar ubicación</option>';
  //       res.forEach(function (ubicacion) {
  //         const option = document.createElement("option");
  //         option.value = ubicacion.id;
  //         option.textContent = ubicacion.nombre;
  //         selectUbicacion.appendChild(option);
  //       });
  //     } catch (e) {
  //       console.error("Error cargando ubicaciones:", e);
  //       selectUbicacion.innerHTML =
  //         '<option value="">Error cargando ubicaciones</option>';
  //     }
  //   }
  // };
  $("#nuevoTorneo").modal("show");
}

function registrarTorneo(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  const fecha_inicio = document.getElementById("fecha_inicio");
  const ubicacion_id = document.getElementById("ubicacion_id");
  const status_id = document.getElementById("status_id");

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
}

function btnEditarTorneo(id) {
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
      $("#nuevoTorneo").modal("show");
    }
  };
};

function btnEliminarTorneo(id) {
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
}

function btnReingresarTorneo(id) {
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
}
//Fin Estudiante
function frmMateria() {
  document.getElementById("title").textContent = "Nueva Materia";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmMateria").reset();
  document.getElementById("id").value = "";
  $("#nuevoMateria").modal("show");
}

function registrarMateria(e) {
  e.preventDefault();
  const materia = document.getElementById("materia");
  if (materia.value == "") {
    alertas("La materia es requerido", "warning");
  } else {
    const url = base_url + "Materia/registrar";
    const frm = document.getElementById("frmMateria");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevoMateria").modal("hide");
        frm.reset();
        tblMateria.ajax.reload();
        alertas(res.msg, res.icono);
      }
    };
  }
}

function btnEditarMat(id) {
  document.getElementById("title").textContent = "Actualizar caja";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Materia/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("materia").value = res.materia;
      $("#nuevoMateria").modal("show");
    }
  };
}

function btnEliminarMat(id) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "La materia no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Materia/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblMateria.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}

function btnReingresarMat(id) {
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
      const url = base_url + "Materia/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblMateria.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
//Fin Materia
function frmAutor() {
  document.getElementById("title").textContent = "Nuevo Autor";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmAutor").reset();
  document.getElementById("id").value = "";
  deleteImg();
  $("#nuevoAutor").modal("show");
}

function registrarAutor(e) {
  e.preventDefault();
  const autor = document.getElementById("autor");
  if (autor.value == "") {
    alertas("El nombre es requerido", "warning");
  } else {
    const url = base_url + "Autor/registrar";
    const frm = document.getElementById("frmAutor");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevoAutor").modal("hide");
        frm.reset();
        tblAutor.ajax.reload();
        alertas(res.msg, res.icono);
      }
    };
  }
}

function btnEditarAutor(id) {
  document.getElementById("title").textContent = "Actualizar Autor";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Autor/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("autor").value = res.autor;
      document.getElementById("foto_actual").value = res.imagen;
      document.getElementById("img-preview").src =
        base_url + "Assets/img/autor/" + res.imagen;
      document.getElementById("icon-image").classList.add("d-none");
      document.getElementById("icon-cerrar").innerHTML = `
            <button class="btn btn-danger" onclick="deleteImg()">
            <i class="fa fa-times-circle"></i></button>`;
      $("#nuevoAutor").modal("show");
    }
  };
}

function btnEliminarAutor(id) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El Autor no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Autor/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblAutor.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}

function btnReingresarAutor(id) {
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
      const url = base_url + "Autor/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblAutor.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
//Fin Autor
function frmEditorial() {
  document.getElementById("title").textContent = "Nuevo Editorial";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmEditorial").reset();
  document.getElementById("id").value = "";
  $("#nuevoEditorial").modal("show");
}

function registrarEditorial(e) {
  e.preventDefault();
  const editorial = document.getElementById("editorial");
  if (editorial.value == "") {
    alertas("El editorial es requerido", "warning");
  } else {
    const url = base_url + "Editorial/registrar";
    const frm = document.getElementById("frmEditorial");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevoEditorial").modal("hide");
        tblEditorial.ajax.reload();
        alertas(res.msg, res.icono);
      }
    };
  }
}

function btnEditarEdi(id) {
  document.getElementById("title").textContent = "Actualizar Editorial";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Editorial/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("editorial").value = res.editorial;
      $("#nuevoEditorial").modal("show");
    }
  };
}

function btnEliminarEdi(id) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El Editorial no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Editorial/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblEditorial.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}

function btnReingresarEdi(id) {
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
      const url = base_url + "Editorial/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblEditorial.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
//Fin editorial
function frmLibros() {
  document.getElementById("title").textContent = "Nuevo Libro";
  document.getElementById("btnAccion").textContent = "Registrar";
  document.getElementById("frmLibro").reset();
  document.getElementById("id").value = "";
  $("#nuevoLibro").modal("show");
  deleteImg();
}

function registrarLibro(e) {
  e.preventDefault();
  const titulo = document.getElementById("titulo");
  const autor = document.getElementById("autor");
  const editorial = document.getElementById("editorial");
  const materia = document.getElementById("materia");
  const cantidad = document.getElementById("cantidad");
  const num_pagina = document.getElementById("num_pagina");

  if (
    titulo.value == "" ||
    autor.value == "" ||
    editorial.value == "" ||
    materia.value == "" ||
    cantidad.value == "" ||
    num_pagina.value == ""
  ) {
    alertas("Todo los campos son requeridos", "warning");
  } else {
    const url = base_url + "Libros/registrar";
    const frm = document.getElementById("frmLibro");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#nuevoLibro").modal("hide");
        tblLibros.ajax.reload();
        frm.reset();
        alertas(res.msg, res.icono);
      }
    };
  }
}

function btnEditarLibro(id) {
  document.getElementById("title").textContent = "Actualizar Libro";
  document.getElementById("btnAccion").textContent = "Modificar";
  const url = base_url + "Libros/editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("id").value = res.id;
      document.getElementById("titulo").value = res.titulo;
      document.getElementById("autor").value = res.id_autor;
      document.getElementById("editorial").value = res.id_editorial;
      document.getElementById("materia").value = res.id_materia;
      document.getElementById("cantidad").value = res.cantidad;
      document.getElementById("num_pagina").value = res.num_pagina;
      document.getElementById("anio_edicion").value = res.anio_edicion;
      document.getElementById("descripcion").value = res.descripcion;
      document.getElementById("img-preview").src =
        base_url + "Assets/img/libros/" + res.imagen;
      document.getElementById("icon-cerrar").innerHTML = `
            <button class="btn btn-danger" onclick="deleteImg()">
            <i class="fa fa-times-circle"></i></button>`;
      document.getElementById("icon-image").classList.add("d-none");
      document.getElementById("foto_actual").value = res.imagen;
      $("#nuevoLibro").modal("show");
    }
  };
}

function btnEliminarLibro(id) {
  Swal.fire({
    title: "Esta seguro de eliminar?",
    text: "El libro no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Libros/eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblLibros.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}

function btnReingresarLibro(id) {
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
      const url = base_url + "Libros/reingresar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblLibros.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
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
function frmPrestar() {
  document.getElementById("frmPrestar").reset();
  $("#prestar").modal("show");
}
function btnEntregar(id) {
  Swal.fire({
    title: "Recibir de libro?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Prestamos/entregar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblPrestar.ajax.reload();
          alertas(res.msg, res.icono);
        }
      };
    }
  });
}
function registroPrestamos(e) {
  e.preventDefault();
  const libro = document.getElementById("libro").value;
  const estudiante = document.getElementById("estudiante").value;
  const cantidad = document.getElementById("cantidad").value;
  const fecha_prestamo = document.getElementById("fecha_prestamo").value;
  const fecha_devolucion = document.getElementById("fecha_devolucion").value;
  if (
    libro == "" ||
    estudiante == "" ||
    cantidad == "" ||
    fecha_prestamo == "" ||
    fecha_devolucion == ""
  ) {
    alertas("Todo los campos son requeridos", "warning");
  } else {
    const frm = document.getElementById("frmPrestar");
    const url = base_url + "Prestamos/registrar";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        tblPrestar.ajax.reload();
        $("#prestar").modal("hide");
        alertas(res.msg, res.icono);
        if (res.icono == "success") {
          setTimeout(() => {
            window.open(base_url + "Prestamos/ticked/" + res.id, "_blank");
          }, 3000);
        }
      }
    };
  }
}
function btnRolesUser(id) {
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
}
function registrarPermisos(e) {
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
}
function modificarClave(e) {
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
}
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
              backgroundColor: ["#dc143c"],
            },
          ],
        },
      });
    }
  };
}
function alertas(msg, icono) {
  Swal.fire({
    position: "top-end",
    icon: icono,
    title: msg,
    showConfirmButton: false,
    timer: 3000,
  });
}
function verificarLibro(e) {
  const libro = document.getElementById("libro").value;
  const cant = document.getElementById("cantidad").value;
  const http = new XMLHttpRequest();
  const url = base_url + "Libros/verificar/" + libro;
  http.open("GET", url);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.icono == "success") {
        document.getElementById(
          "msg_error"
        ).innerHTML = `<span class="badge badge-primary">Disponible: ${res.cantidad}</span>`;
      } else {
        alertas(res.msg, res.icono);
        return false;
      }
    }
  };
}
