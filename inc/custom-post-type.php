<?php
if (!defined('ABSPATH')) exit;

// --------------------------------------------------------------------
// CPT Registration
// --------------------------------------------------------------------
function register_tourist_product_post_type() {
    $labels = array(
        'name'                  => 'Flyers',
        'singular_name'         => 'Flyer',
        'menu_name'             => 'Flyers',
        'name_admin_bar'        => 'Flyer',
        'add_new'               => 'Añadir Flyer',
        'add_new_item'          => 'Añadir nuevo Flyer',
        'edit_item'             => 'Editar Flyer',
        'new_item'              => 'Nuevo Flyer',
        'view_item'             => 'Ver Flyer',
        'search_items'          => 'Buscar Flyers',
        'not_found'             => 'No se encontraron flyers',
        'not_found_in_trash'    => 'No hay flyers en la papelera',
        'all_items'             => 'Todos los Flyers',
        'archives'              => 'Archivo de Flyers',
        'attributes'            => 'Atributos del Flyer',
    );
    register_post_type('tourist-product', [
        'label' => 'Flyers',
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'exclude_from_search' => true,
        'supports' => ['title', 'thumbnail'],
        'capability_type' => 'tourist_product',
        'capabilities' => array(
            'edit_post' => 'edit_tourist_product',
            'edit_posts' => 'edit_tourist_products',
            'edit_others_posts' => 'edit_others_tourist_products',
            'edit_published_posts' => 'edit_published_tourist_products',
            'publish_posts' => 'publish_tourist_products',
            'delete_post' => 'delete_tourist_product',
            'delete_posts' => 'delete_tourist_products',
            'delete_others_posts' => 'delete_others_tourist_products',
            'delete_published_posts' => 'delete_published_tourist_products',
        ),
        'map_meta_cap' => true,
        'has_archive' => false,
        'rewrite' => false,
    ]);
}
add_action('init', 'register_tourist_product_post_type');
function register_brand_management_post_type() {
    $labels = array(
        'name'                  => 'Marcas',
        'singular_name'         => 'Marca',
        'menu_name'             => 'Marcas',
        'name_admin_bar'        => 'Marca',
        'add_new'               => 'Añadir Marca',
        'add_new_item'          => 'Añadir nueva Marca',
        'edit_item'             => 'Editar Marca',
        'new_item'              => 'Nueva Marca',
        'view_item'             => 'Ver Marca',
        'search_items'          => 'Buscar Marcas',
        'not_found'             => 'No se encontraron marcas',
        'not_found_in_trash'    => 'No hay marcas en la papelera',
        'all_items'             => 'Todas las Marcas',
        'archives'              => 'Archivo de Marcas',
        'attributes'            => 'Atributos de la Marca',
    );
    register_post_type('brand-management', [
        'label' => 'Marcas',
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'exclude_from_search' => true,
        'supports' => ['title', 'thumbnail'],
        'capability_type' => 'brand_management',
        'capabilities' => array(
            'edit_post' => 'edit_brand_management',
            'edit_posts' => 'edit_brand_managements',
            'edit_others_posts' => 'edit_others_brand_managements',
            'edit_published_posts' => 'edit_published_brand_managements',
            'publish_posts' => 'publish_brand_managements',
            'delete_post' => 'delete_brand_management',
            'delete_posts' => 'delete_brand_managements',
            'delete_others_posts' => 'delete_others_brand_managements',
            'delete_published_posts' => 'delete_published_brand_managements',
        ),
        'map_meta_cap' => true,
        'has_archive' => false,
        'rewrite' => false,
    ]);
}
add_action('init', 'register_brand_management_post_type');
// --------------------------------------------------------------------
// Remove the "Publish and View Change" button
// --------------------------------------------------------------------
add_action('admin_head-post.php', function() {
  $screen = get_current_screen();
  if ($screen->post_type === 'tourist-product') {
   // echo '<style>#publish {display:none !important;}</style>';
    echo '<style>#post-preview {display:none !important;}</style>';
  }
  if ($screen->post_type === 'brand-management') {
    echo '<style>#post-preview {display:none !important;}</style>';
  }
});
// --------------------------------------------------------------------
// Add sections
// --------------------------------------------------------------------
add_action('add_meta_boxes', function() {
    add_meta_box(
        'manual_template_selector',
        'Template Selector',
        'render_manual_selectors',
        'tourist-product',
        'normal',
        'high'
    );
});