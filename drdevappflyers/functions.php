<?php 

function drdev_enqueue_assets() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', [], '1.0');
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.min.js', [], false, true);
    wp_enqueue_style('intl-tel-input-css', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.min.css',array(),  '18.1.1' );
    wp_enqueue_script( 'intl-tel-input-js', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js', array(), '18.1.1', true);
    wp_enqueue_script('intl-tel-input-utils', 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js', array('intl-tel-input-js'), '18.1.1', true );
    wp_enqueue_style( 'intl-fix', get_template_directory_uri() . '/assets/css/intl-fix.css', array('intl-tel-input-css'), filemtime(get_template_directory() . '/assets/css/intl-fix.css'));
    wp_enqueue_script('drdev-Intl', get_template_directory_uri() . '/assets/js/intelTel.js', [], null, true);
    wp_enqueue_script('drdev-conn-zoho', get_template_directory_uri() . '/assets/js/conn-zoho.js', [], null, true);
    wp_localize_script('drdev-conn-zoho', 'myData', ['countryFile' => get_template_directory_uri() . '/inc/data/country_translation.json']);
    wp_localize_script('drdev-conn-zoho', 'zohoData', ['ajaxUrl' => get_template_directory_uri() . '/inc/zoho-handler.php']);
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(),'11.0.0' );
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );
    wp_enqueue_script('drdev-swiper', get_template_directory_uri() . '/assets/js/drdevSwiper.js', [], null, true);
    wp_enqueue_script('tracking-script', get_template_directory_uri() . '/assets/js/tracking.js', [], null, true);
    wp_localize_script('tracking-script', 'trackingData', ['iconsBase' => get_template_directory_uri() . '/assets/images/icons/']);
     wp_enqueue_script( 'alpinejs', 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', [], null, true );
    //Flatpickr CSS + JS 
    if (is_page_template('page-trips.php') || is_page_template('page-car.php') || is_page_template('page-hotels.php')) {
        wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', array(),'11.0.0' );
        wp_enqueue_script('flatpickr-npm-js', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), '', true );
        wp_enqueue_script('flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js', array(), '', true );
        wp_enqueue_script('drdev-flatpickr', get_template_directory_uri() . '/assets/js/flatpickr.js', [], null, true);
    } 
}
add_action('wp_enqueue_scripts', 'drdev_enqueue_assets');

//scripts admin
function enqueue_admin_scripts($hook) {
    global $post_type;

    // Only admin
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        if ($post_type === 'shipping') {
            // Media uploader
            wp_enqueue_media();

            wp_enqueue_script('drdev-admin-js', get_template_directory_uri() . '/assets/js/admin/admin-scripts.js', array('jquery'), '1.0', true );
        }
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');


add_action('wp', function () {
    global $drdev_global;
    $drdev_global = drdev_get_global_data();
});

//add theme setup
function drdev_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('menus');
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    register_nav_menus([
        'primary' => __('Menú Principal', 'drdevultimate'),
        'secondary' => __( 'Footer Menu', 'drdevultimate' ),
        'legal' => __('Menú Footer Legal', 'drdevultimate')
    ]);
}
add_action('after_setup_theme', 'drdev_theme_setup');

//Company data
function drdev_customize_register($wp_customize) {
    // Section company data
    $wp_customize->add_section('company_data_section', [
        'title'    => __('Datos de la Empresa', 'drdevultimate'),
        'priority' => 30,
    ]);

    // Email
    $wp_customize->add_setting('company_email', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ]);
    $wp_customize->add_control('company_email', [
        'label'    => __('Email', 'drdevultimate'),
        'section'  => 'company_data_section',
        'type'     => 'email',
    ]);

    // Phone
    $wp_customize->add_setting('company_phone', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('company_phone', [
        'label'    => __('Teléfono', 'drdevultimate'),
        'section'  => 'company_data_section',
        'type'     => 'text',
    ]);

    // WhatsApp
    $wp_customize->add_setting('company_whatsapp', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('company_whatsapp', [
        'label'    => __('WhatsApp', 'drdevultimate'),
        'section'  => 'company_data_section',
        'type'     => 'text',
        'description' => 'Número completo con código país, ej: +34699111222',
    ]);

    // Schedule
    $wp_customize->add_setting('company_schedule', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('company_schedule', [
        'label'    => __('Horario', 'drdevultimate'),
        'section'  => 'company_data_section',
        'type'     => 'text',
    ]);

    //Social media
    $wp_customize->add_setting('company_tiktok', [
        'default'   => '',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('company_tiktok_control', [
        'label'    => __('TikTok URL', 'drdevultimate'),
        'section'  => 'company_data_section',
        'settings' => 'company_tiktok',
        'type'     => 'url',
    ]);

        $wp_customize->add_setting('company_facebook', [
        'default'   => '',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('company_facebook_control', [
        'label'    => __('Facebook URL', 'drdevultimate'),
        'section'  => 'company_data_section',
        'settings' => 'company_facebook',
        'type'     => 'url',
    ]);

    $wp_customize->add_setting('company_instagram', [
        'default'   => '',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('company_instagram_control', [
        'label'    => __('Instagram URL', 'drdevultimate'),
        'section'  => 'company_data_section',
        'settings' => 'company_instagram',
        'type'     => 'url',
    ]);
    //Office direction
     $wp_customize->add_setting('company_direction', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('company_direction', [
        'label'    => __('Dirección', 'drdevultimate'),
        'section'  => 'company_data_section',
        'type'     => 'text',
    ]);
     $wp_customize->add_setting('company_directionGoogle', [
        'default'   => 'URL Google',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('company_directionGoogle_control', [
        'label'    => __('URL Google', 'drdevultimate'),
        'section'  => 'company_data_section',
        'settings' => 'company_directionGoogle',
        'type'     => 'url',
    ]);
}
add_action('customize_register', 'drdev_customize_register');

// CPT
function drdev_register_cpt() {
    register_post_type('faq', [
        'label' => 'FAQs',
        'public' => false, 
        'publicly_queryable' => false, 
        'show_ui' => true,
        'supports' => ['title', 'editor'],
        'menu_icon' => 'dashicons-editor-help',
        'exclude_from_search' => true,
        'show_in_nav_menus' => false,
        'show_in_rest' => false, // Oculta del editor de bloques (si no usás Gutenberg)
        'rewrite' => false, // No genera URLs reescritas
        'query_var' => false, // No accesible por ?faq=slug
    ]);

    register_taxonomy('faq_group', 'faq', [
    'label' => 'Grupos de FAQ',
    'hierarchical' => false,
    'show_ui' => true,
    'show_in_menu'      => true,
    'show_admin_column' => true,
    'public'            => false,         
    'rewrite'           => false, // No crea URLs para términos
    'query_var'         => false, // No accesible por ?faq_group=
    'show_in_rest'      => true, 
    ]);

    $labels = array(
        'name'               => 'Envios',
        'singular_name'      => 'Envio',
        'menu_name'          => 'Envios',
        'name_admin_bar'     => 'Envio',
        'add_new'            => 'Agregar nuevo',
        'add_new_item'       => 'Agregar nuevo envio',
        'new_item'           => 'Nuevo envio',
        'edit_item'          => 'Editar envio',
        'view_item'          => 'Ver envio',
        'all_items'          => 'Todos los envio',
        'search_items'       => 'Buscar envio',
        'not_found'          => 'No se encontraron envios',
        'not_found_in_trash' => 'No hay envios en la papelera'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false, // oculta de Google y del frontend
        'publicly_queryable' => false, //  evita que se genere una URL accesible
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title', 'thumbnail')
    );

    register_post_type('shipping', $args);

    $office = array(
        'name'               => 'Oficinas',
        'singular_name'      => 'Oficina',
        'menu_name'          => 'Oficinas',
        'name_admin_bar'     => 'Oficina',
        'add_new'            => 'Agregar nuevo',
        'add_new_item'       => 'Agregar nueva oficina',
        'new_item'           => 'Nueva oficina',
        'edit_item'          => 'Editar oficina',
        'view_item'          => 'Ver oficina',
        'all_items'          => 'Todos lss oficina',
        'search_items'       => 'Buscar oficinas',
        'not_found'          => 'No se encontraron oficinas',
        'not_found_in_trash' => 'No hay oficinas en la papelera'
    );

    $args_office = array(
        'labels'             => $office,
        'public'             => false, // oculta de Google y del frontend
        'publicly_queryable' => false, //  evita que se genere una URL accesible
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title')
    );

    register_post_type('office', $args_office);

    register_post_type('hotel', [
        'labels' => [
            'name' => 'Hoteles',
            'singular_name' => 'Hotel',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-building',
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'hoteles'],
    ]);

    register_taxonomy('destino', 'hotel', [
        'labels' => [
            'name' => 'Destinos',
            'singular_name' => 'Destino',
        ],
        'public' => true,
        'hierarchical' => true,
        'rewrite' => ['slug' => 'destino'],
    ]);

}
add_action('init', 'drdev_register_cpt');

function drdev_add_meta_box() {
  add_meta_box(
    'shipping_meta_box',
    'Detalles del Envío',
    'drdev_render_shipping_meta_box',
    'shipping',
    'normal',
    'high'
  );

    add_meta_box(
    'office_meta_box',
    'Detalles de la oficina',
    'drdev_render_office_meta_box',
    'office',
    'normal',
    'high'
  );

   add_meta_box(
        'hotel_info',          
        'Información del Hotel', 
        'drdev_hoteles_metabox_callback', 
        'hotel',               
        'normal',             
        'high'              
    );

}
add_action('add_meta_boxes', 'drdev_add_meta_box');

function drdev_render_office_meta_box($post) {
  $direction = get_post_meta($post->ID, '_office_direction', true);
  $phone = get_post_meta($post->ID, '_office_phone', true);
  $office_additional_comment = get_post_meta($post->ID, '_office_additional_comment', true);


  echo '<label>Dirección:</label><br>';
  echo '<input type="text" name="office_direction" value="' . esc_attr($direction) . '" style="width:100%; margin-bottom: 10px;"><br>';

  echo '<label>Teléfono:</label><br>';
  echo '<input type="text" name="office_phone" value="' . esc_attr($phone) . '" style="width:100%; margin-bottom: 10px;"><br>';

  echo '<label>Comentario adicional:</label><br>';
  echo '<input type="text" name="office_additional_comment" value="' . esc_attr($office_additional_comment) . '" style="width:100%; margin-bottom: 10px;"><br>';

}

function drdev_save_office_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['office_direction'])) {
        update_post_meta($post_id, '_office_direction', sanitize_text_field($_POST['office_direction']));
    }
    if (isset($_POST['office_phone'])) {
        update_post_meta($post_id, '_office_phone', sanitize_text_field($_POST['office_phone']));
    }
    if (isset($_POST['office_additional_comment'])) {
        update_post_meta($post_id, '_office_additional_comment', sanitize_textarea_field($_POST['office_additional_comment']));
    }
}  
add_action('save_post', 'drdev_save_office_meta');

require_once get_template_directory() . '/template-parts/commons/faq.php';
function render_faq_group($group_slug = 'faq-home', $title = 'Preguntas frecuentes') {
    $faqs = get_posts([
        'post_type' => 'faq',
        'numberposts' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'tax_query' => [
            [
                'taxonomy' => 'faq_group',
                'field' => 'slug',
                'terms' => $group_slug
            ]
        ]
    ]);

    if (empty($faqs)) return;

    $parsed_faqs = array_map(function($faq) {
        return [
            'question' => get_the_title($faq),
            'answer' => apply_filters('the_content', $faq->post_content),
        ];
    }, $faqs);

    faq_component($parsed_faqs, $title);
}

function drdev_render_shipping_meta_box($post) {
    // 🔥 seguridad
    wp_nonce_field('save_shipping_meta', 'shipping_meta_nonce');

    $shipping_price    = get_post_meta($post->ID, '_shipping_price', true);
    $shipping_delivery = get_post_meta($post->ID, '_shipping_delivery', true);
    $image_id          = get_post_meta($post->ID, '_shipping_image_id', true);
    $image_url         = $image_id ? wp_get_attachment_url($image_id) : '';

    echo '<label>Precio:</label><br>';
    echo '<input type="text" name="shipping_price" value="' . esc_attr($shipping_price) . '" style="width:100%; margin-bottom: 10px;"><br>';

    echo '<label>Tiempo de entrega:</label><br>';
    echo '<input type="text" name="shipping_delivery" value="' . esc_attr($shipping_delivery) . '" style="width:100%; margin-bottom: 10px;"><br>';

    echo '<label>Imagen para móvil:</label><br>';
    echo '<input type="hidden" name="shipping_image_id" id="shipping_image_id" value="' . esc_attr($image_id) . '" />';
    echo '<img id="shipping-image-preview" src="' . esc_url($image_url) . '" style="max-width: 100%; height: auto;" />';
    echo '<br><input type="button" class="button" id="upload_shipping_image" value="Subir imagen" />';
}


function drdev_save_shipping($post_id) {
    // Evitar autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // 🔥 Verificar nonce
    if (!isset($_POST['shipping_meta_nonce']) || 
        !wp_verify_nonce($_POST['shipping_meta_nonce'], 'save_shipping_meta')) {
        return;
    }

    // 🔥 Verificar permisos
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Guardar campos
    if (isset($_POST['shipping_price'])) {
        update_post_meta($post_id, '_shipping_price', sanitize_text_field($_POST['shipping_price']));
    }
    if (isset($_POST['shipping_delivery'])) {
        update_post_meta($post_id, '_shipping_delivery', sanitize_text_field($_POST['shipping_delivery']));
    }
    if (isset($_POST['shipping_image_id'])) {
        update_post_meta($post_id, '_shipping_image_id', intval($_POST['shipping_image_id']));
    }
}
add_action('save_post', 'drdev_save_shipping');

function drdev_hoteles_metabox_callback($post) {
    wp_nonce_field('drdev_save_hotel_meta', 'drdev_hotel_meta_nonce');

    // Obtener valores guardados
    $location = get_post_meta($post->ID, '_location', true);
    $stars = get_post_meta($post->ID, '_stars', true);
    $offers   = get_post_meta($post->ID, '_offers', true); // array
    $offers   = is_array($offers) ? $offers : [];
    $services_sel = get_post_meta($post->ID, '_services', true); // array de keys
    $services_sel = is_array($services_sel) ? $services_sel : [];

    // Servicios predefinidos
    $services_available = [
        'actividades' => [
            'name' => 'Actividades deportivas',
            'icon'  => drdev_image_decorative('/assets/images/icons/directions_run.svg', '', '', '13', '13'),
        ],
        'bares' => [
            'name' => 'Bares',
            'icon'  => drdev_image_decorative('/assets/images/icons/wine_bar.svg', '', '', '13', '13'),
        ],
        'piscina' => [
            'name' => 'Piscina',
            'icon'  => drdev_image_decorative('/assets/images/icons/pool.svg', '', '', '13', '13'),
        ],
        'restaurantes' => [
            'name' => 'Restaurantes',
            'icon'  => drdev_image_decorative('/assets/images/icons/restaurant.svg', '', '', '13', '13'),
        ],
         'climatización' => [
            'name' => 'Climatización',
            'icon'  => drdev_image_decorative('/assets/images/icons/ac_unit.svg', '', '', '13', '13'),
        ],
        'ascensor' => [
            'name' => 'Ascensor',
            'icon' => drdev_image_decorative('/assets/images/icons/elevator.svg', '', '', '13', '13'),
        ],
        'equipaje' => [
            'name' => 'Servicio de equipaje',
            'icon' => drdev_image_decorative('/assets/images/icons/luggage.svg', '', '', '13', '13'),
        ],
        'aparcamiento' => [
            'name' => 'Aparcamiento gratuito',
            'icon' => drdev_image_decorative('/assets/images/icons/local_parking.svg', '', '', '13', '13'),
        ],
        'recepcion' => [
            'name' => 'Recepción 24 horas',
            'icon' => drdev_image_decorative('/assets/images/icons/room_service.svg', '', '', '13', '13'),
        ],
        'jacuzzi' => [
            'name' => 'Jacuzzi',
            'icon' => drdev_image_decorative('/assets/images/icons/hot_tub.svg', '', '', '13', '13'),
        ],
        'spa' => [
            'name' => 'Spa',
            'icon' => drdev_image_decorative('/assets/images/icons/spa.svg', '', '', '13', '13'),
        ],
        'buffet' => [
            'name' => 'Restaurante buffet',
            'icon' => drdev_image_decorative('/assets/images/icons/restaurant_menu.svg', '', '', '13', '13'),
        ],
        'playa' => [
            'name' => 'Zona de playa',
            'icon' => drdev_image_decorative('/assets/images/icons/beach_access.svg', '', '', '13', '13'),
        ],
        'sauna' => [
            'name' => 'Sauna',
            'icon' => drdev_image_decorative('/assets/images/icons/sauna.svg', '', '', '13', '13'),
        ],
        'negocios' => [
            'name' => 'Centro de Negocios',
            'icon' => drdev_image_decorative('/assets/images/icons/business_center.svg', '', '', '13', '13'),
        ],
        'caja' => [
            'name' => 'Caja de seguridad',
            'icon' => drdev_image_decorative('/assets/images/icons/security.svg', '', '', '13', '13'),
        ],
        'personal' => [
            'name' => 'Personal bilingüe',
            'icon' => drdev_image_decorative('/assets/images/icons/translate.svg', '', '', '13', '13'),
        ],
        'wifi' => [
            'name' => 'Wi-fi',
            'icon' => drdev_image_decorative('/assets/images/icons/wifi.svg', '', '', '13', '13'),
        ],
        'gimnasio' => [
            'name' => 'Gimnasio',
            'icon' => drdev_image_decorative('/assets/images/icons/fitness_center.svg', '', '', '13', '13'),
        ],
        'especializados' => [
            'name' => 'Restaurantes especializados',
            'icon' => drdev_image_decorative('/assets/images/icons/local_dining.svg', '', '', '13', '13'),
        ],
        'lavanderia' => [
            'name' => 'Servicio de lavandería y tintorería',
            'icon' => drdev_image_decorative('/assets/images/icons/local_laundry_service.svg', '', '', '13', '13'),
        ],
        'piscina_ninos' => [
            'name' => 'Piscina para niños',
            'icon' => drdev_image_decorative('/assets/images/icons/child_care.svg', '', '', '13', '13'),
        ],
        'club_nocturno' => [
            'name' => 'Club Nocturno',
            'icon' => drdev_image_decorative('/assets/images/icons/nightlife.svg', '', '', '13', '13'),
        ],
        'buro_turismo' => [
            'name' => 'Buro de Turismo',
            'icon' => drdev_image_decorative('/assets/images/icons/travel_explore.svg', '', '', '13', '13'),
        ],
        'room_service' => [
            'name' => 'Room Service 11:00 - 23:00',
            'icon' => drdev_image_decorative('/assets/images/icons/room_service.svg', '', '', '13', '13'),
        ],
        'parque_ninos' => [
            'name' => 'Parque de juegos para niños',
            'icon' => drdev_image_decorative('/assets/images/icons/attractions.svg', '', '', '13', '13'),
        ],
        'areas_deportivas' => [
            'name' => 'Áreas Deportivas',
            'icon' => drdev_image_decorative('/assets/images/icons/sports_soccer.svg', '', '', '13', '13'),
        ],
        'masajes' => [
            'name' => 'Masajes con cargo',
            'icon' => drdev_image_decorative('/assets/images/icons/self_care.svg', '', '', '13', '13'),
        ],
        'salon_belleza' => [
            'name' => 'Salón de belleza con costo',
            'icon' => drdev_image_decorative('/assets/images/icons/check.svg', '', '', '13', '13'),
        ],
        'servicio_medico' => [
            'name' => 'Servicio médico con cargo',
            'icon' => drdev_image_decorative('/assets/images/icons/check.svg', '', '', '13', '13'),
        ],
        'sala_fitness' => [
            'name' => 'Sala Fitness',
            'icon' => drdev_image_decorative('/assets/images/icons/fitness_center.svg', '', '', '13', '13'),
        ],
        'spa_costo' => [
            'name' => 'Spa con costo',
            'icon' => drdev_image_decorative('/assets/images/icons/spa.svg', '', '', '13', '13'),
        ],
        'cigar_lounge' => [
            'name' => 'Cigar Lounge',
            'icon' => drdev_image_decorative('/assets/images/icons/smoking_rooms.svg', '', '', '13', '13'),
        ],
        'shows' => [
            'name' => 'Shows profesionales',
            'icon' => drdev_image_decorative('/assets/images/icons/theater_comedy.svg', '', '', '13', '13'),
        ],
        'reuniones' => [
            'name' => 'Sala de reuniones',
            'icon' => drdev_image_decorative('/assets/images/icons/groups.svg', '', '', '13', '13'),
        ],
        'deportes_nauticos' => [
            'name' => 'Deportes náuticos',
            'icon' => drdev_image_decorative('/assets/images/icons/kayaking.svg', '', '', '13', '13'),
        ],
        'accesos_discapacidad' => [
            'name' => 'Accesos para persona con discapacidad física',
            'icon' => drdev_image_decorative('/assets/images/icons/accessibility.svg', '', '', '13', '13'),
        ],
        'cambio_moneda' => [
            'name' => 'Cambio de moneda',
            'icon' => drdev_image_decorative('/assets/images/icons/attach_money.svg', '', '', '13', '13'),
        ],
        'renta_auto' => [
            'name' => 'Servicio de renta de auto',
            'icon' => drdev_image_decorative('/assets/images/icons/car.svg', '', '', '13', '13'),
        ],
        'tiendas' => [
            'name' => 'Tiendas',
            'icon' => drdev_image_decorative('/assets/images/icons/store.svg', '', '', '13', '13'),
        ],
        'taxi' => [
            'name' => 'Servicio de taxi',
            'icon' => drdev_image_decorative('/assets/images/icons/car.svg', '', '', '13', '13'),
        ],
    ];
    ?>

    <p>
        <label>Ubicación:</label><br>
        <input type="text" name="location" value="<?php echo esc_attr($location); ?>" style="width:100%;">
    </p>

    <p>
        <label>stars (1-5):</label><br>
        <input type="number" name="stars" value="<?php echo esc_attr($stars); ?>" min="1" max="5">
    </p>

    <p>
        <label>Ofertas (hasta 2):</label><br>
        <?php for ($i=0; $i<2; $i++) :
            $valor = isset($offers[$i]) ? $offers[$i] : '';
        ?>
            <input type="text" name="offers[]" value="<?php echo esc_attr($valor); ?>" style="width:100%; margin-bottom:2px;">
        <?php endfor; ?>
    </p>

    <p>
        <label>Servicios:</label><br>
        <?php foreach ($services_available as $key => $servicio) : ?>
            <label style="display:block; margin-bottom:3px;">
                <input type="checkbox" name="services[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $services_sel)); ?>>
                <?php echo wp_kses_post($servicio['icon']); ?>
                <?php echo esc_html($servicio['name']); ?>
            </label>
        <?php endforeach; ?>
    </p>

    <?php
}

function drdev_save_hotel_meta($post_id) {
    if (!isset($_POST['drdev_hotel_meta_nonce'])) return;
    if (!wp_verify_nonce($_POST['drdev_hotel_meta_nonce'], 'drdev_save_hotel_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['location'])) {
        update_post_meta($post_id, '_location', sanitize_text_field($_POST['location']));
    }

    if (isset($_POST['stars'])) {
        update_post_meta($post_id, '_stars', intval($_POST['stars']));
    }

    if (isset($_POST['offers'])) {
        $offers = array_map('sanitize_text_field', $_POST['offers']);
        update_post_meta($post_id, '_offers', $offers);
    }

    if (isset($_POST['services'])) {
        $services = array_map('sanitize_text_field', $_POST['services']);
        update_post_meta($post_id, '_services', $services);
    }
}
add_action('save_post', 'drdev_save_hotel_meta');

function drdev_hoteles_services_available() {
        return [
        'actividades' => [
            'name' => 'Actividades deportivas',
            'icon' => drdev_image_decorative('/assets/images/icons/directions_run.svg', '', '', '13', '13'),
        ],
        'bares' => [
            'name' => 'Bares',
            'icon' => drdev_image_decorative('/assets/images/icons/wine_bar.svg', '', '', '13', '13'),
        ],
        'piscina' => [
            'name' => 'Piscina',
            'icon' => drdev_image_decorative('/assets/images/icons/pool.svg', '', '', '13', '13'),
        ],
        'restaurantes' => [
            'name' => 'Restaurantes',
            'icon' => drdev_image_decorative('/assets/images/icons/restaurant.svg', '', '', '13', '13'),
        ],
        'climatizacion' => [
            'name' => 'Climatización',
            'icon' => drdev_image_decorative('/assets/images/icons/ac_unit.svg', '', '', '13', '13'),
        ],
        // Nuevos
        'ascensor' => [
            'name' => 'Ascensor',
            'icon' => drdev_image_decorative('/assets/images/icons/elevator.svg', '', '', '13', '13'),
        ],
        'equipaje' => [
            'name' => 'Servicio de equipaje',
            'icon' => drdev_image_decorative('/assets/images/icons/luggage.svg', '', '', '13', '13'),
        ],
        'aparcamiento' => [
            'name' => 'Aparcamiento gratuito',
            'icon' => drdev_image_decorative('/assets/images/icons/local_parking.svg', '', '', '13', '13'),
        ],
        'recepcion' => [
            'name' => 'Recepción 24 horas',
            'icon' => drdev_image_decorative('/assets/images/icons/room_service.svg', '', '', '13', '13'),
        ],
        'jacuzzi' => [
            'name' => 'Jacuzzi',
            'icon' => drdev_image_decorative('/assets/images/icons/hot_tub.svg', '', '', '13', '13'),
        ],
        'spa' => [
            'name' => 'Spa',
            'icon' => drdev_image_decorative('/assets/images/icons/spa.svg', '', '', '13', '13'),
        ],
        'buffet' => [
            'name' => 'Restaurante buffet',
            'icon' => drdev_image_decorative('/assets/images/icons/restaurant_menu.svg', '', '', '13', '13'),
        ],
        'playa' => [
            'name' => 'Zona de playa',
            'icon' => drdev_image_decorative('/assets/images/icons/beach_access.svg', '', '', '13', '13'),
        ],
        'sauna' => [
            'name' => 'Sauna',
            'icon' => drdev_image_decorative('/assets/images/icons/sauna.svg', '', '', '13', '13'),
        ],
        'negocios' => [
            'name' => 'Centro de Negocios',
            'icon' => drdev_image_decorative('/assets/images/icons/business_center.svg', '', '', '13', '13'),
        ],
        'caja' => [
            'name' => 'Caja de seguridad',
            'icon' => drdev_image_decorative('/assets/images/icons/security.svg', '', '', '13', '13'),
        ],
        'personal' => [
            'name' => 'Personal bilingüe',
            'icon' => drdev_image_decorative('/assets/images/icons/translate.svg', '', '', '13', '13'),
        ],
        'wifi' => [
            'name' => 'Wi-fi',
            'icon' => drdev_image_decorative('/assets/images/icons/wifi.svg', '', '', '13', '13'),
        ],
        'gimnasio' => [
            'name' => 'Gimnasio',
            'icon' => drdev_image_decorative('/assets/images/icons/fitness_center.svg', '', '', '13', '13'),
        ],
        'especializados' => [
            'name' => 'Restaurantes especializados',
            'icon' => drdev_image_decorative('/assets/images/icons/local_dining.svg', '', '', '13', '13'),
        ],
         'lavanderia' => [
            'name' => 'Servicio de lavandería y tintorería',
            'icon' => drdev_image_decorative('/assets/images/icons/local_laundry_service.svg', '', '', '13', '13'),
        ],
        'piscina_ninos' => [
            'name' => 'Piscina para niños',
            'icon' => drdev_image_decorative('/assets/images/icons/child_care.svg', '', '', '13', '13'),
        ],
        'club_nocturno' => [
            'name' => 'Club Nocturno',
            'icon' => drdev_image_decorative('/assets/images/icons/nightlife.svg', '', '', '13', '13'),
        ],
        'buro_turismo' => [
            'name' => 'Buro de Turismo',
            'icon' => drdev_image_decorative('/assets/images/icons/travel_explore.svg', '', '', '13', '13'),
        ],
        'room_service' => [
            'name' => 'Room Service 11:00 - 23:00',
            'icon' => drdev_image_decorative('/assets/images/icons/room_service.svg', '', '', '13', '13'),
        ],
        'parque_ninos' => [
            'name' => 'Parque de juegos para niños',
            'icon' => drdev_image_decorative('/assets/images/icons/attractions.svg', '', '', '13', '13'),
        ],
        'areas_deportivas' => [
            'name' => 'Áreas Deportivas',
            'icon' => drdev_image_decorative('/assets/images/icons/sports_soccer.svg', '', '', '13', '13'),
        ],
        'masajes' => [
            'name' => 'Masajes con cargo',
            'icon' => drdev_image_decorative('/assets/images/icons/self_care.svg', '', '', '13', '13'),
        ],
        'salon_belleza' => [
            'name' => 'Salón de belleza con costo',
            'icon' => drdev_image_decorative('/assets/images/icons/face_retouching_natural.svg', '', '', '13', '13'),
        ],
        'servicio_medico' => [
            'name' => 'Servicio médico con cargo',
            'icon' => drdev_image_decorative('/assets/images/icons/local_hospital.svg', '', '', '13', '13'),
        ],
        'sala_fitness' => [
            'name' => 'Sala Fitness',
            'icon' => drdev_image_decorative('/assets/images/icons/fitness_center.svg', '', '', '13', '13'),
        ],
        'spa_costo' => [
            'name' => 'Spa con costo',
            'icon' => drdev_image_decorative('/assets/images/icons/spa.svg', '', '', '13', '13'),
        ],
        'cigar_lounge' => [
            'name' => 'Cigar Lounge',
            'icon' => drdev_image_decorative('/assets/images/icons/smoking_rooms.svg', '', '', '13', '13'),
        ],
        'shows' => [
            'name' => 'Shows profesionales',
            'icon' => drdev_image_decorative('/assets/images/icons/theater_comedy.svg', '', '', '13', '13'),
        ],
        'reuniones' => [
            'name' => 'Sala de reuniones',
            'icon' => drdev_image_decorative('/assets/images/icons/groups.svg', '', '', '13', '13'),
        ],
        'deportes_nauticos' => [
            'name' => 'Deportes náuticos',
            'icon' => drdev_image_decorative('/assets/images/icons/kayaking.svg', '', '', '13', '13'),
        ],
        'accesos_discapacidad' => [
            'name' => 'Accesos para persona con discapacidad física',
            'icon' => drdev_image_decorative('/assets/images/icons/accessibility.svg', '', '', '13', '13'),
        ],
        'cambio_moneda' => [
            'name' => 'Cambio de moneda',
            'icon' => drdev_image_decorative('/assets/images/icons/attach_money.svg', '', '', '13', '13'),
        ],
        'renta_auto' => [
            'name' => 'Servicio de renta de auto',
            'icon' => drdev_image_decorative('/assets/images/icons/car.svg', '', '', '13', '13'),
        ],
        'tiendas' => [
            'name' => 'Tiendas',
            'icon' => drdev_image_decorative('/assets/images/icons/store.svg', '', '', '13', '13'),
        ],
        'taxi' => [
            'name' => 'Servicio de taxi',
            'icon' => drdev_image_decorative('/assets/images/icons/local_taxi.svg', '', '', '13', '13'),
        ],
    ];

}

//integrations CRM's
function drdev_register_daily_sync() {
    if (!wp_next_scheduled('drdev_sync_crm')) {
        wp_schedule_event(time(), 'daily', 'drdev_sync_crm');
    }
}
add_action('wp', 'drdev_register_daily_sync');

// El hook que ejecuta la función de sincronización
add_action('drdev_sync_crm', 'drdev_sync_crm_task');

function drdev_sync_crm_task() {
    // require_once __DIR__ . '/inc/sync-crm.php'; 
    // drdev_execute_sync();
}

/**Sync CRM */
function drdev_sync_admin_menu() {
    add_menu_page('Sync Zoho', 'Sync Zoho', 'manage_options', 'drdev-sync', 'drdev_sync_admin_page');
}
add_action('admin_menu', 'drdev_sync_admin_menu');

function drdev_sync_admin_page() {
    if (isset($_POST['manual_sync'])) {
        drdev_execute_sync();
        echo '<div class="notice notice-success"><p>Sincronización ejecutada correctamente.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Sincronizar Zoho CRM</h1>
        <form method="post">
            <input type="hidden" name="manual_sync" value="1">
            <?php submit_button('Ejecutar sincronización ahora'); ?>
        </form>
    </div>
    <?php
}

//SEO
function is_production() {
    return ( function_exists( 'wp_get_environment_type' ) 
        && wp_get_environment_type() === 'production' );
}


require_once get_template_directory() . '/inc/global-paths.php';
require_once get_template_directory() . '/inc/walker-menu.php';
require get_template_directory() . '/inc/components.php';
require_once get_template_directory() . '/inc/init.php';