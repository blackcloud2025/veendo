
const body = document.querySelector('body'),
    sidebar = body.querySelector('nav'),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwitch = body.querySelector(".toggle-switch"),
    modeText = body.querySelector(".mode-text");

//toggle cerrar y abrir menu
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");

})

searchBtn.addEventListener("click", () => {
    sidebar.classList.remove("close");

})

//toggle modo oscuro
modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark");

    if (body.classList.contains("dark")) {
        modeText.innerText = "Light mode";
        localStorage.setItem('dark-mode', 'true');
    } else {
        modeText.innerText = "Dark mode";
        localStorage.setItem('dark-mode', 'false');
    }
})


//logeo comportamiento
const btnSignIn = document.getElementById("sign-in"),
    btnSignUp = document.getElementById("sign-up"),
    containerFormRegister = document.querySelector(".register"),
    containerFormLogin = document.querySelector(".login");

if (btnSignIn) {
    btnSignIn.addEventListener("click", e => {
        containerFormRegister.classList.add("hide");
        containerFormLogin.classList.remove("hide")
    })


    btnSignUp.addEventListener("click", e => {
        containerFormLogin.classList.add("hide");
        containerFormRegister.classList.remove("hide")
    })
}


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






