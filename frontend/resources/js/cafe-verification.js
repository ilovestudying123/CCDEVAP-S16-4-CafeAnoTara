function openCreateModal(){
    document.getElementById("createModal").style.display = "flex";
}

function closeCreateModal(){
    document.getElementById("createModal").style.display = "none";
}

async function openCafe(cafeId){
    const response = await fetch('/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/admin/cafe-get.php?id=' + cafeId);   

    if (!response.ok) {
        alert("Unable to load cafe details.");
        return;
    }

    const cafe = await response.json();

    document.getElementById("cafe-name").textContent = cafe.cafe_name
    document.getElementById("cafe-owner").textContent = cafe.firstname + " " + cafe.lastname;
    document.getElementById("cafe-address").textContent = cafe.location
    document.getElementById("cafe-wifi").textContent = cafe.wifi_speed
    document.getElementById("cafe-outlets").textContent = cafe.outlet_num
    document.getElementById("cafe-price").textContent = "₱" + Number(cafe.price).toLocaleString();
    document.getElementById("cafe-noise").textContent = cafe.noise_level.charAt(0).toUpperCase() + cafe.noise_level.slice(1);
    document.getElementById("cafe-hours").textContent = cafe.opening_time + " - " + cafe.closing_time;
    document.getElementById("cafe-rating").textContent = cafe.average_rating
    document.getElementById("cafe-desc-text").textContent = cafe.description;

    const mainImage = document.getElementById("cafe-mainImage");
    mainImage.src = cafe.main_image;

    const thumbnails = document.querySelectorAll(".gallery-thumbnail");

    thumbnails.forEach((thumbnail, index) => {
        if (!cafe.images[index]) {
            thumbnail.style.display = "none";
            return;
        }   
        thumbnail.style.display = "block";
        thumbnail.src = cafe.images[index];
        thumbnail.onclick = () => {
            mainImage.src = cafe.images[index];
            thumbnails.forEach(t =>
                t.classList.remove("active")
            );
            thumbnail.classList.add("active");
        };
    });
    document.getElementById("detailsModal").style.display = "flex";
}

async function approveCafe(cafeId) {
    const proceed = confirm("Are you sure you want to approve this cafe?");
    if (!proceed) return;

    const formData = new FormData();
    formData.append("cafe_id", cafeId);

    const response = await fetch("/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/admin/cafe-approve.php",
        {
            method: "POST",
            body: formData
        }
    );

    const result = await response.json();
    console.log(document.getElementById(`card-${cafeId}`));

    if (result.success) {
        const status = document.getElementById(`status-${cafeId}`);

        if (status) {
            status.textContent = "Approved";
            status.className = "status approved";
        }

        alert("Cafe has been approved.");

        setTimeout(() => {
            const card = document.getElementById(`cafe-${cafeId}`);
            if (card) {
                card.remove();
            }
        }, 1000);
    }
}

async function rejectCafe(cafeId) {
    const proceed = confirm("Are you sure you want to reject this cafe?");
    if (!proceed) return;

    const formData = new FormData();
    formData.append("cafe_id", cafeId);

    const response = await fetch(
        "/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/admin/cafe-reject.php",
        {
            method: "POST",
            body: formData
        }
    );

    const result = await response.json();
    if (result.success) {
        const card = document
            .getElementById(`cafe-${cafeId}`);
        if (card) {
            card.remove();
        }
        alert("Cafe submission rejected.");
    } else {
        alert("Failed to reject cafe.");
    }
}

function toggleFilter() {
    document.getElementById("filter-options").classList.toggle("show");
}

function toggleSort() {
    document.getElementById("sort-options").classList.toggle("show");
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