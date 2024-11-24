
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



//pop up notificacion

    document.addEventListener('DOMContentLoaded', function() {

        // Assuming successful form submission triggers a 'productUpdated' event
        document.addEventListener('productUpdated', function() {

            // Create a new div element for the notification
            const notification = document.createElement('div');
            notification.classList.add('notification', 'success');
            notification.textContent = 'Producto actualizado correctamente!';

            // Append the notification to the body
            document.body.appendChild(notification);

            // Automatically remove the notification after a few seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        });
    });








