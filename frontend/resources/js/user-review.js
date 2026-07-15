document.addEventListener("DOMContentLoaded", function () {

    const editModal = new bootstrap.Modal(document.getElementById("editModal"));
    const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));

    document.querySelectorAll(".edit-btn").forEach(button => {

        button.addEventListener("click", function () {

            document.getElementById("edit-review-id").value =
                this.dataset.reviewId;

            document.getElementById("edit-rating").value =
                this.dataset.rating;

            document.getElementById("edit-comment").value =
                this.dataset.comment;

            editModal.show();
        });

    });

    document.querySelectorAll(".delete-btn").forEach(button => {

        button.addEventListener("click", function () {

            document.getElementById("delete-review-id").value =
                this.dataset.reviewId;

            deleteModal.show();
        });

    });

});