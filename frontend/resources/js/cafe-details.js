document.addEventListener("DOMContentLoaded", () => {
    // const params = new URLSearchParams(window.location.search);
    // const cafeId = params.get('id');
    // const cafe = cafes.find(c => c.id === cafeId);

    // if (cafe) {
    //     document.getElementById('cafe-name').textContent = cafe.name;
    //     document.getElementById('cafe-address').textContent = cafe.address;
    //     document.getElementById('cafe-mainImage').src = cafe.mainImage;
    //     document.getElementById('cafe-wifi').textContent = cafe.wifiSpeed;
    //     document.getElementById('cafe-outlets').textContent = cafe.outlets;
    //     document.getElementById('cafe-price').textContent = cafe.priceRange;
    //     document.getElementById('cafe-noise').textContent = cafe.noiseLevel;
    //     document.getElementById('cafe-hours').textContent = cafe.hours;
    //     document.getElementById('cafe-rating').textContent = cafe.rating;
    //     document.getElementById('cafe-desc-text').textContent = cafe.description;

    //     const additionalImgElements = document.querySelectorAll('.additional-images');
    //     additionalImgElements.forEach ((img, index) => {
    //         img.src = cafe.additionalImages[index];
    //     });
    // } else {
    //     console.error('Cafe doesnt exist');
    // }

    let selectedRating = 0;

const stars = document.querySelectorAll('#star-rating i');

stars.forEach(star => {
    
    star.addEventListener('mouseover', () => {
        const val = parseInt(star.dataset.value);
        stars.forEach(s => {
            const sVal = parseInt(s.dataset.value);
            if (sVal <= val) {
                s.classList.remove('fa-regular');
                s.classList.add('fa-solid');
                s.style.color = 'gold';
            } else {
                s.classList.remove('fa-solid');
                s.classList.add('fa-regular');
                s.style.color = '';
            }
        });
    });

    
    star.addEventListener('mouseleave', () => {
        stars.forEach(s => {
            const sVal = parseInt(s.dataset.value);
            if (sVal <= selectedRating) {
                s.classList.remove('fa-regular');
                s.classList.add('fa-solid');
                s.style.color = 'gold';
            } else {
                s.classList.remove('fa-solid');
                s.classList.add('fa-regular');
                s.style.color = '';
            }
        });
    });

    
    star.addEventListener('click', () => {
        selectedRating = parseInt(star.dataset.value);
        document.getElementById('rating-value').value = selectedRating;
        console.log('Rating selected:', selectedRating);
    });
});
});