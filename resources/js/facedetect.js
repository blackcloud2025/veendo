// Global function declarations
let stream = null
function startFaceRecognition() {
  const cameraToggle = document.getElementById("camera-toggle")
  const cameraToggleLogin = document.getElementById("camera-toggle-1")
  const videoFeed = document.getElementById("camera-feed")
  const videoFeedLogin = document.getElementById("camera-feed-1")

  if (cameraToggle) {
    cameraToggle.addEventListener("change", async function () {
      if (this.checked) {
        stopAllCameras()
        await toggleCamera(true, videoFeed, "register")
        this.checked = true
      } else {
        stopAllCameras()
      }
    })
  }

  if (cameraToggleLogin) {
    cameraToggleLogin.addEventListener("change", async function () {
      if (this.checked) {
        stopAllCameras()
        await toggleCamera(true, videoFeedLogin, "login")
        this.checked = true
      } else {
        stopAllCameras()
      }
    })
  }
}

function stopAllCameras() {
  if (stream) {
    stream.getTracks().forEach((track) => track.stop())
  }
  const videoElements = [document.getElementById("camera-feed"), document.getElementById("camera-feed-1")]
  const toggleElements = [document.getElementById("camera-toggle"), document.getElementById("camera-toggle-1")]

  videoElements.forEach((video) => {
    if (video) video.style.display = "none"
  })
  toggleElements.forEach((toggle) => {
    if (toggle) toggle.checked = false
  })
  stream = null
}

async function toggleCamera(isOn, videoElement, mode) {
    if (isOn) {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: {
                    width: { ideal: 325 },
                    height: { ideal: 244 }
                },
                audio: false
            });
            videoElement.srcObject = stream;
            videoElement.style.display = 'block';
            
            // Wait for video to be ready
            await new Promise(resolve => {
                videoElement.onloadedmetadata = () => {
                    videoElement.play();
                    resolve();
                };
            });
            
            // Start face detection
            detectFace(videoElement, mode);
        } catch (error) {
            console.error('Error al acceder a la cámara:', error);
            alert('Error al acceder a la cámara');
        }
    } else {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        videoElement.style.display = 'none';
    }
}

async function detectFace(videoElement, mode) {
    console.log("Iniciando detección facial");

    // Wait for video to be fully loaded
    await new Promise((resolve) => {
        if (videoElement.readyState >= 2) {
            resolve();
        } else {
            videoElement.onloadeddata = () => resolve();
        }
    });

    // Create and configure canvas for visualization
    const canvas = document.createElement("canvas");
    videoElement.parentElement.appendChild(canvas);
    canvas.style.position = "absolute";
    canvas.style.top = "0";
    canvas.style.left = "0";
    canvas.width = videoElement.offsetWidth;
    canvas.height = videoElement.offsetHeight;

    const resizeObserver = new ResizeObserver(() => {
        canvas.width = videoElement.offsetWidth;
        canvas.height = videoElement.offsetHeight;
    });
    resizeObserver.observe(videoElement);

    let isDetecting = false;

    async function detect() {
        if (isDetecting) return;
        isDetecting = true;

        try {
            if (videoElement.style.display === "none") {
                resizeObserver.disconnect();
                canvas.remove();
                isDetecting = false;
                return;
            }

            // Check if video dimensions are valid
            if (!videoElement.videoWidth || !videoElement.videoHeight) {
                console.log("Video dimensions not available yet");
                isDetecting = false;
                requestAnimationFrame(detect);
                return;
            }

            // Use the actual video dimensions for detection
            const tempCanvas = document.createElement("canvas");
            tempCanvas.width = videoElement.videoWidth;
            tempCanvas.height = videoElement.videoHeight;
            const tempCtx = tempCanvas.getContext("2d", { willReadFrequently: true });
            
            // Draw directly without transformation
            tempCtx.drawImage(videoElement, 0, 0, tempCanvas.width, tempCanvas.height);
            
            console.log(`Processing frame: ${tempCanvas.width}x${tempCanvas.height}`);

            // Configure detection options
            const options = new faceapi.SsdMobilenetv1Options({ 
                minConfidence: 0.5,
                maxResults: 1
            });

            // Perform detection on the temp canvas
            const detections = await faceapi.detectSingleFace(tempCanvas, options)
                .withFaceLandmarks()
                .withFaceDescriptor();

            // Clear the display canvas
            const ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            if (detections) {
                console.log("Face detected with box:", 
                    JSON.stringify({
                        x: detections.detection.box.x,
                        y: detections.detection.box.y,
                        width: detections.detection.box.width,
                        height: detections.detection.box.height
                    })
                );

                // Store face descriptor
                const descriptor = Array.from(detections.descriptor);
                const descriptorString = JSON.stringify(descriptor);

                const form = mode === "register" ? 
                    document.querySelector(".form-register") : 
                    document.querySelector(".form-login");

                let descriptorInput = form.querySelector('input[name="face_descriptor"]');
                if (!descriptorInput) {
                    descriptorInput = document.createElement("input");
                    descriptorInput.type = "hidden";
                    descriptorInput.name = "face_descriptor";
                    form.appendChild(descriptorInput);
                }
                descriptorInput.value = descriptorString;

                // Map dimensions for display
                faceapi.matchDimensions(canvas, { 
                    width: canvas.width, 
                    height: canvas.height 
                });
                
                // Calculate scale factors manually
                const scaleX = canvas.width / videoElement.videoWidth;
                const scaleY = canvas.height / videoElement.videoHeight;
                
                // Create manually scaled detection result
                const scaledBox = {
                    x: detections.detection.box.x * scaleX,
                    y: detections.detection.box.y * scaleY,
                    width: Math.abs(detections.detection.box.width * scaleX),
                    height: Math.abs(detections.detection.box.height * scaleY)
                };
                
                // Create scaled detection copy
                const scaledDetection = {
                    ...detections,
                    detection: {
                        ...detections.detection,
                        box: new faceapi.Box(
                            scaledBox.x,
                            scaledBox.y,
                            scaledBox.width,
                            scaledBox.height
                        )
                    }
                };
                
                // Draw the detection
                faceapi.draw.drawDetections(canvas, [scaledDetection]);
            } else {
                console.log("No face detected in this frame");
            }

            isDetecting = false;
            requestAnimationFrame(detect);
        } catch (error) {
            console.error("Face detection error:", error);
            isDetecting = false;
            setTimeout(() => requestAnimationFrame(detect), 500);
        }
    }

    detect();

    return () => {
        resizeObserver.disconnect();
        if (canvas.parentElement) {
            canvas.remove();
        }
    };
}

async function initFaceApi() {
  console.log("Inicializando FaceAPI...")
  try {
    await Promise.all([
      faceapi.nets.faceRecognitionNet.loadFromUri("/models"),
      faceapi.nets.faceLandmark68Net.loadFromUri("/models"),
      faceapi.nets.ssdMobilenetv1.loadFromUri("/models"),
    ])
    console.log("Modelos cargados exitosamente")
    startFaceRecognition()
  } catch (error) {
    console.error("Error al cargar modelos:", error)
    console.log("Por favor verifica si los modelos existen en:", window.location.origin + "/models")
  }
}

// Main event listener
document.addEventListener("DOMContentLoaded", () => {
  // Login/Register form toggle functionality
  const btnSignIn = document.getElementById("sign-in"),
    btnSignUp = document.getElementById("sign-up"),
    containerFormRegister = document.querySelector(".register"),
    containerFormLogin = document.querySelector(".login")

  if (btnSignIn) {
    btnSignIn.addEventListener("click", (e) => {
      containerFormRegister.classList.add("hide")
      containerFormLogin.classList.remove("hide")
      stopAllCameras() // Stop cameras when switching forms
    })

    btnSignUp.addEventListener("click", (e) => {
      containerFormLogin.classList.add("hide")
      containerFormRegister.classList.remove("hide")
      stopAllCameras() // Stop cameras when switching forms
    })
  }

  initFaceApi()

  // Add form submission handlers
  const loginForm = document.querySelector(".form-login")
  const registerForm = document.querySelector(".form-register")

  if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault()
      const formData = new FormData(this)

      try {
        const response = await fetch(this.action, {
          method: "POST",
          body: formData,
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
          },
        })

        const result = await response.json()
        console.log("Login response:", result)

        if (result.success) {
          window.location.href = result.redirect
        } else {
          alert(result.message || "Error en el inicio de sesión")
        }
      } catch (error) {
        console.error("Login error:", error)
      }
    })
  }

  if (registerForm) {
    registerForm.addEventListener("submit", async function (e) {
      e.preventDefault()
      const formData = new FormData(this)

      try {
        const response = await fetch(this.action, {
          method: "POST",
          body: formData,
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
          },
        })

        const result = await response.json()
        console.log("Register response:", result)

        if (result.success) {
          window.location.href = result.redirect
        } else {
          alert(result.message || "Error en el registro")
        }
      } catch (error) {
        console.error("Register error:", error)
      }
    })
  }
})

