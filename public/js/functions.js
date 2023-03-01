$(function () {
  bsCustomFileInput.init();

  $("#example1")
    .DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
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
        buttons: {
          copy: "Copiar",
          colvis: "Visibilidad de columnas",
          collection: "Colección",
          colvisRestore: "Restaurar visibilidad",
          copyKeys:
            "Presione <i> ctrl </i> o <i>  u2318 </i> + <i> C </i> para copiar los datos de la tabla en el portapapeles. <br> <br> Para cancelar, haga clic en este mensaje o presione Esc.",
          copySuccess: {
            1: "Copiada 1 fila al portapapeles",
            _: "Copiadas %d filas al portapapeles",
          },
          copyTitle: "Copiar al portapapeles",
          csv: "CSV",
          excel: "Excel",
          pageLength: {
            "-1": "Mostrar todas las filas",
            1: "Mostrar 1 fila",
            _: "Mostrar %d filas",
          },
          pdf: "PDF",
          print: "Imprimir",
        },
        aria: {
          sortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
        autoFill: {
          cancel: "Cancelar",
          fill: "Rellene todas las celdas con <i> %d </i>",
          fillHorizontal: "Rellenar celdas horizontalmente",
          fillVertical: "Rellenar celdas verticalmente",
        },
        decimal: ",",
        emptyTable: "No hay datos disponibles en la tabla",
        infoPostFix: "",
        thousands: ".",
        searchBuilder: {
          add: "Añadir condición",
          button: {
            0: "Constructor de búsqueda",
            _: "Constructor de búsqueda (%d)",
          },
          clearAll: "Borrar todo",
          condition: "Condición",
          conditions: {
            date: {
              after: "Después",
              before: "Antes",
              between: "Entre",
              empty: "Vacío",
              equals: "Igual a",
              not: "No",
              notBetween: "No entre",
              notEmpty: "No vacío",
            },
            number: {
              between: "Entre",
              empty: "Vacío",
              equals: "Igual a",
              gt: "Mayor que",
              gte: "Mayor o igual que",
              lt: "Menor que",
              lte: "Menor o igual que",
              not: "No",
              notBetween: "No entre",
              notEmpty: "No vacío",
            },
            string: {
              contains: "Contiene",
              empty: "Vacío",
              endsWith: "Termina en",
              equals: "Igual a",
              not: "No",
              notEmpty: "No vacío",
              startsWith: "Comienza con",
            },
            array: {
              not: "No",
              equals: "Igual",
              empty: "Vacío",
              contains: "Contiene",
              notEmpty: "No vacío",
              without: "Sin",
            },
          },
          data: "Datos",
          deleteTitle: "Eliminar regla de filtrado",
          leftTitle: "Criterios anulados",
          logicAnd: "Y",
          logicOr: "O",
          rightTitle: "Criterios de la derecha",
          title: {
            0: "Constructor de búsqueda",
            _: "Constructor de búsqueda (%d)",
          },
          value: "Valor",
        },
        searchPanes: {
          clearMessage: "Borrar todo",
          collapse: {
            0: "Paneles de búsqueda",
            _: "Paneles de búsqueda (%d)",
          },
          count: "{total}",
          countFiltered: "{shown} ({total})",
          emptyPanes: "Sin paneles de búsqueda",
          loadMessage: "Cargando paneles de búsqueda",
          title: "Filtros activos - %d",
        },
        select: {
          cells: {
            1: "1 celda seleccionada",
            _: "$d celdas seleccionadas",
          },
          columns: {
            1: "1 columna seleccionada",
            _: "%d columnas seleccionadas",
          },
          rows: {
            1: "1 fila seleccionada",
            _: "%d filas seleccionadas",
          },
        },
        thousands: ".",
      },
    })
    .buttons()
    .container()
    .appendTo("#example1_wrapper .col-md-6:eq(0)");

  var idusuario = document.getElementById("idusuario").value;

  const acciones = (data, type, row) => {
    if (row.estado == 1) {
      return `
      <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-warning btn-sm mr-2" type="button" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario" onclick="btnEditarUsuario(${row.idusuario})"><i class="fas fa-edit"></i></button>
            <button class="btn btn-warning btn-sm mr-2" type="button" data-bs-toggle="modal" data-bs-target="#modalCambiarPassword" onclick="btnCambiarPassword(${row.idusuario})"><i class="fas fa-key"></i></button>
            <button class="btn btn-danger btn-sm mr-2" type="button" onclick="btnDesactivarUsuario(${row.idusuario})"><i class="fas fa-times"></i></button>
      </div>
      `;
    } else {
      return `
      <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-primary btn-sm mr-2" type="button" onclick="btnActivarUsuario(${row.idusuario})"><i class="fas fa-check"></i></button>
            <button class="btn btn-danger btn-sm mr-2" type="button" onclick="btnEliminarUsuario(${row.idusuario})"><i class="fas fa-trash"></i></button>
      </div>
      `;
    }
  };

  const estado = (data, type, row) => {
    if (row.estado == 1) {
      return `<span class="badge bg-success text-white">Activo</span>`;
    } else {
      return `<span class="badge bg-danger text-white">Inactivo</span>`;
    }
  };

  $("#tableMisQuejas").DataTable({
    ajax: {
      url: BASE_URL + "MisQuejas/getMisQuejas",
      type: "POST",
      data: { idusuario: idusuario },
    },
    columns: [
      { data: "usuario" },
      { data: "nombre" },
      { data: "correo" },
      { data: "rol" },
      { data: "estado", render: estado },
      { data: "acciones", render: acciones },
    ],
    paging: true,
    lengthChange: false,
    searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
  });
});
