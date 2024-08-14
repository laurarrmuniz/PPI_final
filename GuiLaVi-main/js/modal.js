window.onload = function() {
    const modal = document.querySelector(".modal");
    const buttonClose = document.getElementById("buttonClose");

    buttonClose.addEventListener("click", function() {
        modal.style.display = 'none';
    });

    const buttonsOpenModal = document.querySelectorAll(".btnOpenModal");
    buttonsOpenModal.forEach(function(button) {
        button.addEventListener("click", function() {
            modal.style.display = 'block';
        });
    });
}