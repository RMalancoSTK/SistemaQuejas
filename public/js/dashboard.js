// BASE_URL = localStorage.getItem("base_url").toString();
const base_url = localStorage.getItem("base_url");
BASE_URL = base_url !== null ? base_url.toString() : "";

if (document.getElementById("quejasChart")) {
  $.ajax({
    url: BASE_URL + "dashboard/obtenerquejas",
    type: "POST",
    async: true,
    success: function (response) {
      var data = JSON.parse(response);
      const diasDelMes = [];
      const pendientes = [];
      const atendidas = [];
      const rechazadas = [];
      data.forEach((element) => {
        diasDelMes.push(element.dia);
        pendientes.push(element.totalpendientes);
        atendidas.push(element.totalatendidas);
        rechazadas.push(element.totalrechazadas);
      });
      construirGrafico(diasDelMes, pendientes, atendidas, rechazadas);
    },
    error: function (error) {
      console.log(error);
    },
  });
}

function construirGrafico(diasDelMes, pendientes, atendidas, rechazadas) {
  "use strict";
  var quejasChartCanvas = $("#quejasChart").get(0).getContext("2d");
  var quejasChartData = {
    labels: diasDelMes,
    datasets: [
      {
        label: "Pendientes",
        backgroundColor: "#ffc107",
        borderColor: "#ffc107",
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

  var quejasChartOptions = {
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
  var quejasChart = new Chart(quejasChartCanvas, {
    type: "bar",
    data: quejasChartData,
    options: quejasChartOptions,
  });
}
