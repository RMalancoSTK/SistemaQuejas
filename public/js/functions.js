$(function () {
  $.ajax({
    url: "api/obtenerbaseurl",
    type: "GET",
    dataType: "json",
    success: function (data) {
      var base_url = data.base_url;
      localStorage.setItem("base_url", base_url);
    },
  });
});

$(function () {
  bsCustomFileInput.init();
});
