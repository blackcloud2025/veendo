const btnLeft = document.querySelector(".btn-left");
    const btnRight = document.querySelector(".btn-right");
    const slider = document.querySelector("#slider");
    const sliderSection = document.querySelectorAll(".slider-section");
    const dotsContainer = document.querySelector(".dots-container");

    let operacion = 0;
    let counter = 0;

    // Crear dots para navegación
    sliderSection.forEach((_, index) => {
      const dot = document.createElement('div');
      dot.classList.add('dot');
      if (index === 0) dot.classList.add('active');
      dot.addEventListener('click', () => goToSlide(index));
      dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.dot');

    function updateDots() {
      dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === counter);
      });
    }

    function goToSlide(slideIndex) {
      counter = slideIndex;
      const widthImg = slider.clientWidth / 10;
      operacion = widthImg * counter;
      slider.style.transform = `translate(-${operacion}px)`;
      slider.style.transition = "all ease .6s";
      updateDots();
    }

    function moveToRight() {
      const widthImg = slider.clientWidth / 10;
      counter++;
      if (counter >= sliderSection.length) {
        counter = 0;
        operacion = 0;
        slider.style.transform = `translate(-${operacion}px)`;
        slider.style.transition = "all ease .6s";
      } else {
        operacion = operacion + widthImg;
        slider.style.transform = `translate(-${operacion}px)`;
        slider.style.transition = "all ease .6s";
      }
      updateDots();
    }

    function moveToLeft() {
      const widthImg = slider.clientWidth / 10;
      counter--;
      if (counter < 0) {
        counter = sliderSection.length - 1;
        operacion = widthImg * counter;
        slider.style.transform = `translate(-${operacion}px)`;
        slider.style.transition = "all ease .6s";
      } else {
        operacion = operacion - widthImg;
        slider.style.transform = `translate(-${operacion}px)`;
        slider.style.transition = "all ease .6s";
      }
      updateDots();
    }

    btnLeft.addEventListener("click", moveToLeft);
    btnRight.addEventListener("click", moveToRight);

    // Autoplay cada 3 segundos si estamos en la página Home
    if (document.title === "Home") {
      setInterval(moveToRight, 3000);
    }