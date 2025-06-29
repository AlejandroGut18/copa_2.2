// function btnAgregarResultados(id) {
//   fetch(base_url + "Juegos/editar/" + id)
//     .then(res => res.json())
//     .then(data => {
//       // Llena el formulario
//       document.getElementById("id").value = data.id;
//       document.getElementById("torneo_id").value = data.torneo_id;
//       document.getElementById("genero").value = data.genero;
//       document.getElementById("grupo_id").value = data.grupo_id;
//       document.getElementById("equipo_id").value = data.equipo_id;
//       document.getElementById("vs_equipo_id").value = data.vs_equipo_id;
//       document.getElementById("fecha").value = data.fecha;
//       document.getElementById("hora").value = data.hora;
//       document.getElementById("status_id").value = data.status_id;

//       // Si tienes campos de puntos, muéstralos y actívalos para edición
//       document.getElementById("puntos_equipo")?.removeAttribute("disabled");
//       document.getElementById("puntos_vs_equipo")?.removeAttribute("disabled");

//       // Cambia el título del modal si quieres
//       document.getElementById("title").textContent = "Agregar Resultados";

//       // Mostrar el modal
//       $("#nuevoJuego").modal("show");

//       // (Opcional) Si tienes pestañas dentro del modal, activa la pestaña de resultados
//       $('#nav-tab a[href="#tabPuntos"]').tab("show");
//     });
// }
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
              backgroundColor: function (context) {
                const chart = context.chart;
                const { ctx, chartArea } = chart;
                if (!chartArea) {
                  // This case happens on initial chart render
                  return null;
                }
                // Crear un degradado vertical de azul a verde
                const gradient = ctx.createLinearGradient(
                  0,
                  chartArea.top,
                  0,
                  chartArea.bottom
                );
                gradient.addColorStop(0, "rgb(8, 8, 59)");
                gradient.addColorStop(1, "rgb(0, 200, 83)");
                return gradient;
              },
            },
          ],
        },
      });
    }
  };
}

function alertas(msg, icono) {
  Swal.fire({
    position: "center",
    icon: icono,
    title: msg,
    showConfirmButton: false,
    timer: 3000,
  });
}

document.getElementById("btnSalir").addEventListener("click", function (e) {
  e.preventDefault(); // Evita que se vaya directamente

  Swal.fire({
    title: "¿Estás seguro de salir?",
    text: "Tu sesión se cerrará.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, salir",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = base_url + "Usuarios/salir";
    }
  });
});
