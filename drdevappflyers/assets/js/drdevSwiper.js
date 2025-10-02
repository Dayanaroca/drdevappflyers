document.addEventListener("DOMContentLoaded", function() {
  const paginationContainer = document.querySelector(".testimonial-pagination");
 if (paginationContainer) {
  function createPagination(swiper) {
    paginationContainer.innerHTML = "";
    for (let i = 0; i < swiper.slides.length; i++) {
      const dot = document.createElement("span");
      dot.className = "testimonial-dot inline-block w-3 h-2 bg-color8 rounded-[3.125rem] transition-all duration-300";
      paginationContainer.appendChild(dot);
    }
  }

  function updatePagination(activeIndex) {
    const dots = paginationContainer.querySelectorAll(".testimonial-dot");
    dots.forEach((dot, i) => {
      if (i === activeIndex) {
        dot.classList.remove("w-3", "bg-color8");
        dot.classList.add("w-12", "bg-secondary");
      } else {
        dot.classList.remove("w-12", "bg-secondary");
        dot.classList.add("w-3", "bg-color8");
      }
    });
  }

  const swiper = new Swiper(".testimonial-swiper", {
    //loop:true,
    slidesPerView: 1,
    spaceBetween: 20,
    centeredSlides: true,
    initialSlide: 0,
    breakpoints: {
          640: {
            slidesPerView: 1.5,
            spaceBetween: 20,
          },
          1024: {
            slidesPerView: 2.5,
            spaceBetween: 50,
          },
        },
    spaceBetween: 20,
    navigation: {
      nextEl: ".testimonial-next",
      prevEl: ".testimonial-prev",
    },
    on: {
      init: function () {
        this.update(); 
        createPagination(this);
        updatePagination(this.realIndex);
      },
      slideChange: function () {
        updatePagination(this.realIndex);
      },
    },
  });
   }

   
const paginationContainerHero = document.querySelector(".hero-pagination");

 if (paginationContainerHero) {   

  function createPaginationHero(swiper) {
    paginationContainerHero.innerHTML = "";
    for (let i = 0; i < swiper.slides.length; i++) {
      const dot = document.createElement("span");
      dot.className = "hero-dot w-3 h-2 bg-color8 rounded-[3.125rem] transition-all duration-300";
      paginationContainerHero.appendChild(dot);
    }
  }

  function updatePaginationHero(activeIndex) {
    const dots = paginationContainerHero.querySelectorAll(".hero-dot");
    dots.forEach((dot, i) => {
      if (i === activeIndex) {
        dot.classList.remove("w-3", "bg-color8");
        dot.classList.add("w-12","bg-primary", "lg:bg-white");
      } else {
        dot.classList.remove("w-12", "bg-primary", "lg:bg-white");
        dot.classList.add("w-3", "bg-color8");
      }
    });
  }
const heroSlider = new Swiper('.hero-slider', {
  loop: false,
  navigation: {
    nextEl: '.hero-next',
    prevEl: '.hero-prev',
  },
  autoplay: {
      delay: 10000, 
      disableOnInteraction: false,
    },
 // autoHeight: true,
  on: {
    init: function () {
        this.update(); 
        createPaginationHero(this);
        updatePaginationHero(this.realIndex);
      },
      slideChange: function () {
        updatePaginationHero(this.realIndex);
      },
  }
});
function equalizeSlideHeights() {
  const slides = document.querySelectorAll('.hero-slider .swiper-slide');
  let maxHeight = 0;
  // Resetear alturas
    slides.forEach(slide => {
      slide.style.height = 'auto';
    });   
                // Calcular la altura máxima
                slides.forEach(slide => {
                    const slideHeight = slide.offsetHeight;
                    if (slideHeight > maxHeight) {
                        maxHeight = slideHeight;
                    }
                });

                 const screenWidth = window.innerWidth;

  if (screenWidth < 768) {
    const maxMobileHeight = 680; 
    if (maxHeight > maxMobileHeight) maxHeight = maxMobileHeight;
  }
                
                // Aplicar la altura máxima a todos los slides
                slides.forEach(slide => {
                    slide.style.height = maxHeight + 'px';
                });
                
                // Actualizar el swiper
                heroSlider.update();
            }
            
            // Ejecutar al inicio
            equalizeSlideHeights();
            
            // Optimización: Detección de cambios de orientación y tamaño
            let resizeTimeout;
            function handleResize() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    equalizeSlideHeights();
                }, 250);
            }
            
            // Event listeners para redimensionamiento y cambio de orientación
            window.addEventListener('resize', handleResize);
            window.addEventListener('orientationchange', function() {
                // Pequeño retraso para permitir que el navegador complete el cambio de orientación
                setTimeout(equalizeSlideHeights, 350);
            });
            
            // También actualizar cuando cambia el slide
            heroSlider.on('slideChangeTransitionEnd', equalizeSlideHeights);
            
             window.addEventListener('load', () => {
                equalizeSlideHeights();
              });
               }
           
  // ---------- TRIPS SLIDER ----------
  const tripsEl = document.querySelector('.trips-slider');
  if (tripsEl) {
    new Swiper('.trips-slider', {
      slidesPerView: 1.5,      
      spaceBetween: 16,
      loop: false,
      pagination: false,
      navigation: false,
      breakpoints: {
        1024: {              
          slidesPerView: 5,   
          spaceBetween: 24,
          allowTouchMove: false 
        }
      }
    });
  }
});

