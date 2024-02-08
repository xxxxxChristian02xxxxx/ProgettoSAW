function generateCard(plant) {
    return `
    <div class="card">
      <img src="${plant.urlimage}" alt="${plant.name}" class="card-image">
      <div class="card-content">
        <h2 class="card-title">${plant.name}</h2>
        <p class="card-price">$${plant.price}</p>
      </div>
    </div>
  `;
}

function appendPlantsToContainer(plants, container) {
    let gridHtml = '';
    plants.forEach(plant => {
        gridHtml += generateCard(plant);
    });
    container.innerHTML = gridHtml;
}
