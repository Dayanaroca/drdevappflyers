<?php
if (!defined('ABSPATH')) exit;

// --------------------------------------------------------------------
// CPT Registration
// --------------------------------------------------------------------
function register_tourist_product_post_type() {
    register_post_type('tourist-product', [
        'label' => 'Tourist Products',
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
    register_post_type('brand-management', [
        'label' => 'Brand Management',
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
// Add PDF button
// --------------------------------------------------------------------
add_action('post_submitbox_misc_actions', function() {
  global $post;
  if ($post->post_type === 'tourist-product') {
    echo '<div class="misc-pub-section">
      <a href="' . admin_url('admin-post.php?action=preview_flyer_pdf&id=' . $post->ID) . '" target="_blank" class="button">Visualizar PDF</a>
      <a href="' . admin_url('admin-post.php?action=export_flyer_pdf&id=' . $post->ID) . '" class="button button-primary">Exportar PDF</a>
    </div>';
  }
});
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