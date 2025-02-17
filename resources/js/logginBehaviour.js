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

//camara de registro y login
document.addEventListener('DOMContentLoaded', function() {
    const cameraToggle = document.getElementById('camera-toggle');
    const cameraFeed = document.getElementById('camera-feed');
    const cameraToggle1 = document.getElementById('camera-toggle-1');
    const cameraFeed1 = document.getElementById('camera-feed-1');
    let stream = null;

    function stopAllCameras() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        cameraFeed.style.display = 'none';
        cameraFeed1.style.display = 'none';
        cameraToggle.checked = false;
        cameraToggle1.checked = false;
        stream = null;
    }

    cameraToggle.addEventListener('change', async function() {
        if (this.checked) {
            // Stop other camera first
            stopAllCameras();
            // Then activate this one
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: true,
                    audio: false
                });
                cameraFeed.srcObject = stream;
                cameraFeed.style.display = 'block';
                this.checked = true;
            } catch (err) {
                console.error('Error accessing camera:', err);
                this.checked = false;
            }
        } else {
            stopAllCameras();
        }
    });

    cameraToggle1.addEventListener('change', async function() {
        if (this.checked) {
            // Stop other camera first
            stopAllCameras();
            // Then activate this one
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: true,
                    audio: false
                });
                cameraFeed1.srcObject = stream;
                cameraFeed1.style.display = 'block';
                this.checked = true;
            } catch (err) {
                console.error('Error accessing camera:', err);
                this.checked = false;
            }
        } else {
            stopAllCameras();
        }
    });
});