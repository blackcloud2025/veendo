





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









