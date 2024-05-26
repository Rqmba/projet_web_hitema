// Js du carousel
    let currentIndex = 0;
    console.log(currentIndex);
  
    let slides = document.querySelector('.slides');
    let imgCount = document.querySelectorAll('.slide').length;
    console.log(imgCount);
  
    let carousel = document.querySelector('.carousel');
    let parentWidth = carousel.offsetWidth;
    console.log(parentWidth);
  
    function position() {
      const imgPosition = -currentIndex * parentWidth;
      slides.style.transform = `translateX(${imgPosition}px)`;
    }
  
    position();
  
    let flechedroite = document.querySelector('.next');
    flechedroite.addEventListener('click', function () {
      currentIndex = (currentIndex + 1) % imgCount;
      position();
    });
  
    let flechegauche = document.querySelector('.prev');
    flechegauche.addEventListener('click', function () {
      currentIndex = (currentIndex - 1 + imgCount) % imgCount;
      position();
    });
  
  