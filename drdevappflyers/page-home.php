<?php
/**
 * Template Name: Home
 * Template Post Type: page
 *
 * This is the template that displays all pages by default. Please note that
 * this is the WordPress construct of pages: specifically, posts with a post
 * type of `page`.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

get_header(); ?>

<main class="flex flex-col gap-12 lg:gap-24 w-full">

    <?php 
    
        get_template_part('template-parts/home/heroHome');
        get_template_part('template-parts/home/services');
        get_template_part('template-parts/home/cardWidthText');
        get_template_part('template-parts/home/shipping');
        get_template_part('template-parts/home/imageWithText');
        get_template_part('template-parts/commons/ContactFormwithOffice'); 
        if( function_exists('render_faq_group') ) {
            render_faq_group('general', 'Preguntas frecuentes');
        }
        get_template_part('template-parts/commons/testimonies');

    ?>
    
</main>

<?php get_footer(); ?>