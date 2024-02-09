function generateCard(plant) {
    let path = "../images/" +plant.IMG_DIR;
    console.log(plant.NAME,plant.PRICE)
    return `
        <div class="card">
          <div class="card-content">
            <h2 class="card-title">${plant.NAME}</h2>
            <span class="card-counter">${plant.COUNTERTIMESNAME}</span>
          </div>
          <div class="card-content">
            <img src="${path}" alt="${plant.NAME}" class="card-image">
          </div>
          <div class="card-content" style="overflow: hidden;">
            <p class="card-price">$${plant.PRICE}</p>
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
