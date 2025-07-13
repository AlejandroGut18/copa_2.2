// Función para abrir el modal y preparar todo
const abrirModalAsignarGrupos = () => {
    document.getElementById("frmAsignarGrupos").reset();
    document.getElementById("listaEquiposCheckboxes").innerHTML = "";
    cargarTorneosActivos();
    $("#modalAsignarGrupos").modal("show");
};
  
  // Cargar torneos activos en el select
  const cargarTorneosActivos = () => {
    const url = base_url + "Torneos/getActivos";
    fetch(url)
      .then(res => res.json())
      .then(data => {
        const select = document.getElementById("torneo_grupo");
        select.innerHTML = '<option value="" disabled selected>Seleccione un torneo</option>';
        data.forEach(t => {
          select.innerHTML += `<option value="${t.id}">${t.nombre}</option>`;
        });
      });
  };
  
  // Escuchar cambios de torneo, género o cantidad
  ["torneo_grupo", "generoM", "generoF", "cantidad24", "cantidad28"].forEach(id => {
    document.getElementById(id).addEventListener("change", cargarEquiposCheckbox);
  });
  
  // Cargar equipos con checks seleccionados hasta el límite
  const cargarEquiposCheckbox = () => {
    const torneo_id = document.getElementById("torneo_grupo").value;
    const genero = document.querySelector('input[name="genero"]:checked')?.value;
    const cantidad = document.querySelector('input[name="cantidad_equipos"]:checked')?.value;
  
    if (!torneo_id || !genero || !cantidad) return;
  
    const url = `${base_url}Inscripciones/getEquiposPorTorneoGenero/${torneo_id}/${genero}`;
    fetch(url)
      .then(res => res.json())
      .then(data => {
        const contenedor = document.getElementById("listaEquiposCheckboxes");
        contenedor.innerHTML = "";
        const limite = parseInt(cantidad);
  
        data.slice(0, limite).forEach((equipo, i) => {
          contenedor.innerHTML += `
          <div class="col-md-6 mb-2">
            <div class="form-check">
              <input class="form-check-input equipo-check" type="checkbox" name="equipos[]" value="${equipo.id}" id="equipo${i}" checked>
              <label class="form-check-label" for="equipo${i}">${equipo.nombre}</label>
            </div>
          </div>`;
        });
      });
  };
  
//   Procesar asignación a grupos aleatoriamente\
const asignarEquiposAGrupos = () => {
    const form = document.getElementById("frmAsignarGrupos");
    const formData = new FormData(form);
  
    const equiposSeleccionados = Array.from(document.querySelectorAll('.equipo-check:checked'))
      .map(cb => cb.value);
  
    if (equiposSeleccionados.length !== parseInt(formData.get("cantidad_equipos"))) {
      alertas("Debe seleccionar exactamente " + formData.get("cantidad_equipos") + " equipos", "warning");
      return;
    }
  
    formData.delete("equipos[]");
    equiposSeleccionados.forEach(id => formData.append("equipos[]", id));
  
    fetch(base_url + "Grupos/asignarEquiposAleatorio", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(res => {
        if (res.icono === "success") {
          $("#modalAsignarGrupos").modal("hide");
        }
        alertas(res.msg, res.icono);
      });
  };
  