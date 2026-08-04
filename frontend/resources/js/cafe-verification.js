function openCreateModal(){
    document.getElementById("createModal").style.display = "flex";
}

function closeCreateModal(){
    document.getElementById("createModal").style.display = "none";
}

// loads and displays cafe details in the modal
async function openCafe(cafeId){
    const response = await fetch('/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/cafeController.php?action=get&id=' + cafeId);   

    if (!response.ok) {
        Swal.fire("Error", "Unable to load cafe details.", "error");
        return;
    }

    const cafe = await response.json();

    // populate cafe information
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

    // display main image
    const mainImage = document.getElementById("cafe-mainImage");
    mainImage.src = cafe.main_image;

    // load image gallery thumbnails
    const thumbnails = document.querySelectorAll(".gallery-thumbnail");

    thumbnails.forEach((thumbnail, index) => {
        if (!cafe.images[index]) {
            thumbnail.style.display = "none";
            return;
        }   
        thumbnail.style.display = "block";
        thumbnail.src = cafe.images[index];
        // change main image when thumbnail is clicked
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
    const confirmResult = await Swal.fire({
        title: "Approve this cafe?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, approve",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#725420"
    });

    if (!confirmResult.isConfirmed) return;

    const formData = new FormData();
    formData.append("cafe_id", cafeId);

    const response = await fetch("/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/cafeController.php?action=approve",
        {
            method: "POST",
            body: formData
        }
    );

    const result = await response.json();

    if (result.success) {
        // update status badge
        const status = document.getElementById(`status-${cafeId}`);

        if (status) {
            status.textContent = "Approved";
            status.className = "status approved";
        }

        await Swal.fire("Approved!", "Cafe has been approved.", "success");

        // remove card after a short delay
        setTimeout(() => {
            const card = document.getElementById(`cafe-${cafeId}`);
            if (card) {
                card.remove();
            }
        }, 1000);
    }
}

async function rejectCafe(cafeId) {
    const confirmResult = await Swal.fire({
        title: "Reject this cafe?",
        text: "This will remove the submission.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, reject",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33"
    });

    if (!confirmResult.isConfirmed) return;

    const formData = new FormData();
    formData.append("cafe_id", cafeId);

    const response = await fetch(
        "/CCDEVAP-S16-4-CafeAnoTara/backend/controllers/user/cafeController.php?action=reject",
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
        await Swal.fire("Rejected", "Cafe submission rejected.", "success");
    } else {
        Swal.fire("Failed", "Failed to reject cafe.", "error");
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