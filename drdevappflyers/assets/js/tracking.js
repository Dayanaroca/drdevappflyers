async function submitTracking() {
  const number = document.getElementById('tracking-number').value.trim();
  const resultContainer = document.getElementById('tracking-result');
  resultContainer.innerHTML = 'Consultando...';

  try {
    const dataParam = JSON.stringify({
      enterprise: "dayready",
      number: [number]
    });

    const url = `https://www.solvedc.com/api/dayready/v3/tracking/?apikey=O90Z6NJUA97VWXAX116MF24QD1V1US&data=${encodeURIComponent(dataParam)}`;
    const response = await fetch(url, { method: 'GET' });

    if (!response.ok) throw new Error('Error al consultar el pedido');

    const data = await response.json();
    if (!Array.isArray(data) || data.length === 0) {
      resultContainer.innerHTML = `<p class="text-red-600">No se encontró información para este número.</p>`;
      return;
    }

    const item = data[0];

    // 🎨 Mapear status -> icono (nombre archivo .svg)
    const icons = {
      "Entregado al Cliente": "delivered.svg",
      "Tránsito Última Milla": "lastmile.svg",
      "default": "default.svg"
    };

    resultContainer.innerHTML = `
      <p class="text-[#040404] font-montserrat font-bold text-base leading-[26.4px] mb-2">
        Estados de los paquetes
      </p>
      <div class="space-y-3">
        ${item.status.map(st => `
          <div class="flex items-center space-x-2">
            <img src="${trackingData.iconsBase}${icons[st.status] || icons.default}" alt="${st.status}" class="w-6 h-6">
            <div>
              <p class="text-[#040404] font-montserrat text-xs font-bold">${st.status}</p>
              <p class="text-black font-montserrat text-xs font-normal">${st.date}</p>
            </div>
          </div>
        `).join('')}
      </div>
    `;
  } catch (error) {
    console.error(error);
    resultContainer.innerHTML = `<p class="text-red-600">No se pudo obtener el estado del envío. Intenta de nuevo.</p>`;
  }
}