document.addEventListener('DOMContentLoaded', function () {
  flatpickr("#traveldate", {
    mode: "range",
      ateFormat: "d/m/Y",
    locale: "es"
  });
});