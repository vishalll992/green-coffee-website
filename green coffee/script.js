const header = document.querySelector('header');

function fixednavbar() {
    if (header) {
        header.classList.toggle('scroll', window.pageYOffset > 0);
    }
}

fixednavbar();
window.addEventListener('scroll', fixednavbar);

let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

if (menu) {
    menu.addEventListener('click', function () {
        let nav = document.querySelector('.navbar');
        if (nav) {
            nav.classList.toggle('active');
        }
    });
}

if (userBtn) {
    userBtn.addEventListener('click', function () {
        let userBox = document.querySelector('.user-box');
        if (userBox) {
            userBox.classList.toggle('active');
        }
    });
}

/*-------home page slider----*/
"use strict";
const leftArrow = document.querySelector('.left-arrow .bxs-left-arrow'),
    rightArrow = document.querySelector('.right-arrow .bxs-right-arrow'),
    slider = document.querySelector('.slider');

if (slider) {
    /*------scroll to right-------*/
    function scrollRight() {
        if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
            slider.scrollTo({
                left: 0,
                behavior: "smooth"
            });
        } else {
            slider.scrollBy({
                left: window.innerWidth,
                behavior: "smooth"
            });
        }
    }

    /*-----scroll to left-----*/
    function scrollLeft() {
        slider.scrollBy({
            left: -window.innerWidth,
            behavior: "smooth"
        });
    }

    let timerId = setInterval(scrollRight, 7000);

    /*------reset timer to scroll right---*/
    function resetTimer() {
        clearInterval(timerId);
        timerId = setInterval(scrollRight, 7000);
    }

    /*------scroll event---*/
    slider.addEventListener("click", function (ev) {
        if (ev.target === leftArrow) {
            scrollLeft();
            resetTimer();
        }
    });

    slider.addEventListener("click", function (ev) {
        if (ev.target === rightArrow) {
            scrollRight();
            resetTimer();
        }
    });
}

/*-------testimonial slider------*/
let slides = document.querySelectorAll('.testimonial-item');
let index = 0;

function nextSlide() {
    if (slides.length > 0) {
        slides[index].classList.remove('active');
        index = (index + 1) % slides.length;
        slides[index].classList.add('active');
    }
}

function prevSlide() {
    if (slides.length > 0) {
        slides[index].classList.remove('active');
        index = (index - 1 + slides.length) % slides.length;
        slides[index].classList.add('active');
    }
}
