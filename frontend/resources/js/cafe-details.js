document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const cafeId = params.get('id');
    const cafe = cafes.find(c => c.id === cafeId);

    if (cafe) {
        document.getElementById('cafe-name').textContent = cafe.name;
        document.getElementById('cafe-address').textContent = cafe.address;
        document.getElementById('cafe-mainImage').src = cafe.mainImage;
        document.getElementById('cafe-wifi').textContent = cafe.wifiSpeed;
        document.getElementById('cafe-outlets').textContent = cafe.outlets;
        document.getElementById('cafe-price').textContent = cafe.priceRange;
        document.getElementById('cafe-noise').textContent = cafe.noiseLevel;
        document.getElementById('cafe-hours').textContent = cafe.hours;
        document.getElementById('cafe-rating').textContent = cafe.rating;
        document.getElementById('cafe-desc-text').textContent = cafe.description;

        const additionalImgElements = document.querySelectorAll('.additional-images');
        additionalImgElements.forEach ((img, index) => {
            img.src = cafe.additionalImages[index];
        });
    } else {
        console.error('Cafe doesnt exist');
}
});