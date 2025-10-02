const phoneInputs = document.querySelectorAll("#phone");

phoneInputs.forEach(input => {
  window.intlTelInput(input, {
    initialCountry: "auto",
    nationalMode: false,     // muestra el código en el input
    separateDialCode: true,  // NO separa el código en un contenedor distinto
    autoHideDialCode: false, // muestra el +XX incluso con input vacío
      geoIpLookup: function (callback) {
    fetch('https://ipwho.is/')
      .then(res => res.json())
      .then(data => {
        window.geoData = data; // save country
        callback(data.country_code || 'us');
      })
      .catch(() => {
        window.geoData = { country_code: 'US', country: 'United States' };
        callback('us');
      });
  },
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
  });
});