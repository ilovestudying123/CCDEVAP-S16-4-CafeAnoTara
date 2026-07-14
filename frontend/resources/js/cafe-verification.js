function createCafe() {
    const name = document.getElementById("create-name").value;
    const owner = document.getElementById("create-owner").value;
    const address = document.getElementById("create-address").value;
    const description = document.getElementById("create-description").value;
    const wifiSpeed = document.getElementById("create-wifi").value;
    const hours = document.getElementById("create-hours").value;
    const priceRange = document.getElementById("create-price").value;
    const outlets = Number(document.getElementById("create-outlets").value);
    const noiseLevel = document.getElementById("create-noise").value;
    const rating = Number(document.getElementById("create-rating").value);

    const cafe = {
        id: name.toLowerCase().replaceAll(" ", ""),
        name,
        owner,
        address,
        description,
        wifiSpeed,
        hours,
        priceRange,
        outlets,
        noiseLevel,
        rating,
        status: "Pending",
        mainImage: "../../resources/imgs/siriusdan.jpg",
        additionalImages: [
            "../../resources/imgs/siriusdan1.jpg",
            "../../resources/imgs/siriusdan2.jpg",
            "../../resources/imgs/siriusdan3.jpg",
            "../../resources/imgs/siriusdan4.jpg"
        ]
    };

    cafes.push(cafe);
    addCafeCard(cafe);
    closeCreateModal();
}

function addCafeCard(cafe){
    const holder = document.querySelector(".card-holder");

    holder.innerHTML += `

    <section class="cafe-card">
        <div class="cafe-info">
            <img src="${cafe.mainImage}">

            <div class="cafe-details">
                <h1>${cafe.name}</h1>
                <p>${cafe.owner}<p>
                <p><br></p>
                <p>${cafe.address}</p>
            </div>
        </div>

        <div>
            <span id="status-${cafe.id}"class="status pending">Pending</span>
        </div>

        <div class="button-holder">
            <button class="reject-btn" onclick="rejectCafe('${cafe.id}')">Reject</button>
            <button class="approve-btn" onclick="approveCafe('${cafe.id}')">Approve</button>
            <button class="view-btn" onclick="openCafe('${cafe.id}')"><img src="../../resources/imgs/eye-solid.png" alt="View Details"></button>
        </div>
    </section>

    `;
}

function openCreateModal(){
    document.getElementById("createModal").style.display = "flex";
}

function closeCreateModal(){
    document.getElementById("createModal").style.display = "none";
}

function openCafe(cafeId) {
    const cafe = cafes.find(c => c.id === cafeId);
    if (!cafe) {
        console.error("Cafe doesn't exist");
        return;
    }

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
    const galleryImages = [cafe.mainImage, ...cafe.additionalImages];

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

function approveCafe(cafeId) {
    const proceed = confirm("Are you sure you want to approve this cafe?");
    if (!proceed) return;

    const cafe = cafes.find(c => c.id === cafeId);
    if (!cafe) return;

    cafe.status = "Approved";

    const status = document.getElementById(`status-${cafeId}`);
        status.textContent = "Approved";
        status.className = "status approved";

    alert(`${cafe.name} has been approved.`);
}

function rejectCafe(cafeId) {
    const proceed = confirm("Are you sure you want to reject this cafe?");
    if (!proceed) return;

    const cafe = cafes.find(c => c.id === cafeId);
    if (!cafe) return;

    cafe.status = "Rejected";

    const status = document.getElementById(`status-${cafeId}`);
        status.textContent = "Rejected";
        status.className = "status rejected";

    alert(`${cafe.name} has been rejected.`);
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