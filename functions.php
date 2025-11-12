<?php 
if (!defined('ABSPATH')) exit;

require get_template_directory() . '/inc/custom-post-type.php';
require get_template_directory() . '/inc/custom-pdf.php';
require get_template_directory() . '/inc/custom-fields.php';
require get_template_directory() . '/inc/custom-language.php'; 

// --- Función para convertir ID de imagen a Base64 ---
function image_id_to_base64($id) {
    if (!$id) return '';
    $path = get_attached_file($id);
    if (!file_exists($path)) return '';
    $type = mime_content_type($path);
    $data = file_get_contents($path);
    return 'data:' . $type . ';base64,' . base64_encode($data);
}

/**
 * Convierte un attachment ID, una ruta de archivo local o una URL del theme a data URI válido.
 * Devuelve '' si no puede convertir.
 *
 * @param int|string $source Attachment ID | filesystem path | URL
 * @return string|false 'data:<mime>;base64,...' o '' en caso de error
 */
function file_or_url_to_data_uri($source) {
    // Si es un ID de attachment
    if (is_numeric($source) && intval($source) > 0) {
        $path = get_attached_file(intval($source));
        if (!$path || !file_exists($path)) return '';
    } else {
        // Si viene una URL del tema (http(s)://.../wp-content/...)
        // intentamos mapear URL -> ruta absoluta.
        $src = (string) $source;

        // Si ya es una ruta local (no contiene esquema)
        if (strpos($src, '://') === false && file_exists($src)) {
            $path = $src;
        } else {
            // Tiene esquema http/https -> intentar convertir URL a ruta en servidor
            $home = trailingslashit( home_url() );
            $stylesheet_uri = trailingslashit( get_stylesheet_directory_uri() );
            $stylesheet_dir = trailingslashit( get_stylesheet_directory() );

            // Reemplazar la URL del theme por la ruta física del theme
            if (strpos($src, $stylesheet_uri) === 0) {
                $path = $stylesheet_dir . substr($src, strlen($stylesheet_uri));
            } else {
                // como fallback intentar reemplazar home_url() por ABSPATH
                $home_url = trailingslashit( home_url() );
                if (strpos($src, $home_url) === 0) {
                    $relative = substr($src, strlen($home_url));
                    $path = ABSPATH . $relative;
                } else {
                    // No podemos resolver a file path local — devolver URL si Dompdf isRemoteEnabled true
                    // En ese caso devolvemos la misma URL (no data URI): Dompdf podrá cargarlo si está permitido.
                    return $src;
                }
            }
        }

        if (!isset($path) || !file_exists($path)) {
            return '';
        }
    }

    // Tenemos $path local; obtener mime y data
    $mime = mime_content_type($path) ?: 'application/octet-stream';
    $data = file_get_contents($path);
    if ($data === false) return '';
    return 'data:' . $mime . ';base64,' . base64_encode($data);
}


function calculate_available_height($post_id, $template_selected) {
    $base_heights_mm = [
        1 => 55,
        2 => 71,
        3 => 87
    ];
    $header_height_mm = ($base_heights_mm[$template_selected] ?? 55) * 0.9; // usa 90% del header

    $description = get_post_meta($post_id, 'description', true);
    $desc_text_length = mb_strlen(strip_tags($description));
    $desc_lines = ceil($desc_text_length / 80);
    $desc_height_mm = $desc_lines * 4;

    $margins_mm = 6; // menor margen
    $page_height_mm = 279;

    $available_height_mm = $page_height_mm - $header_height_mm - $margins_mm;
    $available_height_px = $available_height_mm * 3.78;

    // +15% de holgura para aprovechar más la página
    $available_height_px *= 1.21;

    // error_log("=== CALCULATING AVAILABLE HEIGHT ===");
    // error_log("Template: {$template_selected}, Header: {$header_height_mm}mm");
    // error_log("Description: {$desc_text_length} chars = {$desc_lines} lines = {$desc_height_mm}mm");
    // error_log("Available: {$available_height_mm}mm ({$available_height_px}px)");

    return max(50 * 3.78, $available_height_px);
}



function split_tables_by_available_height($html, $available_height_px) {
    if (trim($html) === '') return ['', ''];

    // Capturar todas las tablas del HTML (cada día del itinerario)
    preg_match_all('/(<table\b[^>]*>.*?<\/table>)/is', $html, $matches);
    $tables = $matches[0];
    if (empty($tables)) return [$html, '']; // no hay tablas

    $part1 = '';
    $part2 = '';
    $used_height = 0;

    foreach ($tables as $idx => $table_html) {
        $text = strip_tags($table_html);
        $len = mb_strlen($text);
        $approx_lines = ceil($len / 80);
        $table_height = ($approx_lines * 11) + 40; // estimación realista

        // Si aún cabe o es la primera
        if (($used_height + $table_height) <= $available_height_px || $used_height === 0) {
            $part1 .= $table_html;
            $used_height += $table_height;
        } else {
            $part2 .= $table_html;
        }
    }

    // Si part2 quedó vacía, todo va en la primera
    if (trim($part2) === '') {
        return [$html, ''];
    }

    return [trim($part1), trim($part2)];
}



function calculate_html_height($html) {
    if (trim($html) === '') return 0;
    
    $total_height_px = 0;
    preg_match_all('/(<table[^>]*>.*?<\/table>)/is', $html, $tables);
    
    foreach ($tables[0] as $table) {
        $text_content = strip_tags($table);
        $text_length = mb_strlen($text_content);
        $approx_lines = ceil($text_length / 70);
        $table_height_px = ($approx_lines * 12) + 20;
        $total_height_px += $table_height_px;
    }
    
    return $total_height_px;
}

function fine_tune_itinerary_split($part1, $part2, $available_height_px) {
    // Si part2 está vacío, no hay nada que ajustar
    if (empty(trim($part2))) {
        return [$part1, $part2];
    }
    
    preg_match_all('/(<table[^>]*>.*?<\/table>)/is', $part1, $tables1);
    preg_match_all('/(<table[^>]*>.*?<\/table>)/is', $part2, $tables2);
    
    $days_part1 = count($tables1[0]);
    $days_part2 = count($tables2[0]);
    
    // Solo hacer ajustes si tenemos días en ambas partes
    if ($days_part1 > 0 && $days_part2 > 0) {
        $current_used_height_px = calculate_html_height($part1);
        
        // Caso 1: Si part1 está muy vacía (< 60% usado) y part2 tiene contenido
        if ($current_used_height_px < ($available_height_px * 0.8)) {

            $first_table_from_part2 = $tables2[0][0];
            $first_table_height_px = calculate_html_height($first_table_from_part2);
            
            // Si cabe en el espacio disponible
            if (($current_used_height_px + $first_table_height_px) <= $available_height_px) {
                // Mover el primer día de part2 a part1
                $new_part1 = $part1 . $first_table_from_part2;
                $new_part2 = implode('', array_slice($tables2[0], 1));
                
                error_log("✓ Fine-tune: Moved 1 day from part2 to part1");
                return [trim($new_part1), trim($new_part2)];
            }
        }
        
        // Caso 2: Si part1 está muy llena (> 95% usado) y tiene más de 1 día
        if ($current_used_height_px > ($available_height_px * 0.95) && $days_part1 > 1) {
            $last_table_from_part1 = end($tables1[0]);
            $last_table_height_px = calculate_html_height($last_table_from_part1);
            
            // Si al quitar el último día, part1 sigue teniendo contenido suficiente (> 40%)
            if (($current_used_height_px - $last_table_height_px) > ($available_height_px * 0.4)) {
                // Quitar el último día de part1 y ponerlo al inicio de part2
                $new_part1 = implode('', array_slice($tables1[0], 0, -1));
                $new_part2 = $last_table_from_part1 . $part2;
                
                error_log("✓ Fine-tune: Moved 1 day from part1 to part2");
                return [trim($new_part1), trim($new_part2)];
            }
        }
    }
    
    return [$part1, $part2];
}
/**
 * 
 */
// Crear rol Content Creator
function add_custom_user_role() {
    remove_role('content_creator');
    
    add_role(
        'content_creator',
        'Content Creator',
        array(
            'read' => true,
            'upload_files' => true,
            'translate' => true,
            'manage_translations' => true,
        )
    );
}
add_action('init', 'add_custom_user_role');

// Asignar capacidades para ambos CPTs
function asignar_capacidades_completas() {
    // Capacidades para Admin
    $admin_role = get_role('administrator');
    if ($admin_role) {
        // Tourist Product
        $admin_role->add_cap('edit_tourist_products');
        $admin_role->add_cap('edit_others_tourist_products');
        $admin_role->add_cap('edit_published_tourist_products');
        $admin_role->add_cap('publish_tourist_products');
        $admin_role->add_cap('delete_tourist_products');
        $admin_role->add_cap('delete_others_tourist_products');
        $admin_role->add_cap('delete_published_tourist_products');
        
        // Brand Management
        $admin_role->add_cap('edit_brand_managements');
        $admin_role->add_cap('edit_others_brand_managements');
        $admin_role->add_cap('edit_published_brand_managements');
        $admin_role->add_cap('publish_brand_managements');
        $admin_role->add_cap('delete_brand_managements');
        $admin_role->add_cap('delete_others_brand_managements');
        $admin_role->add_cap('delete_published_brand_managements');
    }
    
    // Capacidades para Content Creator
    $creator_role = get_role('content_creator');
    if ($creator_role) {
        // Tourist Product
        $creator_role->add_cap('edit_tourist_products');
        $creator_role->add_cap('edit_others_tourist_products');
        $creator_role->add_cap('edit_published_tourist_products');
        $creator_role->add_cap('publish_tourist_products');
        $creator_role->add_cap('delete_tourist_products');
        $creator_role->add_cap('delete_others_tourist_products');
        $creator_role->add_cap('delete_published_tourist_products');
        
        // Brand Management
        $creator_role->add_cap('edit_brand_managements');
        $creator_role->add_cap('edit_others_brand_managements');
        $creator_role->add_cap('edit_published_brand_managements');
        $creator_role->add_cap('publish_brand_managements');
        $creator_role->add_cap('delete_brand_managements');
        $creator_role->add_cap('delete_others_brand_managements');
        $creator_role->add_cap('delete_published_brand_managements');
        
        // Capacidades para WPML
        $creator_role->add_cap('translate');
        $creator_role->add_cap('wpml_manage_translate_tourist_products');
        $creator_role->add_cap('wpml_manage_translate_brand_managements');
    }
}
add_action('init', 'asignar_capacidades_completas');

// Remover botón "View" de la lista de posts
function remover_boton_view_lista($actions, $post) {
    $post_types = ['tourist-product', 'brand-management'];
    
    if (in_array($post->post_type, $post_types)) {
        unset($actions['view']);
        unset($actions['preview']);
    }
    return $actions;
}
add_filter('post_row_actions', 'remover_boton_view_lista', 10, 2);

// Remover botón "View Page" del editor de posts
function remover_boton_view_editor() {
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
add_action('admin_head', 'remover_boton_view_editor');

// Remover el metabox "Publish" que contiene el botón View
function remover_metabox_view() {
    $post_types = ['tourist-product', 'brand-management'];
    
    foreach ($post_types as $post_type) {
        remove_meta_box('submitdiv', $post_type, 'side');
    }
}
add_action('admin_menu', 'remover_metabox_view');

// Agregar metabox personalizado sin botón View
function agregar_metabox_personalizado() {
    $post_types = ['tourist-product', 'brand-management'];
    
    foreach ($post_types as $post_type) {
        add_meta_box(
            'custom_publish',
            'Publish',
            'mostrar_metabox_personalizado',
            $post_type,
            'side',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'agregar_metabox_personalizado');

function mostrar_metabox_personalizado($post) {
    $can_publish = current_user_can('publish_posts');
    ?>
    <div class="submitbox" id="submitpost">
        <div id="major-publishing-actions">
            <div id="publishing-action">
                <span class="spinner"></span>
                <?php
                if (!in_array($post->post_status, array('publish', 'future', 'private')) || 0 == $post->ID) {
                    if ($can_publish) :
                        ?>
                        <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Publish') ?>" />
                        <?php submit_button(__('Publish'), 'primary large', 'publish', false); ?>
                        <?php
                    endif;
                } else {
                    ?>
                    <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Update') ?>" />
                    <input name="save" type="submit" class="button button-primary button-large" id="publish" value="<?php esc_attr_e('Update') ?>" />
                    <?php
                }
                ?>
            </div>
            <div class="clear"></div>
        </div>
        
        <!-- Sección de botones PDF -->
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
        
        <!-- Información del estado -->
        <div class="misc-pub-section misc-pub-post-status">
            <?php _e('Status:'); ?> 
            <span id="post-status-display">
            <?php
            switch ($post->post_status) {
                case 'private':
                    _e('Privately Published');
                    break;
                case 'publish':
                    _e('Published');
                    break;
                case 'future':
                    _e('Scheduled');
                    break;
                case 'pending':
                    _e('Pending Review');
                    break;
                case 'draft':
                case 'auto-draft':
                    _e('Draft');
                    break;
            }
            ?>
            </span>
        </div>
        
        <!-- Fecha de publicación -->
        <?php if ('publish' == $post->post_status || 'future' == $post->post_status || 'private' == $post->post_status) : ?>
        <div class="misc-pub-section curtime">
            <span id="timestamp">
                <?php printf(__('Published on: <b>%1$s</b>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date))); ?>
            </span>
        </div>
        <?php endif; ?>
        
    </div>
    <?php
}
// Función para duplicar posts
function duplicar_post($post_id) {
    if (!current_user_can('edit_posts')) {
        return;
    }
    
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
    
    // Duplicar meta fields
    $meta_fields = get_post_meta($post_id);
    foreach ($meta_fields as $key => $values) {
        foreach ($values as $value) {
            add_post_meta($new_post_id, $key, maybe_unserialize($value));
        }
    }
    
    // Duplicar thumbnail
    $thumbnail_id = get_post_thumbnail_id($post_id);
    if ($thumbnail_id) {
        set_post_thumbnail($new_post_id, $thumbnail_id);
    }
    
    return $new_post_id;
}

// Agregar botón de duplicado
function agregar_boton_duplicar($actions, $post) {
    $allowed_types = ['tourist-product', 'brand-management'];
    
    if (in_array($post->post_type, $allowed_types) && current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url(admin_url('admin-ajax.php?action=duplicate_post&post=' . $post->ID), 'duplicate_' . $post->ID) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'agregar_boton_duplicar', 10, 2);

// Manejar duplicado via AJAX
function manejar_duplicado_ajax() {
    if (!wp_verify_nonce($_GET['_wpnonce'], 'duplicate_' . $_GET['post'])) {
        wp_die('Security check failed');
    }
    
    $new_post_id = duplicar_post($_GET['post']);
    
    if ($new_post_id) {
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
        exit;
    } else {
        wp_die('Error duplicating post');
    }
}
add_action('wp_ajax_duplicate_post', 'manejar_duplicado_ajax');
// Ocultar menús para Content Creator
function ocultar_menus_para_content_creator() {
    if(current_user_can('content_creator')) {
        remove_menu_page('edit.php');                    // Posts
        remove_menu_page('edit-comments.php');           // Comentarios
        remove_menu_page('tools.php');                   // Herramientas
        
        // También puedes ocultar más elementos si es necesario
        remove_menu_page('plugins.php');                 // Plugins
        remove_menu_page('users.php');                   // Users
        remove_menu_page('options-general.php');         // Settings
    }
}
add_action('admin_menu', 'ocultar_menus_para_content_creator', 999);

// Reorganizar menú para que los CPTs sean principales
function reordenar_menu_admin($menu_order) {
    if(current_user_can('content_creator')) {
        $menu_order = array(
            'edit.php?post_type=tourist-product',    // Tourist Products primero
            'edit.php?post_type=brand-management',   // Brand Management segundo
            'upload.php',                            // Media
            'separator1',
        );
    }
    return $menu_order;
}
add_filter('menu_order', 'reordenar_menu_admin');
add_filter('custom_menu_order', '__return_true');

// Configurar WPML para los CPTs
function configurar_wpml_para_cpts() {
    // Solo ejecutar si WPML está activo
    if (!function_exists('icl_register_string')) {
        return;
    }
    
    // Hacer que los CPTs sean traducibles
    $cpts_traducibles = [
        'tourist-product' => 'Tourist Product',
        'brand-management' => 'Brand Management'
    ];
    
    foreach ($cpts_traducibles as $cpt => $label) {
        // Registrar el CPT como traducible
        add_filter("wpml_is_translated_post_type", function($is_translated, $post_type) use ($cpt) {
            if ($post_type === $cpt) {
                return true;
            }
            return $is_translated;
        }, 10, 2);
    }
}
add_action('init', 'configurar_wpml_para_cpts');

// Configurar opciones de traducción para WPML
function configurar_wpml_opciones() {
    if (!function_exists('icl_register_string')) {
        return;
    }
    
    // Obtener configuración actual de WPML
    $wpml_settings = get_option('icl_sitepress_settings');
    
    if ($wpml_settings) {
        // Asegurar que nuestros CPTs estén configurados como traducibles
        $wpml_settings['custom_posts_sync_option']['tourist-product'] = 1; // Traducible
        $wpml_settings['custom_posts_sync_option']['brand-management'] = 1; // Traducible
        
        update_option('icl_sitepress_settings', $wpml_settings);
    }
}
add_action('admin_init', 'configurar_wpml_opciones');

// Asignar capacidades WPML completas
function asignar_capacidades_wpml_completas() {
    $roles = ['administrator', 'content_creator'];
    
    foreach ($roles as $role_name) {
        $role = get_role($role_name);
        if ($role) {
            // Capacidades básicas de traducción
            $role->add_cap('translate');
            $role->add_cap('manage_translations');
            
            // Capacidades específicas para cada CPT
            $role->add_cap('wpml_manage_translate_tourist_products');
            $role->add_cap('wpml_manage_translate_brand_managements');
            
            // Para administradores, capacidades adicionales de gestión
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
add_action('init', 'asignar_capacidades_wpml_completas');