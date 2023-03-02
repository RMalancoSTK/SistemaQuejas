// activar uso estricto de javascript
"use strict";

$(function () {
  bsCustomFileInput.init();
  tablademisquejas();
  tablaquejas();
  tabladashboardadmin();
  tabladashboarduser();
});

function tablademisquejas() {
  const acciones = (data, type, row) => {
    // los usuarios solo pueden editar las quejas que esten pendientes o eliminarlas, pero cuando esten atendidas o rechazadas no pueden hacer nada solo verlas
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
  // los administradores pueden ver todas las quejas y no pueden editarlas
  const acciones = (data, type, row) => {
    // las administradores pueden ver todas las quejas y no pueden editarlas pero solo pueden cambiar el estado si esta pendiente a atendida o rechazada
    if (row.Estado == "Pendiente") {
      return `
    <a href="${BASE_URL}quejas/ver&idqueja=${row.Id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
    <a href="${BASE_URL}quejas/cambiarEstado&idqueja=${row.Id}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
    <a href="${BASE_URL}quejas/cambiarEstado&idqueja=${row.Id}" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a>
    `;
    } else {
      return `
    <a href="${BASE_URL}quejas/ver&idqueja=${row.Id}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
    `;
    }
  };

  $("#tablaquejas").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: false,
    info: true,
    autoWidth: false,
    responsive: true,
    error: function (error) {
      console.log(error);
    },
    ajax: {
      url: BASE_URL + "api/getquejas",
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
