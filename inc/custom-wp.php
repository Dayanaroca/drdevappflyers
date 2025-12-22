<?php
if (!defined('ABSPATH')) exit;

/**
 * Create Content Creator role
 */
function drdev_add_content_creator_role() {
    if (!get_role('content_creator')) {
        add_role(
            'content_creator',
            'Content Creator',
            array(
                'read' => true,
                'upload_files' => true,
            )
        );
    }
}
add_action('init', 'drdev_add_content_creator_role');

/**
 * Asignar capacidades al rol Content Creator y al Administrador
 */
function drdev_assign_cpt_capabilities() {
    $roles = ['administrator', 'content_creator'];
    $cpts  = ['tourist-product', 'brand-management'];

    foreach ($roles as $role_name) {
        $role = get_role($role_name);
        if (!$role) continue;

        // Capacidades mínimas core
        $role->add_cap('edit_posts');
        $role->add_cap('publish_posts');

        // Capacidades para CPTs
        foreach ($cpts as $cpt) {
            $role->add_cap("edit_{$cpt}s");
            $role->add_cap("edit_others_{$cpt}s");
            $role->add_cap("edit_published_{$cpt}s");
            $role->add_cap("publish_{$cpt}s");
            $role->add_cap("delete_{$cpt}s");
            $role->add_cap("delete_others_{$cpt}s");
            $role->add_cap("delete_published_{$cpt}s");
        }

        // Capacidades WPML
        $role->add_cap('translate');
        $role->add_cap('manage_translations');
        $role->add_cap('wpml_manage_translate_tourist_products');
        $role->add_cap('wpml_manage_translate_brand_managements');

        // Solo Administrador obtiene control completo WPML
        if ($role_name === 'administrator') {
            $role->add_cap('wpml_manage_string_translation');
            $role->add_cap('wpml_manage_translation_management');
            $role->add_cap('wpml_manage_languages');
            $role->add_cap('wpml_manage_translation_analytics');
            $role->add_cap('wpml_manage_theme_and_plugin_localization');
            $role->add_cap('wpml_manage_woocommerce_translation');
            $role->add_cap('wpml_manage_media_translation');
            $role->add_cap('wpml_manage_navigation');
            $role->add_cap('wpml_manage_sticky_links');
            $role->add_cap('wpml_manage_translation_services');
            $role->add_cap('wpml_manage_troubleshooting');
            $role->add_cap('wpml_manage_translation_options');
        }
    }
}
add_action('init', 'drdev_assign_cpt_capabilities', 12);

/**
 * Ocultar menús innecesarios para Content Creator
 */
function drdev_hide_menus_for_content_creator() {
    if (!current_user_can('content_creator')) return;

    // Menús laterales
    remove_menu_page('index.php');          // Dashboard
    remove_menu_page('edit.php');           // Posts
    remove_menu_page('edit-comments.php');  // Comments
    remove_menu_page('tools.php');          // Tools
    remove_menu_page('plugins.php');        // Plugins
    remove_menu_page('users.php');          // Users
    remove_menu_page('options-general.php');// Settings
    remove_menu_page('profile.php');        // Profile

    // Admin bar
    add_action('admin_bar_menu', function($wp_admin_bar) {
        $wp_admin_bar->remove_node('view-site');
        $wp_admin_bar->remove_node('menu-toggle');
    }, 999);
}
add_action('admin_menu', 'drdev_hide_menus_for_content_creator', 999);

/**
 * Reordenar menú para Content Creator
 */
function drdev_reorder_admin_menu($menu_order) {
    if (!current_user_can('content_creator')) return $menu_order;

    return [
        'edit.php?post_type=tourist-product',
        'edit.php?post_type=brand-management',
        'upload.php',
        'separator1',
    ];
}
add_filter('menu_order', 'drdev_reorder_admin_menu');
add_filter('custom_menu_order', '__return_true');

/**
 * Mostrar botón duplicar solo si el rol puede editar el CPT
 */
function drdev_add_duplicate_button($actions, $post) {
    $allowed_types = ['tourist-product', 'brand-management'];
    
    if (in_array($post->post_type, $allowed_types)) {
        $cap = "edit_{$post->post_type}s";
        if (current_user_can($cap)) {
            $actions['duplicate'] = '<a href="' . wp_nonce_url(admin_url('admin-ajax.php?action=duplicate_post&post=' . $post->ID), 'duplicate_' . $post->ID) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
        }
    }

    return $actions;
}
add_filter('post_row_actions', 'drdev_add_duplicate_button', 10, 2);
/**
 * Remove "View" button from the list of posts
 */
function drdev_remove_button_view_list($actions, $post) {
    $post_types = ['tourist-product', 'brand-management'];
    
    if (in_array($post->post_type, $post_types)) {
        unset($actions['view']);
        unset($actions['preview']);
    }
    return $actions;
}
add_filter('post_row_actions', 'drdev_remove_button_view_list', 10, 2);
/**
 * Remove "View Page" button from post editor
 */
function drdev_remove_button_view_editor() {
    $post_types = ['tourist-product', 'brand-management'];
    $current_screen = get_current_screen();
    
    if ($current_screen && in_array($current_screen->post_type, $post_types)) {
        echo '<style>
            .wp-admin #post-preview, 
            .wp-admin #view-post-btn, 
            .edit-post-header__preview {
                display: none !important;
            }
        </style>';
    }
}
add_action('admin_head', 'drdev_remove_button_view_editor');
/**
 * Remove the "Publish" metabox that contains the View button
 */
function drdev_remover_metabox_view() {
    $post_types = ['tourist-product', 'brand-management'];
    
    foreach ($post_types as $post_type) {
        remove_meta_box('submitdiv', $post_type, 'side');
    }
}
add_action('admin_menu', 'drdev_remover_metabox_view');

/**
 * Add custom metabox to replace the default "Publish" metabox
 */
function drdev_add_custom_metabox() {
    $post_types = ['tourist-product', 'brand-management'];
    
    foreach ($post_types as $post_type) {
        add_meta_box(
            'custom_publish',
            'Publish',
            'drdev_adisplay_custom_metabox',
            $post_type,
            'side',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'drdev_add_custom_metabox');

function drdev_adisplay_custom_metabox($post) {
    // Determinar si puede publicar este CPT
    $can_publish = current_user_can('publish_' . $post->post_type . 's');
    ?>
    <div class="submitbox" id="submitpost">
        <div id="major-publishing-actions">
            <div id="publishing-action">
                <span class="spinner"></span>
                <?php
                if ($can_publish) :
                    if (!in_array($post->post_status, ['publish', 'future', 'private']) || 0 == $post->ID) :
                        ?>
                        <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Publish') ?>" />
                        <?php submit_button(__('Publish'), 'primary large', 'publish', false); ?>
                    <?php
                    else :
                        ?>
                        <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Update') ?>" />
                        <input name="save" type="submit" class="button button-primary button-large" id="publish" value="<?php esc_attr_e('Update') ?>" />
                    <?php
                    endif;
                endif;
                ?>
            </div>
            <div class="clear"></div>
            <?php if ( $post->post_type === 'tourist-product' ) { ?>
                <div class="misc-pub-section">
                    <div style="margin: 10px 0; text-align: center;">
                        <a href="<?php echo admin_url('admin-post.php?action=preview_flyer_pdf&id=' . $post->ID); ?>" target="_blank" class="button" style="margin-bottom: 5px; width: 100%; text-align: center;">
                            📄 Visualizar PDF
                        </a>
                        <a href="<?php echo admin_url('admin-post.php?action=export_flyer_pdf&id=' . $post->ID); ?>" class="button button-primary" style="width: 100%; text-align: center;">
                            💾 Exportar PDF
                        </a>
                    </div>
                </div>
            <?php } ?>              
        </div>
    </div>
    <?php
}

/** 
 * Function to duplicate posts
 */
function drdev_duplicate_post($post_id) {
    // if (!current_user_can('edit_posts')) {
    //     return;
    // }
    
    $post = get_post($post_id);
    $allowed_types = ['tourist-product', 'brand-management'];
    
    if (!$post || !in_array($post->post_type, $allowed_types)) {
        return;
    }
    
    $new_post = array(
        'post_title' => $post->post_title . ' (Copy)',
        'post_content' => $post->post_content,
        'post_status' => 'draft',
        'post_type' => $post->post_type,
        'post_author' => get_current_user_id(),
    );
    
    $new_post_id = wp_insert_post($new_post);
    
    $meta_fields = get_post_meta($post_id);
    foreach ($meta_fields as $key => $values) {
        foreach ($values as $value) {
            add_post_meta($new_post_id, $key, maybe_unserialize($value));
        }
    }
    $thumbnail_id = get_post_thumbnail_id($post_id);
    if ($thumbnail_id) {
        set_post_thumbnail($new_post_id, $thumbnail_id);
    }
    
    return $new_post_id;
}
/**
 * Handle AJAX request for duplicating post
 */
function drdev_handle_duplicate_ajax() {
    if (!wp_verify_nonce($_GET['_wpnonce'], 'duplicate_' . $_GET['post'])) {
        wp_die('Security check failed');
    }
    
    $new_post_id = drdev_duplicate_post($_GET['post']);
    
    if ($new_post_id) {
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
        exit;
    } else {
        wp_die('Error duplicating post');
    }
}
add_action('wp_ajax_duplicate_post', 'drdev_handle_duplicate_ajax');
/**
 * Custom login logo
 */
function drdev_custom_login_logo() {
    ?>
    <style type="text/css">
        body.login h1 a {
            background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png');
            width: 320px;
            height: 80px;
            background-size: contain;
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'drdev_custom_login_logo');
/**
 * Remove logo from panel admin bar
 */
// Quitar logo de WordPress y añadir logo personalizado
function drdev_custom_admin_bar_logo($wp_admin_bar) {

    // 1. Quitamos el logo de WordPress
    $wp_admin_bar->remove_node('wp-logo');

    // 2. Añadimos nuestro logo
    $custom_logo_url = get_stylesheet_directory_uri() . '/assets/images/logo.png';

    $wp_admin_bar->add_node([
        'id'    => 'custom-logo',
        'title' => '<img src="' . esc_url($custom_logo_url) . '" style="height:20px; margin-top:5px;">',
        'href'  => admin_url(), // o tu URL personalizada
        'meta'  => [
            'class' => 'custom-admin-logo'
        ]
    ]);
}
add_action('admin_bar_menu', 'drdev_custom_admin_bar_logo', 11);
function drdev_custom_admin_logo_css() {
    echo '
    <style>
        #wp-admin-bar-custom-logo > .ab-item img {
            height: 20px !important;
            width: auto !important;
            display: block;
        }
    </style>';
}
add_action('admin_head', 'drdev_custom_admin_logo_css');
add_action('admin_bar_menu', 'drdev_custom_admin_logo_css');

/**
 * Change admin menu and bar colors
 */
function drdev_custom_admin_colors() {
    echo '<style>

        /* =======================
           MENÚ LATERAL (DEGRADADO)
        ======================== */
        #adminmenu, 
        #adminmenu .wp-submenu, 
        #adminmenuback, 
        #adminmenuwrap {
            background: linear-gradient(180deg, #2271b1 0%, #2271b1 100%) !important;
        }

        /* Texto e iconos del menú */
        #adminmenu a {
            color: #ffffff !important;
        }
        #adminmenu div.wp-menu-image:before {
            color: #ffffff !important;
        }
        /* =======================
           ADMIN BAR (TOP)
        ======================== */
        #wpadminbar {
            background: linear-gradient(180deg, #2271b1 0%, #2271b1 100%) !important;
        }
        #wpadminbar .ab-item, #wpadminbar a.ab-item {
            color: #fff !important;
        }

    </style>';
}
add_action('admin_head', 'drdev_custom_admin_colors');
/**
 * WPML for CPTs
 */ 
function drdev_configure_wpml_for_cpts() {
    if (!function_exists('icl_register_string')) {
        return;
    }

    $cpts_traducibles = [
        'tourist-product' => 'Tourist Product',
        'brand-management' => 'Brand Management'
    ];
    
    foreach ($cpts_traducibles as $cpt => $label) {
        add_filter("wpml_is_translated_post_type", function($is_translated, $post_type) use ($cpt) {
            if ($post_type === $cpt) {
                return true;
            }
            return $is_translated;
        }, 10, 2);
    }
}
add_action('init', 'drdev_configure_wpml_for_cpts');
/**
 * translation options for WPML
 */
function drdev_configure_wpml_options() {
    if (!function_exists('icl_register_string')) {
        return;
    }
    $wpml_settings = get_option('icl_sitepress_settings');
    
    if ($wpml_settings) {
        $wpml_settings['custom_posts_sync_option']['tourist-product'] = 1; 
        $wpml_settings['custom_posts_sync_option']['brand-management'] = 1; 
        
        update_option('icl_sitepress_settings', $wpml_settings);
    }
}
add_action('admin_init', 'drdev_configure_wpml_options');
/**
 * Assign full WPML capabilities
 */ 
function drdev_assign_full_wpml_capabilities() {
    $roles = ['administrator', 'content_creator'];    
    foreach ($roles as $role_name) {
        $role = get_role($role_name);
        if ($role) {
            $role->add_cap('translate');
            $role->add_cap('manage_translations');
            $role->add_cap('wpml_manage_translate_tourist_products');
            $role->add_cap('wpml_manage_translate_brand_managements');
            
            if ($role_name == 'administrator') {
                $role->add_cap('wpml_manage_string_translation');
                $role->add_cap('wpml_manage_translation_management');
                $role->add_cap('wpml_manage_languages');
                $role->add_cap('wpml_manage_translation_analytics');
                $role->add_cap('wpml_manage_theme_and_plugin_localization');
                $role->add_cap('wpml_manage_woocommerce_translation');
                $role->add_cap('wpml_manage_media_translation');
                $role->add_cap('wpml_manage_navigation');
                $role->add_cap('wpml_manage_sticky_links');
                $role->add_cap('wpml_manage_translation_services');
                $role->add_cap('wpml_manage_troubleshooting');
                $role->add_cap('wpml_manage_translation_options');
            }
        }
    }
}
add_action('init', 'drdev_assign_full_wpml_capabilities');

function lighten_color($hex, $percent) {
    $hex = str_replace('#', '', $hex);

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = min(255, $r + ($r * $percent / 100));
    $g = min(255, $g + ($g * $percent / 100));
    $b = min(255, $b + ($b * $percent / 100));

    return sprintf('#%02x%02x%02x', $r, $g, $b);
}
/**
 * Custom rol
 */
function drdev_fix_content_creator_caps() {
    $role = get_role('content_creator');
    if (!$role) return;

    // Quitar todo lo relacionado a Entradas del core
    $role->remove_cap('edit_posts');
    $role->remove_cap('edit_others_posts');
    $role->remove_cap('publish_posts');
    $role->remove_cap('delete_posts');

    // Quitar acceso a Comentarios
    $role->remove_cap('moderate_comments');
    $role->remove_cap('edit_comment');
    $role->remove_cap('edit_comments');

    // Quitar acceso a páginas
    $role->remove_cap('edit_pages');
    $role->remove_cap('edit_others_pages');
    $role->remove_cap('publish_pages');
    $role->remove_cap('delete_pages');
}
add_action('init', 'drdev_fix_content_creator_caps', 12);