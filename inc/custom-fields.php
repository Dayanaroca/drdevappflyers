<?php
if (!defined('ABSPATH')) exit;

function render_manual_selectors($post) {
    $selected_brand        = get_post_meta($post->ID, '_brand_selected', true);
    $selected_template     = get_post_meta($post->ID, '_template_selected', true);
    $selected_template_back= get_post_meta($post->ID, '_template_selected_back', true);
    $selected_footer_back  = get_post_meta($post->ID, '_template_footer_back', true);

    wp_nonce_field('manual_selectors_nonce', '_manual_selectors_nonce');
    $errors = isset($_GET['manual_error']) ? explode(',', $_GET['manual_error']) : [];
    // --------------------------------------------------------------------
    // Brand
    // --------------------------------------------------------------------
    $post_lang = apply_filters('wpml_post_language_details', NULL, $post->ID);
    $lang_code = $post_lang['language_code']; // ejemplo: 'es', 'en', 'de', etc.

    $brands = get_posts([
        'post_type'      => 'brand-management',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
        'lang'           => $lang_code, 
		'suppress_filters' => false
    ]);
	
    echo '<h4>'.esc_html__('Seleccione la marca','drdevcustomlanguage').' <span style="color:red;">*</span></h4>';
    if(in_array('brand', $errors)) {
        echo '<p style="background: #ffe6e6; border-color: #d12626; color: #cc2727; border-left: 3px solid #d12626; padding: 6px 12px; position: relative">Por favor seleccione una marca. Este campo es obligatorio.</p>';
    }
    echo '<select name="_brand_selected" style="width: 100%;">';
    echo '<option value="">Seleccione una marca</option>';
    foreach ($brands as $brand) {
        $selected = ($selected_brand == $brand->ID) ? 'selected' : '';
        echo '<option value="' . $brand->ID . '" ' . $selected . '>' . $brand->post_title . '</option>';
    }
    echo '</select>';
    // --------------------------------------------------------------------
    // Tarj contact
    // --------------------------------------------------------------------

    $selected_contact_card = get_post_meta($post->ID, '_contact_card_selected', true);

    echo '<h4>Seleccione la tarjeta de contacto <span style="color:red;">*</span></h4>';

    if (in_array('contact_card', $errors)) {
        echo '<p style="background:#ffe6e6;border-color:#d12626;color:#cc2727;
                border-left:3px solid #d12626;padding:6px 12px;position:relative">
                Por favor seleccione una tarjeta. Este campo es obligatorio.
            </p>';
    }

    // Select vacío: se llenará con AJAX
    echo '<select id="contact-card-select" name="_contact_card_selected" style="width:100%;">';
    echo '<option value="">Seleccione una marca primero</option>';
    echo '</select>';

    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const brandSelect = document.querySelector("select[name='_brand_selected']");
        const contactSelect = document.getElementById("contact-card-select");

        function loadContactCards(brandId, selectedCard = "") {
            const data = new FormData();
            data.append('action', 'load_contact_cards');
            data.append('brand_id', brandId);
            data.append('selected_card', selectedCard);

            fetch(ajaxurl, { method: "POST", body: data })
                .then(r => r.text())
                .then(html => {
                    contactSelect.innerHTML = html;
                });
        }

        // Si ya hay una marca seleccionada, cargar tarjetas al abrir el post
        <?php if (!empty($selected_brand)) : ?>
            loadContactCards("<?= $selected_brand ?>", "<?= $selected_contact_card ?>");
        <?php endif; ?>

        // Cuando cambia la marca
        brandSelect.addEventListener("change", function() {
            if (this.value) {
                loadContactCards(this.value, "");
            } else {
                contactSelect.innerHTML = '<option value="">Seleccione una marca primero</option>';
            }
        });
    });
    </script>
    <?php


    // --------------------------------------------------------------------
    // Front template
    // --------------------------------------------------------------------
    $templates = [
        ['id'=>'1','name'=>'Plantilla 1','image'=>get_stylesheet_directory_uri().'/assets/images/header_1.png'],
        ['id'=>'2','name'=>'Plantilla 2','image'=>get_stylesheet_directory_uri().'/assets/images/header_2.png'],
        ['id'=>'3','name'=>'Plantilla 3','image'=>get_stylesheet_directory_uri().'/assets/images/header_3.png'],
    ];

    echo '<h4>'.esc_html__('Seleccione la plantilla para la primera página','drdevcustomlanguage').' <span style="color:red;">*</span></h4>';
    if(in_array('template_front', $errors)) {
        echo '<p style="background: #ffe6e6; border-color: #d12626; color: #cc2727; border-left: 3px solid #d12626; padding: 6px 12px; position: relative">Por favor seleccione una plantilla. Este campo es obligatorio.</p>';
    }
    echo '<div style="display: flex; gap: 20px; margin-bottom: 20px;">';
    foreach ($templates as $tpl) {
        $checked = ($selected_template == $tpl['id']) ? 'checked' : '';
        echo '<label style="display: flex; flex-direction: column; align-items: center; text-align: center;">';
        echo '<img src="' . esc_url($tpl['image']) . '" alt="' . esc_attr($tpl['name']) . '" style="max-width: 150px; height: auto; border: 2px solid #ccc; margin-bottom: 5px;">';
        echo '<span>' . esc_html($tpl['name']) . '</span>';
        echo '<input type="radio" name="_template_selected" value="' . esc_attr($tpl['id']) . '" ' . $checked . ' style="margin-top: 5px;">';
        echo '</label>';
    }
    echo '</div>';
    // --------------------------------------------------------------------
    // Back template
    // --------------------------------------------------------------------
    $templates_back = [
        ['id'=>'4','name'=>'Sin imagen','image'=>get_stylesheet_directory_uri().'/assets/images/not_image.png'],
        ['id'=>'5','name'=>'Con imagen en header','image'=>get_stylesheet_directory_uri().'/assets/images/header_image.png'],
        ['id'=>'6','name'=>'Con imagen lateral','image'=>get_stylesheet_directory_uri().'/assets/images/side_image.png'],
    ];

    echo '<h4>'.esc_html__('Seleccione la plantilla para la segunda página','drdevcustomlanguage').' <span style="color:red;">*</span></h4>';
    if(in_array('template_back', $errors)) {
        echo '<p style="background: #ffe6e6; border-color: #d12626; color: #cc2727; border-left: 3px solid #d12626; padding: 6px 12px; position: relative;">Por favor seleccione una plantilla. Este campo es obligatorio.</p>';
    }
    echo '<div style="display: flex; gap: 20px; margin-bottom: 20px;">';
    foreach ($templates_back as $tpl_back) {
        $checked_back = ($selected_template_back == $tpl_back['id']) ? 'checked' : '';
        echo '<label style="display: flex; flex-direction: column; align-items: center; text-align: center;">';
        echo '<img src="' . esc_url($tpl_back['image']) . '" alt="' . esc_attr($tpl_back['name']) . '" style="max-width: 150px; height: auto; border: 2px solid #ccc; margin-bottom: 5px;">';
        echo '<span>' . esc_html($tpl_back['name']) . '</span>';
        echo '<input type="radio" name="_template_selected_back" value="' . esc_attr($tpl_back['id']) . '" ' . $checked_back . ' style="margin-top: 5px;">';
        echo '</label>';
    }
    echo '</div>';
    // --------------------------------------------------------------------
    // Footer Back end
    // --------------------------------------------------------------------
    $footer_back = [
        ['id'=>'7','name'=>'Simple','image'=>get_stylesheet_directory_uri().'/assets/images/footer_1.png'],
        ['id'=>'8','name'=>'Con datos de empresa','image'=>get_stylesheet_directory_uri().'/assets/images/footer_2.png'],
        ['id'=>'9','name'=>'Con información adicional','image'=>get_stylesheet_directory_uri().'/assets/images/footer_3.png'],
    ];

    echo '<h4>'.esc_html__('Seleccione la plantilla para el pie de página','drdevcustomlanguage').' <span style="color:red;">*</span></h4>';
    if(in_array('footer_back', $errors)) {
        echo '<p style="background: #ffe6e6; border-color: #d12626; color: #cc2727; border-left: 3px solid #d12626; padding: 6px 12px; position: relative;">Por favor seleccione un pie de página. Este campo es obligatorio.</p>';
    }
    echo '<p class="description">Se muestra solo en la la segunda página</p>';
    echo '<div style="display: flex; gap: 20px; margin-bottom: 20px;">';
    foreach ($footer_back as $tpl_footer_back) {
        $checked_footer_back = ($selected_footer_back == $tpl_footer_back['id']) ? 'checked' : '';
        echo '<label style="display: flex; flex-direction: column; align-items: center; text-align: center;">';
        echo '<img src="' . esc_url($tpl_footer_back['image']) . '" alt="' . esc_attr($tpl_footer_back['name']) . '" style="max-width: 150px; height: auto; border: 2px solid #ccc; margin-bottom: 5px;">';
        echo '<span>' . esc_html($tpl_footer_back['name']) . '</span>';
        echo '<input type="radio" name="_template_footer_back" value="' . esc_attr($tpl_footer_back['id']) . '" ' . $checked_footer_back . ' style="margin-top: 5px;">';
        echo '</label>';
    }
    echo '</div>';
}

add_action('save_post_tourist-product', function($post_id) {
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(!current_user_can('edit_post', $post_id)) return;
    if(wp_is_post_revision($post_id)) return;

    if(!isset($_POST['_manual_selectors_nonce']) || !wp_verify_nonce($_POST['_manual_selectors_nonce'], 'manual_selectors_nonce')) return;

    $errors = [];

    // --- Save template front ---
    if(empty($_POST['_template_selected'])) $errors[] = 'template_front';
    else update_post_meta($post_id, '_template_selected', sanitize_text_field($_POST['_template_selected']));

    // --- Save template back ---
    if(empty($_POST['_template_selected_back'])) $errors[] = 'template_back';
    else update_post_meta($post_id, '_template_selected_back', sanitize_text_field($_POST['_template_selected_back']));

    // --- Save footer back ---
    if(empty($_POST['_template_footer_back'])) $errors[] = 'footer_back';
    else update_post_meta($post_id, '_template_footer_back', sanitize_text_field($_POST['_template_footer_back']));

    // --- Save brand ---
    if(empty($_POST['_brand_selected'])) $errors[] = 'brand';
    else update_post_meta($post_id, '_brand_selected', intval($_POST['_brand_selected']));

    if(!empty($errors)) {
        add_filter('redirect_post_location', function($location) use ($errors){
            return add_query_arg('manual_error', implode(',', $errors), $location);
        });
    }

   // --- Save contact card ---
    if (!isset($_POST['_contact_card_selected']) || $_POST['_contact_card_selected'] === '') {
        $errors[] = 'contact_card';
    } else {
        update_post_meta($post_id, '_contact_card_selected', sanitize_text_field($_POST['_contact_card_selected']));
    }


});

add_action('wp_ajax_load_contact_cards', function() {

    if (empty($_POST['brand_id'])) {
        echo '<option value="">Seleccione una marca</option>';
        wp_die();
    }

    $brand_id = intval($_POST['brand_id']);
    $selected = isset($_POST['selected_card']) ? sanitize_text_field($_POST['selected_card']) : '';

    if (have_rows('tarjeta_de_contacto', $brand_id)) {
        $index = 0;
        echo '<option value="">Seleccione una tarjeta</option>';

        while (have_rows('tarjeta_de_contacto', $brand_id)) {
            the_row();
            $nombre = get_sub_field('nombre_de_contacto');

            echo '<option value="' . esc_attr($index) . '" ' . selected($selected, $index, false) . '>' .
                esc_html($nombre) .
            '</option>';

            $index++;
        }

    } else {
        echo '<option value="">No hay tarjetas para esta marca</option>';
    }

    wp_die();
});

function drdev_register_custom_fields_for_wpml() {

    $fields = [
        '_brand_selected',
        '_template_selected',
        '_template_selected_back',
        '_template_footer_back',
        '_contact_card_selected',
    ];

    foreach ($fields as $field) {
        register_meta('post', $field, [
            'type'              => 'string',
            'single'            => true,
            'show_in_rest'      => false,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function() { return current_user_can('edit_posts'); }
        ]);
    }
}
add_action('init', 'drdev_register_custom_fields_for_wpml');
