function mygardenFetch() {
    let plants = [];

    fetch("../backend/be_mygarden.php")
        .then(response => {
            //  console.log("Response: ", response); // log the response
            // return response.text();
            return response.json();
        })
        .then(data => {
            plants = data; // store the data in the `plants` variable
            const plantsContainer = document.getElementById('plants-container');
            appendPlantsToContainer(plants, plantsContainer);
        })
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });
}

function generateCard(plant) {
    let path = "../images/" +plant.IMG_DIR;
    return `
        <div class="card">
          <div class="card-content">
            <h2 class="card-title">${plant.NAME}</h2>
            <span class="card-counter">${plant.COUNTERTIMES}</span>
          </div>
          <div class="card-content">
            <img src="${path}" alt="${plant.NAME}" class="card-image">
          </div>
          <div class="card-content" style="overflow: hidden;">
            <p class="card-price">Per unit: $${plant.PLANT_AMOUNT}</p>
          </div>
          <div class="card-content" style="overflow: hidden;">
            <p class="card-price">Total: $${plant.TOTAL_AMOUNT}</p>
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

window.addEventListener('DOMContentLoaded', () => {
    mygardenFetch();
});