// activar uso estricto de javascript
"use strict";

$(function () {
  bsCustomFileInput.init();
  tablademisquejas();
  tablaquejas();
  tabladashboardadmin();
  tabladashboarduser();
  contadorComentarios();
  obtenerComentarios();
  obtenerArchivos();
  tablausuarios();
});

setInterval(function () {
  obtenerComentarios();
  contadorComentarios();
}, 5000);

function tablademisquejas() {
  const acciones = (data, type, row) => {
    if (row.Estado == "Pendiente") {
      return `
    <a href="${BASE_URL}quejas/ver&idqueja=${row.Id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
    <a href="${BASE_URL}quejas/editar&idqueja=${row.Id}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
    <button class="btn btn-danger btn-sm" onclick="eliminarQueja(${row.Id})"><i class="fas fa-trash"></i></button>
    `;
    } else {
      return `
    <a href="${BASE_URL}quejas/ver&idqueja=${row.Id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
    `;
    }
  };

  $("#tablademisquejas").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: false,
    info: true,
    autoWidth: false,
    responsive: true,
    ajax: {
      url: BASE_URL + "api/getmisquejas",
      dataSrc: "",
    },
    columns: [
      { data: "Id" },
      { data: "Fecha" },
      { data: "Quien Registra" },
      { data: "Asunto" },
      { data: "Departamento" },
      { data: "Tipo" },
      { data: "Estado" },
      {
        data: null,
        render: acciones,
      },
    ],
    language: {
      lengthMenu: "Mostrar _MENU_ registros por página",
      zeroRecords: "No se encontraron registros",
      info: "Mostrando página _PAGE_ de _PAGES_",
      infoEmpty: "No hay registros disponibles",
      infoFiltered: "(filtrado de _MAX_ registros totales)",
      search: "Buscar:",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
}

function tabladashboardadmin() {
  $("#tabladashboardadmin").DataTable({
    paging: false,
    lengthChange: false,
    searching: false,
    ordering: false,
    info: false,
    autoWidth: false,
    responsive: true,
  });
}

function tabladashboarduser() {
  $("#tabladashboarduser").DataTable({
    paging: false,
    lengthChange: false,
    searching: false,
    ordering: false,
    info: false,
    autoWidth: false,
    responsive: true,
  });
}

function tablaquejas() {
  // const acciones = (data, type, row) => {
  //   if (row.Estado == "Pendiente") {
  //     return `
  //   <a href="${BASE_URL}quejas/ver&idqueja=${row.Id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
  //   <button class="btn btn-success btn-sm" onclick="atenderQueja(${row.Id})"><i class="fas fa-check"></i></button>
  //   <button class="btn btn-danger btn-sm" onclick="rechazarQueja(${row.Id})"><i class="fas fa-times"></i></button>
  //   `;
  //   } else {
  //     return `
  //   <a href="${BASE_URL}quejas/ver&idqueja=${row.Id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
  //   `;
  //   }
  // };

  // const spanestado = (data, type, row) => {
  //   if (row.Estado == "Pendiente") {
  //     return `<span class="badge badge-warning">${row.Estado}</span>`;
  //   } else if (row.Estado == "Atendido") {
  //     return `<span class="badge badge-success">${row.Estado}</span>`;
  //   } else {
  //     return `<span class="badge badge-danger">${row.Estado}</span>`;
  //   }
  // };

  // $("#tablaquejas").DataTable({
  //   paging: true,
  //   lengthChange: true,
  //   searching: true,
  //   ordering: false,
  //   info: true,
  //   autoWidth: false,
  //   responsive: true,
  //   ajax: {
  //     url: BASE_URL + "api/getquejas",
  //     dataSrc: "",
  //   },
  //   columns: [
  //     { data: "Id" },
  //     { data: "Fecha" },
  //     { data: "Quien Registra" },
  //     { data: "Asunto" },
  //     { data: "Departamento" },
  //     { data: "Tipo" },
  //     { data: "Estado", render: spanestado },
  //     {
  //       data: null,
  //       render: acciones,
  //     },
  //   ],
  //   language: {
  //     lengthMenu: "Mostrar _MENU_ registros por página",
  //     zeroRecords: "No se encontraron registros",
  //     info: "Mostrando página _PAGE_ de _PAGES_",
  //     infoEmpty: "No hay registros disponibles",
  //     infoFiltered: "(filtrado de _MAX_ registros totales)",
  //     search: "Buscar:",
  //     paginate: {
  //       first: "Primero",
  //       last: "Último",
  //       next: "Siguiente",
  //       previous: "Anterior",
  //     },
  //   },
  // });

  $("#tablaquejas")
    .DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      ordering: false,
      lengthChange: true,
      buttons: ["csv", "pdf", "print"],
      language: {
        lengthMenu: "Mostrar _MENU_ registros por página",
        zeroRecords: "No se encontraron registros",
        info: "Mostrando página _PAGE_ de _PAGES_",
        infoEmpty: "No hay registros disponibles",
        infoFiltered: "(filtrado de _MAX_ registros totales)",
        search: "Buscar:",
        paginate: {
          first: "Primero",
          last: "Último",
          next: "Siguiente",
          previous: "Anterior",
        },
      },
    })
    .buttons()
    .container()
    .appendTo("#tablaquejas_wrapper .col-md-6:eq(0)");
}

function tablausuarios() {
  const acciones = (data, type, row) => {
    if (row.estado == 1) {
      return `
    <a href="${BASE_URL}usuarios/editar&idusuario=${row.idusuario}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a>
    <button class="btn btn-danger btn-sm" onclick="desactivarUsuario(${row.idusuario})"><i class="fas fa-times"></i></button>
    `;
    } else {
      return `
    <button class="btn btn-success btn-sm" onclick="activarUsuario(${row.idusuario})"><i class="fas fa-check"></i></button>
    `;
    }
  };

  const spanestado = (data, type, row) => {
    if (row.estado == 1) {
      return `<span class="badge badge-success">Activo</span>`;
    } else {
      return `<span class="badge badge-danger">Inactivo</span>`;
    }
  };

  $("#tablausuarios").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: false,
    info: true,
    autoWidth: false,
    responsive: true,
    ajax: {
      url: BASE_URL + "api/getusuarios",
      dataSrc: "",
    },
    columns: [
      { data: "usuario" },
      { data: "nombre" },
      { data: "apellido" },
      { data: "departamento" },
      { data: "rol" },
      { data: "estado", render: spanestado },
      {
        data: null,
        render: acciones,
      },
    ],
    language: {
      lengthMenu: "Mostrar _MENU_ registros por página",
      zeroRecords: "No se encontraron registros",
      info: "Mostrando página _PAGE_ de _PAGES_",
      infoEmpty: "No hay registros disponibles",
      infoFiltered: "(filtrado de _MAX_ registros totales)",
      search: "Buscar:",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
  });
}

function eliminarQueja(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    // confirm Button color en color verde
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, bórralo!",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: BASE_URL + "api/eliminarQueja",
        type: "POST",
        data: { idqueja: id },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == "ok") {
            Swal.fire("¡Eliminado!", "La queja ha sido eliminada.", "success");
            $("#tablademisquejas").DataTable().ajax.reload();
          } else {
            Swal.fire("¡Error!", "La queja no ha sido eliminada.", "error");
          }
        },
      });
    }
  });
}

function obtenerComentarios() {
  if (document.getElementById("idqueja") == null) {
    return;
  }

  const idqueja = document.getElementById("idqueja").value;
  $.ajax({
    url: BASE_URL + "api/getcomentarios",
    type: "POST",
    data: { idqueja: idqueja },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        var comentarios = data.data;
        var html = "";
        comentarios.forEach((comentario) => {
          html += `
              <div class="card-comment">
                  <div class="comment-text">
                      <span class="username">
                      ${comentario.nombreusuario}
                      <span class="text-muted float-right">${comentario.Fecha}</span>
                      </span>
                      ${comentario.comentario}
                  </div>
              </div>
            `;
        });
        document.getElementById("comentarios").innerHTML = html;
      } else {
        document.getElementById("comentarios").innerHTML = "No hay comentarios";
      }
    },
  });
}

function contadorComentarios() {
  if (document.getElementById("idqueja") == null) {
    return;
  }

  const idqueja = document.getElementById("idqueja").value;
  $.ajax({
    url: BASE_URL + "api/contadorComentarios",
    type: "POST",
    data: { idqueja: idqueja },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        var comentarios = data.data;
        document.getElementById("contadorComentarios").innerHTML =
          comentarios.total + " comentarios";
      } else {
        document.getElementById("contadorComentarios").innerHTML =
          0 + " comentarios";
      }
    },
  });
}

function comentar(event) {
  event.preventDefault();
  const idqueja = document.getElementById("idqueja").value;
  const comentario = document.getElementById("comentario").value;
  console.log("comentar " + idqueja);
  $.ajax({
    url: BASE_URL + "api/comentar",
    type: "POST",
    data: { idqueja: idqueja, comentario: comentario },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        Swal.fire("¡Comentario!", data.message, "success");
        obtenerComentarios();
        contadorComentarios();
        document.getElementById("comentario").value = "";
      } else {
        Swal.fire("¡Error!", data.message, "error");
      }
    },
  });
  return false;
}

function obtenerArchivos() {
  if (document.getElementById("idqueja") == null) {
    return;
  }
  const idqueja = document.getElementById("idqueja").value;
  $.ajax({
    url: BASE_URL + "api/getarchivos",
    type: "POST",
    data: { idqueja: idqueja },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        var archivos = data.data;
        var html = "";
        archivos.forEach((archivo) => {
          html += `
            <div class="file-info">
              <span class="file-icon">
                <i class="fas fa-paperclip"></i>
              </span>
              <span class="file-name"><a href="${BASE_URL}${archivo.ruta}">${archivo.nombrearchivo}</a></span>              
              </span>
            </div>
            `;
        });
        document.getElementById("archivos").innerHTML = html;
      } else {
        document.getElementById("archivos").innerHTML = "No hay archivos";
      }
    },
  });
}

function subirArchivo(event) {
  event.preventDefault();
  const idqueja = document.getElementById("idqueja").value;
  const formData = new FormData();
  formData.append("idqueja", idqueja);
  formData.append("archivo", $("#archivo")[0].files[0]);
  $.ajax({
    url: BASE_URL + "api/subirArchivo",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        Swal.fire("¡Archivo!", data.message, "success");
        obtenerArchivos();
        $("#formArchivo")[0].reset();
      } else {
        Swal.fire("¡Error!", data.message, "error");
      }
    },
    error: function (error) {
      console.log(error);
    },
  });
  return false;
}

function atenderQueja(idqueja) {
  Swal.fire({
    title: "¿Estás seguro de atender la queja?",
    text: "¡Una vez atendida no se podrá revertir!",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, atender!",
  }).then((result) => {
    if (result.value) {
      var estado = 2;
      $.ajax({
        url: BASE_URL + "api/atenderQueja",
        type: "POST",
        data: {
          idqueja: idqueja,
          estado: estado,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == "ok") {
            Swal.fire("¡Atendido!", data.message, "success");
            $("#tablaquejas").DataTable().ajax.reload();
          } else {
            Swal.fire("¡Error!", data.message, "error");
          }
        },
      });
    }
  });
}

function rechazarQueja(idqueja) {
  Swal.fire({
    title: "¿Estás seguro de rechazar la queja?",
    text: "¡Una vez rechazada no se podrá revertir!",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, rechazar!",
  }).then((result) => {
    if (result.value) {
      var estado = 3;
      $.ajax({
        url: BASE_URL + "api/rechazarQueja",
        type: "POST",
        data: {
          idqueja: idqueja,
          estado: estado,
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == "ok") {
            Swal.fire("¡Rechazada!", data.message, "success");
            $("#tablaquejas").DataTable().ajax.reload();
          } else {
            Swal.fire("¡Error!", data.message, "error");
          }
        },
      });
    }
  });
}
