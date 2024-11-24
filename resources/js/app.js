


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



//pop up notificacion////////////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', function() {
    initializeNotifications();
});

function initializeNotifications() {
    const notifications = document.querySelectorAll('.notification');
    
    notifications.forEach(notification => {
        if (notification) {
            // Auto-hide after 3 seconds
            setTimeout(() => {
                hideNotification(notification);
            }, 3000);

            // Close button functionality
            const closeButton = notification.querySelector('.notification-close');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    hideNotification(notification);
                });
            }
        }
    });
}

function hideNotification(notification) {
    notification.style.animation = 'slideOut 0.5s ease-in-out';
    setTimeout(() => {
        notification.remove();
    }, 500);
}