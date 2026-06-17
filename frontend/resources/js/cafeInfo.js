// gets data in cafeInfo.html
const gridItems = document.querySelectorAll(".grid-container .grid-item");
const updateBtn = document.querySelector(".update-btn");

if (updateBtn && gridItems.length > 0) {
    
    updateBtn.onclick = function(e) {

        e.preventDefault();

        // gets what is placed in infoCafe.html
        const currentWifi = gridItems[0].querySelector(".desc-text").textContent;
        const currentHours = gridItems[1].querySelector(".desc-text").textContent;
        const currentPrice = gridItems[2].querySelector(".desc-text").textContent;
        const currentOutlets = gridItems[3].querySelector(".desc-text").textContent;
        
        // Redirects user to cafeInfo-update.html
        window.location.href = `cafeInfo-update.html?wifi=${currentWifi}&hours=${currentHours}&price=${currentPrice}&outlets=${currentOutlets}`;
    };
}

const saveBtn = document.getElementById("save-btn");

if (saveBtn) {
    // Reads the value inside the URL
    const urlParams = new URLSearchParams(window.location.search);
    
    const inputWifi = document.getElementById("input-wifi");
    const inputOutlets = document.getElementById("input-outlets");
    const inputHours = document.getElementById("input-hours");
    const inputPrice = document.getElementById("input-price");

    // Puts data in the placeholders
    inputWifi.placeholder = urlParams.get("wifi");
    inputHours.placeholder = urlParams.get("hours");
    inputPrice.placeholder = urlParams.get("price");
    inputOutlets.placeholder = urlParams.get("outlets");

    // When the user clicks the Update button
    saveBtn.onclick = function() {
        // If a textbox is empty, it will use the same info
        const nextWifi = inputWifi.value !== "" ? inputWifi.value : inputWifi.placeholder;
        const nextOutlets = inputOutlets.value !== "" ? inputOutlets.value : inputOutlets.placeholder;
        const nextHours = inputHours.value !== "" ? inputHours.value : inputHours.placeholder;
        const nextPrice = inputPrice.value !== "" ? inputPrice.value : inputPrice.placeholder;

        // Redirects user to cafeInfo.html
        window.location.href = `cafeInfo.html?wifi=${nextWifi}&hours=${nextHours}&price=${nextPrice}&outlets=${nextOutlets}`;
    };
}

// Updates text element with new URL
const urlParams = new URLSearchParams(window.location.search);
if (gridItems.length > 0 && urlParams.has("wifi")) {
    gridItems[0].querySelector(".desc-text").textContent = urlParams.get("wifi");
    gridItems[1].querySelector(".desc-text").textContent = urlParams.get("hours");
    gridItems[2].querySelector(".desc-text").textContent = urlParams.get("price");
    gridItems[3].querySelector(".desc-text").textContent = urlParams.get("outlets");
}