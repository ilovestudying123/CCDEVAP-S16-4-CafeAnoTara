function openCafe(cafeId) {

    const cafe = cafes.find(c => c.id === cafeId);

    if (!cafe) {
        console.error("Cafe doesn't exist");
        return;
    }

    // Text Information
    document.getElementById("cafe-name").textContent = cafe.name;
    document.getElementById("cafe-owner").textContent = cafe.owner;
    document.getElementById("cafe-address").textContent = cafe.address;
    document.getElementById("cafe-wifi").textContent = cafe.wifiSpeed;
    document.getElementById("cafe-outlets").textContent = cafe.outlets;
    document.getElementById("cafe-price").textContent = cafe.priceRange;
    document.getElementById("cafe-noise").textContent = cafe.noiseLevel;
    document.getElementById("cafe-hours").textContent = cafe.hours;
    document.getElementById("cafe-rating").textContent = cafe.rating;
    document.getElementById("cafe-desc-text").textContent = cafe.description;

    const mainImage = document.getElementById("cafe-mainImage");
    mainImage.src = cafe.mainImage;

    const thumbnails = document.querySelectorAll(".gallery-thumbnail");
    const galleryImages = [cafe.mainImage, ...cafe.additionImages];

    thumbnails.forEach((thumbnail, index) => {

        if (!galleryImages[index]) {
            thumbnail.style.display = "none";
            return;
        }

        thumbnail.style.display = "block";
        thumbnail.src = galleryImages[index];

        thumbnail.onclick = () => {

            mainImage.src = galleryImages[index];

            thumbnails.forEach(t => t.classList.remove("active"));
            thumbnail.classList.add("active");

        };

    });

    thumbnails.forEach(t => t.classList.remove("active"));
    thumbnails[0].classList.add("active");

    document.getElementById("detailsModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("detailsModal").style.display = "none";
}

window.addEventListener("click", function (event) {
    const modal = document.getElementById("detailsModal");

    if (event.target === modal) {
        closeModal();
    }
});