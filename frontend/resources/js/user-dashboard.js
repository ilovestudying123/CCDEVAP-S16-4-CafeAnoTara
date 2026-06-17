function goToSearchPage() {
        window.location.href="../../pages/user/search.html"
    }

    function toggleFilter() {
    const panel = document.getElementById('filter-options');
    if (panel.style.display === 'block') {
        panel.style.display = 'none';
    } else {
        panel.style.display = 'block';
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("rec-cafes-list");

    const top4Cafes =[...cafes];
    top4Cafes.sort((a, b) => b.rating - a.rating).slice(0, 4);

    top4Cafes.forEach(cafe => {
        const card = document.createElement('a');
        card.href = `cafeDetails.html?id=${cafe.id}`;
        card.classList.add('cafe-card');

        card.innerHTML = `
            <img src = "${cafe.mainImage}" alt="${cafe.name}">
            <div class="cafe-text">
                <h3>${cafe.name}</h3>
                <p><i class="fa-solid fa-star"></i>${cafe.rating}/5</p>
            </div>`;
        container.appendChild(card);
    });

    const button = document.getElementById('search-button');
    if (button) {
        button.addEventListener("click", goToSearchPage);
    }
});

