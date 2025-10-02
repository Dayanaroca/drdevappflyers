<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
  <?php if ( is_production() ) : ?>
   <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-V5HSES7CDB"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-V5HSES7CDB');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TB63FR8X');</script>
    <!-- End Google Tag Manager -->

  <?php endif; ?>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon -->
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" sizes="32x32" />
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" sizes="192x192" />
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" />
  <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" />

  
  <meta name="theme-color" content="#1e40af">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


  <?php wp_head(); ?>
</head>

<body <?php 
    $classes = 'antialiased relative z-0';
    if ( is_page_template('page-trips.php') || is_page_template('page-car.php') || is_page_template('page-hotels.php') ) {
        $classes .= ' bg-color12';
    } else {
        $classes .= ' bg-white';
    }
    body_class($classes); 
?>>

  <?php if ( is_production() ) : ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TB63FR8X"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

  <?php endif; ?>

  <header class="relative z-50 xs:z-1 mx-auto w-full bg-white">
    <?php get_template_part('template-parts/header/content-header'); ?>
  </header>