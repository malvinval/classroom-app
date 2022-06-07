const myClassroom_cards = document.querySelector(".myclassroom-cards");
const myClassroom_buttons_container = document.querySelector(".myclassroom-buttons-container");

myClassroom_cards.addEventListener("mouseover", function() {
    myClassroom_buttons_container.classList.add("myclassroom-buttons-container-visible");
});

myClassroom_cards.addEventListener("mouseout", function() {
    myClassroom_buttons_container.classList.remove("myclassroom-buttons-container-visible");
});