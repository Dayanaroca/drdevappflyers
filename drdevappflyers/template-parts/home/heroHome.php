<?php
/**
 * Template part for displaying the hero home content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
  global $drdev_global;
  ?>
  <style>
    html, body {
    overflow-x: hidden;
  }
  </style>
<section aria-label="Hero principal con promociones" class="relative w-full h-full max-w-screen-xl mx-auto overflow-visible px-2.5 lg:px-0">
  <div class="flex flex-col gap-6 items-center absolute bottom-32 lg:bottom-14 right-0 w-1/5">
                <span class="h-7 lg:h-10 bg-primary w-[100vw]"></span>
                <span class="h-7 lg:h-10 bg-primary w-[100vw]"></span>
                <span class="h-7 lg:h-10 bg-primary w-[100vw] "></span>
            </div>
  <!-- Slider Container -->
  <div class="swiper hero-slider h-full relative">
    <div class="swiper-wrapper">
      <!-- Slide 1  -->
      <div class="swiper-slide relative " role="group" aria-label="Slide 1 de 3">
          <!-- Redes sociales fuera del max-w -->
          <div class="hidden lg:flex flex-col gap-4 items-center absolute right-6 top-6 z-[150]">
            <a href="<?php echo esc_attr($drdev_global['facebook']); ?>" target="_blank" aria-label="Facebook" class="transition-transform hover:scale-110">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/logo-fb.svg" alt="" class="w-8 h-8">
            </a>
            <a href="<?php echo esc_attr($drdev_global['instagram']); ?>" target="_blank" aria-label="Instagram" class="transition-transform hover:scale-110">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/logo-instagram.svg" alt="" class="w-8 h-8">
            </a>
            <a href="<?php echo esc_attr($drdev_global['tiktok']); ?>" target="_blank" aria-label="WhatsApp" class="transition-transform hover:scale-110">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/logo-tiktok.svg" alt="" class="w-8 h-8">
            </a>
          </div>
              <div class="flex flex-col gap-6 items-center absolute bottom-14 right-0 w-1/5">
                <span class="h-7 lg:h-10 bg-primary w-[40rem] lg:w-[1400px] rounded-[0.3125rem_0_0_6.25rem] z-10"></span>
                <span class="h-7 lg:h-10 bg-primary w-[34rem] lg:w-[1000px] rounded-[0.3125rem_0_0_6.25rem] z-30 lg:z-10"></span>
                <span class="h-7 lg:h-10 bg-primary w-[18rem] lg:w-[670px] rounded-[0.3125rem_0_0_6.25rem] z-30"></span>
            </div>

          <div class="relative flex flex-col lg:flex-row gap-0 bg-secondary mx-auto mb-20 lg:mb-10 w-full h-full rounded-[2.5rem_2.5rem_14.25rem_2.5rem] pt-6 lg:pt-0 overflow-hidden">
              <img
                src="<?php echo get_template_directory_uri(); ?>/assets/images/home/caja.webp"
                alt="Caja con logo"
                class="absolute bottom-0 lg:left-1/2 lg:-translate-x-1/2 w-[60%] lg:w-[30%] h-auto mx-auto mb-0 z-40 lg:z-20"
              />
             <div class="z-10 flex flex-col text-center lg:text-left justify-end lg:justify-center gap-2 lg:gap-4 px-4 lg:pl-16 lg:pr-0 w-full lg:w-[60%]">
                <h1 class="text-white text-4xl lg:text-4rem font-light uppercase">
                    <strong class="font-semibold">Envíos a Cuba</strong> desde $1.45/lb Vía marítima
                </h1>
                <p class="text-lg lg:text-2xl font-normal text-white">
                   Envíos confiables, transparentes y llenos de emoción. Porque la distancia no es barrera para compartir lo que importa.
                </p>
                <?php echo drdev_link('btn-whiteV2 w-full lg:w-fit mt-4', 'Realizar Envío', '#contactForm', 'Ir al Formulario de contacto'); ?>
                <div class="h-0 lg:h-12"></div>
              </div>
              <div class="w-full lg:w-[40%] flex items-end justify-end h-full overflow-hidden">
              <img
                src="<?php echo get_template_directory_uri(); ?>/assets/images/home/chica-con-caja.webp"
                alt="Chico entregando caja"
                class="w-[80%] lg:w-full h-auto mx-auto mb-0 z-20"
              />
          </div>
          </div>
      </div>

      <!-- Slide 2  -->
      <div class="swiper-slide relative" role="group" aria-label="Slide 2 de 3">
            <div class="flex flex-col gap-6 items-center absolute bottom-14 right-0 w-1/5">
                <span class="h-7 lg:h-10 bg-primary w-[38rem] lg:w-[1400px] rounded-[0.3125rem_0_0_6.25rem] z-30"></span>
                <span class="h-7 lg:h-10 bg-primary w-[32rem] lg:w-[1000px] rounded-[0.3125rem_0_0_6.25rem] z-10"></span>
                <span class="h-7 lg:h-10 bg-primary w-[16rem] lg:w-[600px] rounded-[0.3125rem_0_0_6.25rem] z-10"></span>
            </div>
            <img
                  src="<?php echo get_template_directory_uri(); ?>/assets/images/home/image-slid2-mobile.webp"
                  alt="Chico entregando caja"
                  class="absolute bottom-0 right-0 -translate-y-24 block lg:hidden h-2/5 w-[85%] mb-0 z-20"
                />
            <div class="absolute bottom-[47%] left-0 w-full px-4 z-30 lg:hidden">
              <?php echo drdev_link('btn-primary w-full', 'Contáctenos', '#contactForm', 'Ir al Formulario de contacto'); ?>
            </div>

          <div class="relative flex flex-col lg:flex-row gap-0 bg-slider-home2 mx-auto mb-20 lg:mb-10 w-full h-full rounded-[2.5rem_2.5rem_14.25rem_2.5rem] pt-6 lg:pt-0 overflow-hidden">

             <div class="z-10 flex flex-col text-center lg:text-left justify-center gap-0 px-4 lg:pl-16 lg:pr-0 w-full lg:w-auto">
                <h2 class="text-white text-2rem lg:text-[4.5rem] mb-0 lg:mb-4 font-semibold uppercase">
                    Paraíso Express </br>
                </h2>
                <p class="text-white font-light text-2xl lg:text-5xl uppercase">Agencia de envíos a Cuba</p>

                <div class="grid grid-cols-2 gap-3 my-6 lg:flex lg:flex-row">
                    <div class="flex flex-row items-center bg-white py-2 px-4 rounded-[6.25rem] shadow-[0_0_2px_0_rgba(0,0,0,0.25)] gap-2 order-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <mask id="mask0_4059_501" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                          <rect width="24" height="24" fill="#D9D9D9"/>
                        </mask>
                        <g mask="url(#mask0_4059_501)">
                          <path d="M10.95 15.55L16.6 9.9L15.175 8.475L10.95 12.7L8.85 10.6L7.425 12.025L10.95 15.55ZM12 22C9.68333 21.4167 7.77083 20.0875 6.2625 18.0125C4.75417 15.9375 4 13.6333 4 11.1V5L12 2L20 5V11.1C20 13.6333 19.2458 15.9375 17.7375 18.0125C16.2292 20.0875 14.3167 21.4167 12 22Z" fill="#EE2737"/>
                        </g>
                      </svg>
                      <p class="text-sm lg:text-base font-bold text-primary">
                        Envío seguro
                      </p>
                    </div>
                    <div class="flex flex-row items-center bg-white py-2 px-4 rounded-[6.25rem] shadow-[0_0_2px_0_rgba(0,0,0,0.25)] gap-2 order-3 col-span-2 lg:col-span-1 lg:order-2 w-fit mx-auto lg:w-auto lg:mx-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <mask id="mask0_4059_502" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                            <rect width="24" height="24" fill="#D9D9D9"/>
                          </mask>
                          <g mask="url(#mask0_4059_502)">
                            <path d="M11 21V19H19V11.9C19 9.95 18.3208 8.29583 16.9625 6.9375C15.6042 5.57917 13.95 4.9 12 4.9C10.05 4.9 8.39583 5.57917 7.0375 6.9375C5.67917 8.29583 5 9.95 5 11.9V18H4C3.45 18 2.97917 17.8042 2.5875 17.4125C2.19583 17.0208 2 16.55 2 16V14C2 13.65 2.0875 13.3208 2.2625 13.0125C2.4375 12.7042 2.68333 12.4583 3 12.275L3.075 10.95C3.20833 9.81667 3.5375 8.76667 4.0625 7.8C4.5875 6.83333 5.24583 5.99167 6.0375 5.275C6.82917 4.55833 7.7375 4 8.7625 3.6C9.7875 3.2 10.8667 3 12 3C13.1333 3 14.2083 3.2 15.225 3.6C16.2417 4 17.15 4.55417 17.95 5.2625C18.75 5.97083 19.4083 6.80833 19.925 7.775C20.4417 8.74167 20.775 9.79167 20.925 10.925L21 12.225C21.3167 12.375 21.5625 12.6 21.7375 12.9C21.9125 13.2 22 13.5167 22 13.85V16.15C22 16.4833 21.9125 16.8 21.7375 17.1C21.5625 17.4 21.3167 17.625 21 17.775V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H11ZM9 14C8.71667 14 8.47917 13.9042 8.2875 13.7125C8.09583 13.5208 8 13.2833 8 13C8 12.7167 8.09583 12.4792 8.2875 12.2875C8.47917 12.0958 8.71667 12 9 12C9.28333 12 9.52083 12.0958 9.7125 12.2875C9.90417 12.4792 10 12.7167 10 13C10 13.2833 9.90417 13.5208 9.7125 13.7125C9.52083 13.9042 9.28333 14 9 14ZM15 14C14.7167 14 14.4792 13.9042 14.2875 13.7125C14.0958 13.5208 14 13.2833 14 13C14 12.7167 14.0958 12.4792 14.2875 12.2875C14.4792 12.0958 14.7167 12 15 12C15.2833 12 15.5208 12.0958 15.7125 12.2875C15.9042 12.4792 16 12.7167 16 13C16 13.2833 15.9042 13.5208 15.7125 13.7125C15.5208 13.9042 15.2833 14 15 14ZM6.025 12.45C5.90833 10.6833 6.44167 9.16667 7.625 7.9C8.80833 6.63333 10.2833 6 12.05 6C13.5333 6 14.8375 6.47083 15.9625 7.4125C17.0875 8.35417 17.7667 9.55833 18 11.025C16.4833 11.0083 15.0875 10.6 13.8125 9.8C12.5375 9 11.5583 7.91667 10.875 6.55C10.6083 7.88333 10.0458 9.07083 9.1875 10.1125C8.32917 11.1542 7.275 11.9333 6.025 12.45Z" fill="#EE2737"/>
                          </g>
                        </svg>
                      <p class="text-sm lg:text-base font-bold text-primary">
                        Atención personalizada
                      </p>
                    </div>
                    <div class="flex flex-row items-center bg-white py-2 px-4 rounded-[6.25rem] shadow-[0_0_2px_0_rgba(0,0,0,0.25)] gap-2 order-2 lg:order-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <mask id="mask0_4059_506" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                            <rect width="24" height="24" fill="#D9D9D9"/>
                          </mask>
                          <g mask="url(#mask0_4059_506)">
                            <path d="M11 21.725V12.575L3 7.95V15.975C3 16.3417 3.0875 16.675 3.2625 16.975C3.4375 17.275 3.68333 17.5167 4 17.7L11 21.725ZM13 21.725L20 17.7C20.3167 17.5167 20.5625 17.275 20.7375 16.975C20.9125 16.675 21 16.3417 21 15.975V7.95L13 12.575V21.725ZM16.975 7.975L19.925 6.25L13 2.275C12.6833 2.09167 12.35 2 12 2C11.65 2 11.3167 2.09167 11 2.275L9.025 3.4L16.975 7.975ZM12 10.85L14.975 9.15L7.05 4.55L4.05 6.275L12 10.85Z" fill="#EE2737"/>
                          </g>
</svg>
                      <p class="text-sm lg:text-base font-bold text-primary">
                        Mínimo 10 lbs.
                      </p>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 mb-6 px-4 lg:px-0">
                    <div class="border-l-2 border-l-secondary pl-3">
                      <p class="text-white text-xl font-normal text-left">
                        <span class="font-semibold uppercase">Aéreo</span>: $1.85/lb | 14-16 días
                      </p>
                    </div>
                     <div class="border-l-2 border-l-secondary pl-3">
                      <p class="text-white text-xl font-normal text-left">
                        <span class="font-semibold uppercase">Marítimo</span>: $1.45/lb | 35-40 días
                      </p>
                    </div>
                </div>

                <!-- <div class="w-full lg:inline-flex mt-4 "> -->
                    <?php echo drdev_link('btn-primary hidden lg:block w-fit mt-4 z-30', 'Contáctenos', '#contactForm', 'Ir al Formulario de contacto'); ?>
                <!-- </div> -->
              </div>
              <div class="w-full lg:flex-1 flex items-end justify-start h-full overflow-hidden">
                <img
                  src="<?php echo get_template_directory_uri(); ?>/assets/images/home/image-slid2.webp"
                  alt="Chico entregando caja"
                  class="hidden lg:block w-full h-full mx-auto mb-0 z-20"
                />
            </div>
          </div>
      </div>

      <!-- Slide 3-->
      <div class="swiper-slide relative" role="group" aria-label="Slide 2 de 3">
         <!-- Redes sociales fuera del max-w -->
          <div class="hidden lg:flex flex-col gap-4 items-center absolute right-6 top-6 z-[150]">
            <a href="<?php echo esc_attr($drdev_global['facebook']); ?>" target="_blank" aria-label="Facebook" class="transition-transform hover:scale-110">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/logo-fb.svg" alt="" class="w-8 h-8">
            </a>
            <a href="<?php echo esc_attr($drdev_global['instagram']); ?>" target="_blank" aria-label="Instagram" class="transition-transform hover:scale-110">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/logo-instagram.svg" alt="" class="w-8 h-8">
            </a>
          </div>
          <div class="flex flex-col gap-6 items-center absolute bottom-14 right-0 w-1/5">
                <span class="h-7 lg:h-10 bg-primary w-[38rem] lg:w-[1400px] rounded-[0.3125rem_0_0_6.25rem] z-10"></span>
                <span class="h-7 lg:h-10 bg-primary w-[32rem] lg:w-[1000px] rounded-[0.3125rem_0_0_6.25rem] z-30"></span>
                <span class="h-7 lg:h-10 bg-primary lg:bg-transparent w-[16rem] lg:w-[800px] rounded-[0.3125rem_0_0_6.25rem] z-30"></span>
            </div>

          <div class="relative flex flex-col lg:flex-row gap-0 bg-slider-home3 mx-auto mb-20 lg:mb-10 w-full h-full rounded-[2.5rem_2.5rem_14.25rem_2.5rem] pt-6 lg:pt-0 overflow-hidden">

             <div class="z-10 flex flex-col text-center lg:text-left justify-center gap-0 px-4 lg:pl-16 lg:pr-0 w-full lg:w-auto">
                <h2 class="text-white text-2rem lg:text-[4.5rem] mb-0 lg:mb-4 font-semibold uppercase">
                    Ofertas especiales
                </h2>
                <div class="flex flex-row gap-8 items-left lg:items-center mx-auto">
                  <p class="text-white font-light text-2xl lg:text-5xl uppercase text-center lg:text-left">para tu envío a Cuba</p>
                   <div class="hidden lg:flex flex-row bg-white py-2 px-4 rounded-[6.25rem] shadow-[0_0_2px_0_rgba(0,0,0,0.25)] gap-2 order-2 lg:order-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <mask id="mask0_4059_506" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                            <rect width="24" height="24" fill="#D9D9D9"/>
                          </mask>
                          <g mask="url(#mask0_4059_506)">
                            <path d="M11 21.725V12.575L3 7.95V15.975C3 16.3417 3.0875 16.675 3.2625 16.975C3.4375 17.275 3.68333 17.5167 4 17.7L11 21.725ZM13 21.725L20 17.7C20.3167 17.5167 20.5625 17.275 20.7375 16.975C20.9125 16.675 21 16.3417 21 15.975V7.95L13 12.575V21.725ZM16.975 7.975L19.925 6.25L13 2.275C12.6833 2.09167 12.35 2 12 2C11.65 2 11.3167 2.09167 11 2.275L9.025 3.4L16.975 7.975ZM12 10.85L14.975 9.15L7.05 4.55L4.05 6.275L12 10.85Z" fill="#EE2737"/>
                          </g>
                        </svg>
                      <p class="text-sm lg:text-base font-bold text-primary">
                        Mínimo 10 lbs.
                      </p>
                    </div>
                </div>

                <p class="text-white font-semibold text-base lg:text-2xl mt-4 lg:mt-8 mb-2">
                  Con Paraíso Express, no solo envías... ¡compartes alegría!
                </p>

                <div class="flex flex-col lg:flex-row gap-4 mb-6 px-4 lg:px-0">
                      <p class="text-white text-xl lg:text-2xl font-normal text-center lg:text-left">
                        Tiempos de entrega:
                      </p>
                      <div class="flex flex-row justify-center  lg:justify-start gap-2 lg:gap-0">
                      <div class="border-l-2 border-l-white pl-3 flex flex-row gap-2 lg:gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                          <mask id="mask0_4067_612" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32" height="32">
                            <rect width="32" height="32" fill="#D9D9D9"/>
                          </mask>
                          <g mask="url(#mask0_4067_612)">
                            <path d="M13.2322 28.1668L9.93216 22.0335L3.79883 18.7335L6.16549 16.4002L10.9988 17.2335L14.3988 13.8335L3.83216 9.3335L6.63216 6.46683L19.4655 8.7335L23.5988 4.60016C24.1099 4.08905 24.7433 3.8335 25.4988 3.8335C26.2544 3.8335 26.8877 4.08905 27.3988 4.60016C27.9099 5.11127 28.1655 5.73905 28.1655 6.4835C28.1655 7.22794 27.9099 7.85572 27.3988 8.36683L23.2322 12.5335L25.4988 25.3335L22.6655 28.1668L18.1322 17.6002L14.7322 21.0002L15.5988 25.8002L13.2322 28.1668Z" fill="white"/>
                          </g>
                        </svg>
                        <p class="text-white text-xl lg:text-2xl font-normal text-left pr-0 lg:pr-3">
                          14-16 días
                        </p>
                      </div>
                      <div class="border-l-2 border-l-white pl-3 flex flex-row gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                          <mask id="mask0_4067_615" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32" height="32">
                            <rect width="32" height="32" fill="#D9D9D9"/>
                          </mask>
                          <g mask="url(#mask0_4067_615)">
                            <path d="M5.06723 29.3332H4.00056V26.6665H5.06723C6.13389 26.6665 7.15056 26.5498 8.11723 26.3165C9.08389 26.0832 10.1672 25.7109 11.3672 25.1998C12.2117 25.6221 12.9506 25.9721 13.5839 26.2498C14.2172 26.5276 15.0228 26.6665 16.0006 26.6665C16.9783 26.6665 17.7839 26.5276 18.4172 26.2498C19.0506 25.9721 19.7894 25.6221 20.6339 25.1998C21.8117 25.7109 22.895 26.0832 23.8839 26.3165C24.8728 26.5498 25.9006 26.6665 26.9672 26.6665H28.0006V29.3332H26.9672C25.8783 29.3332 24.8172 29.2332 23.7839 29.0332C22.7506 28.8332 21.7339 28.5332 20.7339 28.1332C19.845 28.5554 19.0339 28.8554 18.3006 29.0332C17.5672 29.2109 16.8006 29.2998 16.0006 29.2998C15.2006 29.2998 14.4395 29.2109 13.7172 29.0332C12.995 28.8554 12.1895 28.5554 11.3006 28.1332C10.3006 28.5332 9.28389 28.8332 8.25056 29.0332C7.21723 29.2332 6.15612 29.3332 5.06723 29.3332ZM16.0006 23.9998C14.6672 23.9998 13.5006 23.5554 12.5006 22.6665L11.0006 21.3332C10.4006 21.9332 9.72834 22.4443 8.98389 22.8665C8.23945 23.2887 7.44501 23.5887 6.60056 23.7665L3.76723 14.6665C3.65612 14.2887 3.68945 13.9443 3.86723 13.6332C4.04501 13.3221 4.32278 13.1109 4.70056 12.9998L6.66723 12.4665V7.99984C6.66723 7.2665 6.92834 6.63873 7.45056 6.1165C7.97278 5.59428 8.60056 5.33317 9.33389 5.33317H12.6672V2.6665H19.3339V5.33317H22.6672C23.4006 5.33317 24.0283 5.59428 24.5506 6.1165C25.0728 6.63873 25.3339 7.2665 25.3339 7.99984V12.4665L27.3006 12.9998C27.6783 13.1109 27.9561 13.3221 28.1339 13.6332C28.3117 13.9443 28.345 14.2887 28.2339 14.6665L25.4006 23.7665C24.5561 23.5887 23.7617 23.2887 23.0172 22.8665C22.2728 22.4443 21.6006 21.9332 21.0006 21.3332L19.5006 22.6665C18.5006 23.5554 17.3339 23.9998 16.0006 23.9998ZM9.33389 11.7665L16.0006 9.99984L22.6672 11.7665V7.99984H9.33389V11.7665Z" fill="white"/>
                          </g>
                        </svg>
                        <p class="text-white text-xl lg:text-2xl font-normal text-left">
                          35-40 días
                        </p>
                      </div>
                      </div>
                </div>

                <div class="w-full lg:inline-flex mt-4 ">
                   <?php
                    $whatsapp_url = 'https://wa.me/' . esc_attr($drdev_global['whatsapp_clean']);
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="35" height="36" viewBox="0 0 35 36" fill="none">
                      <path d="M17.0456 0.988281H16.9681C7.59688 0.988281 0 8.5874 0 17.9614V18.0389C0 27.4128 7.59688 35.012 16.9681 35.012H17.0456C26.4168 35.012 34.0137 27.4128 34.0137 18.0389V17.9614C34.0137 8.5874 26.4168 0.988281 17.0456 0.988281Z" fill="#00E510"/>
                      <path d="M20.3217 22.9763C15.9686 22.9763 12.427 19.4325 12.4258 15.0781C12.427 13.9742 13.3255 13.0767 14.4266 13.0767C14.5398 13.0767 14.6518 13.0862 14.7591 13.1053C14.995 13.1446 15.219 13.2245 15.4252 13.3449C15.455 13.3627 15.4753 13.3914 15.48 13.4247L15.94 16.3249C15.946 16.3595 15.9352 16.3928 15.9126 16.4179C15.6588 16.6992 15.3346 16.9018 14.9736 17.0032L14.7996 17.052L14.8651 17.2201C15.4586 18.7316 16.6669 19.9391 18.1791 20.5351L18.3472 20.6018L18.396 20.4278C18.4973 20.0666 18.6999 19.7424 18.9811 19.4885C19.0014 19.4694 19.0288 19.4599 19.0562 19.4599C19.0622 19.4599 19.0681 19.4599 19.0753 19.4611L21.9746 19.9212C22.0091 19.9272 22.0378 19.9462 22.0556 19.976C22.1748 20.1823 22.2546 20.4076 22.2952 20.6436C22.3142 20.7485 22.3226 20.8593 22.3226 20.975C22.3226 22.0776 21.4252 22.9752 20.3217 22.9763Z" fill="#FDFDFD"/>
                      <path d="M28.0407 17.0448C27.8059 14.3914 26.5904 11.9299 24.6182 10.1145C22.6341 8.28829 20.0601 7.28223 17.3681 7.28223C11.4599 7.28223 6.65271 12.0908 6.65271 18.0008C6.65271 19.9843 7.19967 21.9166 8.23523 23.5997L5.92578 28.7135L13.3201 27.9255C14.6059 28.4524 15.9667 28.7194 17.3669 28.7194C17.7352 28.7194 18.1129 28.7003 18.4919 28.661C18.8256 28.6253 19.1628 28.5728 19.4941 28.5061C24.4419 27.506 28.0538 23.1134 28.0824 18.058V18.0008C28.0824 17.679 28.0681 17.3571 28.0395 17.0448H28.0407ZM13.6049 25.681L9.51389 26.1173L10.7353 23.4102L10.4911 23.0824C10.4732 23.0585 10.4553 23.0347 10.435 23.0073C9.37447 21.5423 8.81437 19.8115 8.81437 18.002C8.81437 13.284 12.6515 9.44573 17.3681 9.44573C21.7868 9.44573 25.5322 12.8942 25.8933 17.2963C25.9124 17.5324 25.9231 17.7696 25.9231 18.0032C25.9231 18.07 25.9219 18.1355 25.9207 18.2059C25.8301 22.1526 23.0738 25.5046 19.2176 26.358C18.9233 26.4236 18.6218 26.4737 18.3215 26.5059C18.0093 26.5416 17.6887 26.5595 17.3705 26.5595C16.2373 26.5595 15.1362 26.3402 14.0958 25.9063C13.9802 25.8598 13.867 25.8097 13.761 25.7585L13.6061 25.6834L13.6049 25.681Z" fill="#FDFDFD"/>
                    </svg>';
                    echo drdev_link('btn-white', 'Habla por WhatsApp', $whatsapp_url, 'Ir al Formulario de contacto','', null, $icon );

                    ?>
                </div>
                <div class="h-12"></div>
              </div>
              <div class="w-full lg:flex-1 flex items-end justify-start h-full overflow-hidden">
                <!-- <img
                  src="<?php echo get_template_directory_uri(); ?>/assets/images/home/image-slid3.webp"
                  alt="Chico entregando caja"
                  class="w-full h-full mx-auto mb-0 z-20"
                /> -->
            </div>
          </div>
      </div>

    </div>
    <!-- <div class="absolute left-1/2 lg:left-16 bottom-0 transform  -translate-y-16 flex items-center justify-center gap-8 lg:gap-6 z-20"> -->
      <div class="relative flex justify-center mt-6 lg:absolute lg:left-16 lg:bottom-0 lg:transform lg:-translate-y-16 lg:translate-x-0 gap-8 lg:gap-6 z-30">

      <div class="flex gap-4">
         <button class="hero-prev custom-prev flex items-center justify-center w-12 lg:w-10 h-12 lg:h-10 rounded-full bg-primary lg:bg-white !static !translate-x-0 !translate-y-0">
           <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
              <path d="M26.8474 28.8685L18.996 20.9999L26.8474 13.1314L24.4302 10.7142L14.1445 20.9999L24.4302 31.2856L26.8474 28.8685Z" fill="currentColor"/>
            </svg>
        </button>
         <!-- Indicador barra -->
         <div class="hero-pagination flex items-center gap-2"></div>
        <!-- Next -->
        <button class="hero-next custom-next flex items-center justify-center w-12 lg:w-10 h-12 lg:h-10 rounded-full bg-primary lg:bg-white !static !translate-x-0 !translate-y-0">
          <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
            <path d="M15.1526 28.8685L23.004 20.9999L15.1526 13.1314L17.5698 10.7142L27.8555 20.9999L17.5698 31.2856L15.1526 28.8685Z" fill="currentColor"/>
          </svg>
        </button>

      </div>
    </div>
  </div>
</section>