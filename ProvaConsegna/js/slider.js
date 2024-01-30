const slides = document.querySelector('.slides');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let slideIndex = 0;

prevButton.addEventListener('click', () => {
    slideIndex = Math.max(slideIndex - 1, 0);
    updateSliderPosition();
});

nextButton.addEventListener('click', () => {
    slideIndex = Math.min(slideIndex + 1, slides.children.length - 1);
    updateSliderPosition();
});

function updateSliderPosition() {
    slides.style.transform = `translateX(${-slideIndex * 300}px)`;
}