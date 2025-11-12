document.addEventListener('DOMContentLoaded', () => {
  const forms = [
    document.getElementById('contactForm'),     
    document.getElementById('contactFormServices') 
  ].filter(Boolean);
  const urlInput = document.getElementById('url');
  const countryInput = document.getElementById('country');

  // --- Rellenar URL y país en todos los forms ---
  async function setCountry(countryInput) {
  try {
    if (!countryInput) return;

    const translations = await fetch(myData.countryFile).then(res => res.json());
    const data = window.geoData;
    if (!data) return;

    countryInput.value = translations[data.country] || data.country;
  } catch (err) {
    console.error('Error cargando país:', err);
  }
}

forms.forEach(form => {
  const urlInput = form.querySelector('#url');
  const countryInput = form.querySelector('#country');

  if (urlInput) urlInput.value = window.location.href;
  setCountry(countryInput);
});

  // --- Validaciones ---
  const validators = {
    required: value => value.trim() !== '',
    email: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
    phone: value => /^[0-9\s()+-]*$/.test(value)
  };

  function showError(input, message) {
    let errorEl = input.nextElementSibling;
    if (!errorEl || !errorEl.classList.contains('error-message')) {
      errorEl = document.createElement('span');
      errorEl.className = 'error-message text-red-500 text-sm ml-2';
      input.after(errorEl);
    }
    errorEl.textContent = message;
    input.classList.add('border-red-500');
  }

  function clearErrors(form) {
    form.querySelectorAll('.error-message').forEach(el => el.remove());
    form.querySelectorAll('input, textarea, select').forEach(input => input.classList.remove('border-red-500'));
    form.privacy?.classList.remove('ring', 'ring-red-500');
  }

  function validateForm(form, data) {
    clearErrors(form);
    let isValid = true;

    if (form.id === 'contactForm') {
      fields = [
        { key: 'name', checks: ['required'], label: 'Nombre' },
        { key: 'lastname', checks: ['required'], label: 'Apellidos' },
        { key: 'email', checks: ['required', 'email'], label: 'Email' },
        { key: 'phone', checks: ['phone'], label: 'Teléfono' },
        { key: 'services_type', checks: ['required'], label: 'Servicio deseado' }
      ];
    } else if (form.id === 'contactFormServices') {
      fields = [
        { key: 'name', checks: ['required'], label: 'Nombre' },
        { key: 'lastname', checks: ['required'], label: 'Apellidos' },
        { key: 'email', checks: ['required', 'email'], label: 'Email' },
        { key: 'phone', checks: ['phone'], label: 'Teléfono' },
        { key: 'traveldate', checks: ['required'], label: 'Fecha inicio / Fecha fin' },
        { key: 'services', checks: ['required'], label: 'Servicio' }
      ];
    }

    fields.forEach(f => {
      f.checks.forEach(check => {
        if (!validators[check](data[f.key])) {
          const msg = check === 'required' ? `${f.label} es obligatorio` : `inválido`;
          showError(form[f.key], msg);
          isValid = false;
        }
      });
    });

    if (!form.privacy?.checked) {
      form.privacy?.classList.add('ring', 'ring-red-500');
      isValid = false;
    }
    return isValid;
  }

  // --- Botón ---
  function setButtonState(button, disabled, text) {
    button.disabled = disabled;
    if (text) button.innerHTML = text;
    button.style.transition = 'all 0.3s ease';
    button.style.opacity = disabled ? 0.6 : 1;
    button.style.cursor = disabled ? 'not-allowed' : 'pointer';
  }

  // --- Envío ---
  async function submitForm(form) {
     await setCountry(countryInput);
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;

    if (!validateForm(form, data)) return;

    setButtonState(submitButton, true, 'Enviando...');

    try {
      const response = await fetch(zohoData.ajaxUrl, {
        method: 'POST',
        body: formData
      });

      if (!response.ok) throw new Error(`HTTP ${response.status}`);

      const text = await response.text();
      let resJson;
      try { resJson = JSON.parse(text); }
      catch { throw new Error('Respuesta inválida del servidor'); }

      if (resJson.success) {
        window.location.href = '/gracias';
      } else {
        alert(`Error al enviar el formulario: ${resJson.error || resJson.message || 'Desconocido'}`);
      }
    } catch (err) {
      alert(`Error inesperado: ${err.message}`);
      console.error(err);
    } finally {
      setButtonState(submitButton, false, originalText);
    }
  }

   forms.forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      submitForm(form);
    });
  });
});