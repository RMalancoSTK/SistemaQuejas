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
      // editar, cambiar contraseña, desactivar
      return `
    <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalUsuario" onclick="editarUsuario(${row.idusuario})"><i class="fas fa-edit"></i></a>
    <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalcambiarpassword" onclick="cambiarPassword(${row.idusuario})"><i class="fas fa-key"></i></a>
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

function cambiarPassword(idusuario) {
  $.ajax({
    url: BASE_URL + "api/getUsuario",
    type: "POST",
    data: { idusuario: idusuario },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        var usuario = data.data;
        document.getElementById("cambiarpasswordidusuario").value =
          usuario.idusuario;
      }
    },
  });
}

function guardarUsuario(event) {
  event.preventDefault();

  var idusuario = document.getElementById("idusuario").value;
  var usuario = document.getElementById("usuario").value;
  var password = document.getElementById("password").value;
  var nombre = document.getElementById("nombre").value;
  var apellido = document.getElementById("apellido").value;
  var email = document.getElementById("email").value;
  var departamento = document.getElementById("departamento").value;
  var rol = document.getElementById("rol").value;

  $.ajax({
    url: BASE_URL + "api/guardarUsuario",
    type: "POST",
    data: {
      idusuario: idusuario,
      usuario: usuario,
      password: password,
      nombre: nombre,
      apellido: apellido,
      email: email,
      departamento: departamento,
      rol: rol,
    },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        Swal.fire("¡Guardado!", data.message, "success");
        $("#tablausuarios").DataTable().ajax.reload();
        $("#formUsuario")[0].reset();
        $("#modalUsuario").modal("hide");
      } else {
        Swal.fire("¡Error!", data.message, "error");
      }
    },
  });
  return false;
}

function editarUsuario(idusuario) {
  $.ajax({
    url: BASE_URL + "api/getUsuario",
    type: "POST",
    data: { idusuario: idusuario },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        var usuario = data.data;
        document.getElementById("idusuario").value = usuario.idusuario;
        document.getElementById("usuario").value = usuario.usuario;
        document.getElementById("usuario").setAttribute("readonly", true);
        document.getElementById("divpassword").style.height = "0";
        document.getElementById("nombre").value = usuario.nombre;
        document.getElementById("apellido").value = usuario.apellido;
        document.getElementById("email").value = usuario.email;
        document.getElementById("departamento").value = usuario.iddepartamento;
        document.getElementById("rol").value = usuario.idrol;
      } else {
        Swal.fire("¡Error!", data.message, "error");
      }
    },
  });
}

function limpiarFormularioUsuario() {
  document.getElementById("idusuario").value = "";
  document.getElementById("usuario").value = "";
  document.getElementById("usuario").removeAttribute("readonly");
  document.getElementById("divpassword").style.height = "";
  document.getElementById("nombre").value = "";
  document.getElementById("apellido").value = "";
  document.getElementById("email").value = "";
  document.getElementById("departamento").value = "";
  document.getElementById("rol").value = "";
}

function guardarPassword(event) {
  event.preventDefault();
  var password = document.getElementById("password").value;
  var idusuario = document.getElementById("cambiarpasswordidusuario").value;
  $.ajax({
    url: BASE_URL + "api/guardarPassword",
    type: "POST",
    data: { idusuario: idusuario, password: password },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == "ok") {
        Swal.fire("¡Guardado!", data.message, "success");
        $("#tablausuarios").DataTable().ajax.reload();
        $("#modalcambiarpassword").modal("hide");
      } else {
        Swal.fire("¡Error!", data.message, "error");
      }
    },
  });
  return false;
}

function desactivarUsuario(idusuario) {
  Swal.fire({
    title: "¿Estás seguro de desactivar el usuario?",
    text: "El usuario no podrá iniciar sesión pero no se eliminará de la base de datos",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, desactivar!",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: BASE_URL + "api/desactivarUsuario",
        type: "POST",
        data: { idusuario: idusuario },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == "ok") {
            Swal.fire("¡Desactivado!", data.message, "success");
            $("#tablausuarios").DataTable().ajax.reload();
          } else {
            Swal.fire("¡Error!", data.message, "error");
          }
        },
      });
    }
  });
}

function activarUsuario(idusuario) {
  Swal.fire({
    title: "¿Estás seguro de activar el usuario?",
    text: "El usuario podrá iniciar sesión",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, activar!",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: BASE_URL + "api/activarUsuario",
        type: "POST",
        data: { idusuario: idusuario },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == "ok") {
            Swal.fire("¡Activado!", data.message, "success");
            $("#tablausuarios").DataTable().ajax.reload();
          } else {
            Swal.fire("¡Error!", data.message, "error");
          }
        },
      });
    }
  });
}
