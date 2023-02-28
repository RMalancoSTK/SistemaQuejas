var primerDiaDelMes = document.getElementById("primerdiadelmesactual").value;
var ultimoDiaDelMes = document.getElementById("ultimodiadelmesactual").value;
var fechaInicio = new Date(primerDiaDelMes);
var fechaFin = new Date(ultimoDiaDelMes);
var diferenciaEnTiempo = fechaFin.getTime() - fechaInicio.getTime();
var diferenciaEnDias = diferenciaEnTiempo / (1000 * 3600 * 24) + 1;
const diasDelMes = [];
let pendientes = [];
let atendidas = [];
let rechazadas = [];

for (var i = 0; i < diferenciaEnDias; i++) {
  var dia = new Date(fechaInicio.getTime() + i * 24 * 60 * 60 * 1000).getDate();
  diasDelMes.push(dia);
}

function arrayPendientes(callback) {
  // ajax para obtener los datos de las quejas pendientes por metodo POST y idestado = 1
  $.ajax({
    url: "dashboard/obtenerquejas",
    type: "POST",
    async: true,
    data: {
      idestado: 1,
    },
    success: function (response) {
      if (response != 0) {
        var data = JSON.parse(response);
        const cantidadpendientes = [];
        for (var i = 0; i < diasDelMes.length; i++) {
          var encontrardia = false;
          for (var j = 0; j < data.length; j++) {
            var dia = data[j].dia;
            var total = data[j].total;
            if (diasDelMes[i] == dia) {
              cantidadpendientes.push(total);
              encontrardia = true;
            }
          }
          if (encontrardia == false) {
            cantidadpendientes.push(0);
          }
        }
        callback(cantidadpendientes);
      }
    },
    error: function (error) {
      callback([]);
    },
  });
}

function arrayAtendidas(callback) {
  // ajax para obtener los datos de las quejas pendientes por metodo POST y idestado = 2
  $.ajax({
    url: "dashboard/obtenerquejas",
    type: "POST",
    async: true,
    data: {
      idestado: 2,
    },
    success: function (response) {
      if (response != 0) {
        var data = JSON.parse(response);
        const cantidadatendidas = [];
        for (var i = 0; i < diasDelMes.length; i++) {
          var encontrardia = false;
          for (var j = 0; j < data.length; j++) {
            var dia = data[j].dia;
            var total = data[j].total;
            if (diasDelMes[i] == dia) {
              cantidadatendidas.push(total);
              encontrardia = true;
            }
          }
          if (encontrardia == false) {
            cantidadatendidas.push(0);
          }
        }
        callback(cantidadatendidas);
      }
    },
    error: function (error) {
      callback([]);
    },
  });
}

function arrayRechazadas(callback) {
  // ajax para obtener los datos de las quejas pendientes por metodo POST y idestado = 3
  $.ajax({
    url: "dashboard/obtenerquejas",
    type: "POST",
    async: true,
    data: {
      idestado: 3,
    },
    success: function (response) {
      if (response != 0) {
        var data = JSON.parse(response);
        const cantidadrechazadas = [];
        for (var i = 0; i < diasDelMes.length; i++) {
          var encontrardia = false;
          for (var j = 0; j < data.length; j++) {
            var dia = data[j].dia;
            var total = data[j].total;
            if (diasDelMes[i] == dia) {
              cantidadrechazadas.push(total);
              encontrardia = true;
            }
          }
          if (encontrardia == false) {
            cantidadrechazadas.push(0);
          }
        }
        callback(cantidadrechazadas);
      }
    },
    error: function (error) {
      callback([]);
    },
  });
}

arrayPendientes(function (cantidadPendientes) {
  for (var i = 0; i < cantidadPendientes.length; i++) {
    pendientes.push(cantidadPendientes[i]);
  }
});

arrayAtendidas(function (cantidadAtendidas) {
  for (var i = 0; i < cantidadAtendidas.length; i++) {
    atendidas.push(cantidadAtendidas[i]);
  }
});

arrayRechazadas(function (cantidadRechazadas) {
  for (var i = 0; i < cantidadRechazadas.length; i++) {
    rechazadas.push(cantidadRechazadas[i]);
  }
});

$(function () {
  "use strict";
  var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
  var salesChartData = {
    labels: diasDelMes,
    datasets: [
      {
        label: "Pendientes",
        backgroundColor: "#007bff",
        borderColor: "#007bff",
        data: pendientes,
      },
      {
        label: "Atendidas",
        backgroundColor: "#28a745",
        borderColor: "#28a745",
        data: atendidas,
      },
      {
        label: "Rechazadas",
        backgroundColor: "#dc3545",
        borderColor: "#dc3545",
        data: rechazadas,
      },
    ],
  };

  var salesChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false,
    },
    scales: {
      xAxes: [
        {
          gridLines: {
            display: false,
          },
        },
      ],
      yAxes: [
        {
          gridLines: {
            display: false,
          },
        },
      ],
    },
  };
  var salesChart = new Chart(salesChartCanvas, {
    type: "bar",
    data: salesChartData,
    options: salesChartOptions,
  });
});
