document.addEventListener("DOMContentLoaded", function () {
    // Cover Photo Elements
    const changeCoverBtn = document.getElementById("change-cover-btn");
    const coverModal = document.getElementById("coverModal");
    const closeCoverModal = document.getElementById("closeCoverModal");
    const saveCoverModal = document.getElementById("saveCoverModal");
    
    const coverInput = document.getElementById("cover-photo-input");
    const coverPreview = document.getElementById("cafe-cover-preview");
    const modalCoverImg = document.getElementById("modal-cover-img");

    // Edit Gallery Photos Elements
    const editPhotosBtn = document.getElementById("edit-photos-btn");
    const photoModal = document.getElementById("photoModal");
    const closePhotoModal = document.getElementById("closePhotoModal");
    const savePhotoModal = document.getElementById("savePhotoModal");

    // --- COVER PHOTO MODAL LOGIC ---
    if (changeCoverBtn) {
        changeCoverBtn.addEventListener("click", function () {
            // Load current hidden input value into modal text box
            modalCoverImg.value = coverInput.value;
            coverModal.style.display = "flex";
        });
    }

    if (closeCoverModal) {
        closeCoverModal.addEventListener("click", function () {
            coverModal.style.display = "none";
        });
    }

    if (saveCoverModal) {
        saveCoverModal.addEventListener("click", function () {
            const newUrl = modalCoverImg.value.trim();
            if (newUrl !== "") {
                coverInput.value = newUrl;
                coverPreview.src = newUrl; // Live update thumbnail image container
            }
            coverModal.style.display = "none";
        });
    }

    // --- GALLERY PHOTOS MODAL LOGIC ---
    if (editPhotosBtn) {
        editPhotosBtn.addEventListener("click", function () {
            for (let i = 0; i < 4; i++) {
                document.getElementById(`modal-img-${i}`).value = document.getElementById(`extra-photo-${i}`).value;
            }
            photoModal.style.display = "flex";
        });
    }

    if (closePhotoModal) {
        closePhotoModal.addEventListener("click", function () {
            photoModal.style.display = "none";
        });
    }

    if (savePhotoModal) {
        savePhotoModal.addEventListener("click", function () {
            for (let i = 0; i < 4; i++) {
                const modalValue = document.getElementById(`modal-img-${i}`).value.trim();
                document.getElementById(`extra-photo-${i}`).value = modalValue;
            }
            photoModal.style.display = "none";
        });
    }
});