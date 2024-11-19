//carrucel comportamiento y manejo de imagenes  responsive
const btnLeft = document.querySelector(".btn-left"),
    btnRight = document.querySelector(".btn-right"),
    slider = document.querySelector("#slider"),
    sliderSection = document.querySelectorAll(".slider-section");


btnLeft.addEventListener("click", e => moveToLeft())
btnRight.addEventListener("click", e => moveToRight())



if (document.title === "Home") {
    setInterval(() => {
        moveToRight();
    }, 3000);
} else {
}


let operacion = 0,
    counter = 0;

function moveToRight() {
    const widthImg = slider.clientWidth / 10;
    counter++;
    if (counter >= sliderSection.length) {
        counter = 0;
        operacion = 0;
        slider.style.transform = `translate(-${operacion}px)`;
        slider.style.transition = "all ease .6s";
        return;
    }
    operacion = operacion + widthImg;
    slider.style.transform = `translate(-${operacion}px)`;
    slider.style.transition = "all ease .6s"

}

function moveToLeft() {
    const widthImg = slider.clientWidth / 10;
    counter--;
    if (counter <= 0) {
        counter = sliderSection.length;
        operacion = widthImg * (sliderSection.length - 1)
        slider.style.transform = `translate(-${operacion}px)`;
        slider.style.transition = "all ease .6s";
        return;
    }
    operacion = operacion - widthImg;
    slider.style.transform = `translate(-${operacion}px)`;
    slider.style.transition = "all ease .6s"


}