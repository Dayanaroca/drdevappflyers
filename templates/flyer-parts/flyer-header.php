<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Header
 * Variables:
 * - $post_id
 * - $product_name
 * - $product_hashtag
 * - $brand_logo (ID)
 * - $brand_logo_color (ID)
 * - $logo_color_option ('White' | 'Color')
 * - $currency
 * - $price
 * - $occupation_text
 * - $$template_selecte
 * - $bg_header (ID)
 */

$template_selected = intval(get_post_meta($post_id, '_template_selected', true)) ?: 1;
$product_name      = get_the_title($post_id);
$currency          = get_post_meta($post_id, 'currency', true);
$price             = get_post_meta($post_id, 'price', true);
$occupation_text   = get_post_meta($post_id, 'occupation_text', true);
$logo_color_option = get_post_meta($post_id, '_logo_color', true) ?: 'White';
$bg_header         = get_post_meta($post_id, 'bg_header', true); // ID 
// --- Fondo ---
$bg_base64 = image_id_to_base64($bg_header);

// --- Logo según opción ---
$overlay_path = get_stylesheet_directory() . '/assets/images/overlay.png';
$overlay_base64 = '';
if(file_exists($overlay_path)) {
    $type = mime_content_type($overlay_path);
    $data = file_get_contents($overlay_path);
    $overlay_base64 = 'data:' . $type . ';base64,' . base64_encode($data);
}

// --- Logo ---
$logo_id = ($logo_color_option ?? 'White') === 'Color' ? $brand_logo_color : $brand_logo;
$logo_base64 = image_id_to_base64($logo_id);

switch (intval($template_selected)) {
    case 1:
        $size_header_front = '207px';
        $size_title = '20px';
        $col_width = '500px';
        $td_height = '0px';
        break;
    case 2:
        $size_header_front = '269px';
        $size_title = '24px';
        $col_width = '350px';
        $td_height = '0px';
        break;
    case 3:
        $size_header_front = '329px';
        $size_title = '24px';
        $col_width = '350px';
        $td_height = '50px';
        break;
    default:
        $size_header_front = '207px';
        $size_title = '20px';
        $col_width = '500px';
        $td_height = '0px';
        break;
}

 $info_items = [
        [
            'icon'   => get_stylesheet_directory_uri() . '/assets/icons/calendar.svg',
            'label'  => 'Duración:',
            'meta'   => 'duration' // nombre del campo personalizado
        ],
        [
            'icon'   => get_stylesheet_directory_uri() . '/assets/icons/hotel.svg',
            'label'  => 'Ubicación:',
            'meta'   => 'accommodation'
        ],
        [
            'icon'   => get_stylesheet_directory_uri() . '/assets/icons/person.svg',
            'label'  => 'Mínimo:',
            'meta'   => 'minimum_number_of_people'
        ],
        [
            'icon'   => get_stylesheet_directory_uri() . '/assets/icons/person.svg',
            'label'  => 'Máximo:',
            'meta'   => 'maximum_number_of_people'
        ],
        [
            'icon'   => get_stylesheet_directory_uri() . '/assets/icons/flag.svg',
            'label'  => '',
            'meta'   => 'departures'
        ],
    ];

?>

<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin:0; padding:0; width:100%; position:relative;">
    <tr>
        <td style="padding:0; margin:0; position:relative; height:<?php echo $size_header_front; ?>;">
            
            <!-- Imagen de fondo como <img> -->
            <?php if (!empty($bg_base64)): ?>
                <img src="<?php echo esc_attr($bg_base64); ?>" 
                     alt="Background" 
                     style="width:100%; height:<?php echo $size_header_front; ?>; object-fit:cover; position:absolute; top:0; left:0; z-index:0; display:block;">
            <?php endif; ?>

            <!-- Capa overlay -->
            <table width="100%" cellspacing="0" cellpadding="0" 
                   style="background-color:rgba(0,0,0,0.4); width:100%; height:<?php echo $size_header_front; ?>; box-sizing:border-box; position:relative; z-index:1;">
                <tr>
                    <td style="vertical-align:top; padding:20px 30px 0 30px;">
                        <!-- Hashtag + Logo -->
                        <table width="100%" cellpadding="10" cellspacing="0" style="width:100%;">
                            <tr>
                                <td style="text-align:left; vertical-align:top;">
                                    <?php if (!empty($product_hashtag)): ?>
                                        <span style="font-size:11px; color:#fff; font-weight: 600;">
                                            <?php echo esc_html($product_hashtag); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align:right; vertical-align:top;">
                                    <?php if (!empty($logo_base64)): ?>
                                        <img src="<?php echo $logo_base64; ?>" 
                                             alt="Logo" 
                                             style="height:45px; max-height:45px; object-fit:contain;">
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="height:<?php echo $td_height; ?>;"></td>
                </tr>
                <tr>
                    <td style="vertical-align:bottom; padding:0px 30px 15px 30px;">
                        <!-- Título -->
                        <table width="100%" cellpadding="0" cellspacing="0" style="width:100%; margin-bottom:4px;">
                            <tr>
                                <td style="vertical-align:top; color:#fff; width:<?php echo $col_width; ?>">
                                    <?php if (!empty($product_name)): ?>
                                        <h1 style="color:#fff; font-size:<?php echo $size_title; ?>; line-height:1; font-weight:bold; margin:0 0 10px 0;">
                                            <?php echo esc_html($product_name); ?>
                                        </h1>
                                        <hr style="border-color:#fff; width:100px; margin:0;">
                                    <?php endif; ?>
                                </td>
                                <td></td>
                            </tr>
                        </table>

                        <!-- Info + Precio -->
                        <table width="100%" cellpadding="0" cellspacing="0" style="width:100%;">
                            <tr>
                                <td style="vertical-align:bottom; color:#fff;">
                                    <?php foreach ($info_items as $item) :
                                        $value = get_post_meta($post_id, $item['meta'], true);
                                        if (!empty($value)) :
                                            $path = str_replace(get_stylesheet_directory_uri(), get_stylesheet_directory(), $item['icon']);
                                            if (file_exists($path)) {
                                                $svg = file_get_contents($path);
                                                $svg = preg_replace('/<svg /', '<svg style="background:none;" ', $svg);
                                                $svg = str_replace(['fill="#ffffff"', 'fill="#fff"'], 'fill="currentColor"', $svg);
                                                $icon_base64 = 'data:image/svg+xml;base64,' . base64_encode($svg);
                                            } else {
                                                $icon_base64 = '';
                                            }
                                    ?>
                                        <div style="margin:0; padding:0; line-height:0.7em;">
                                            <img src="<?php echo $icon_base64; ?>" 
                                                 style="width:10px; height:10px; display:inline-block; vertical-align:middle;">
                                            <?php if (!empty($item['label'])): ?>
                                                <span style="font-size:11px; vertical-align:middle;">
                                                    <?php echo esc_html($item['label']); ?>
                                                </span>
                                            <?php endif; ?>
                                            <span style="font-size:11px; font-weight:bold; vertical-align:middle;">
                                                <?php echo esc_html($value); ?>
                                            </span>
                                        </div>
                                    <?php endif; endforeach; ?>
                                </td>

                                <td style="width:100px; background-color:#fff; color:#000; vertical-align:bottom; padding:6px 5px; border-radius:4px;">
                                    <?php if (!empty($price) && !empty($currency)): ?>
                                        <p style="margin:0; font-weight:bold; font-size:11px; line-height:1">Desde:</p>
                                        <p style="margin:0; line-height:1">
                                            <span style="font-size:20px; font-weight:normal; color:#000;"><?php echo esc_html($currency); ?></span>
                                            <span style="font-size:20px; font-weight:bold; color:#000;"><?php echo esc_html($price); ?></span>
                                        </p>
                                    <?php endif; ?>
                                    <?php if (!empty($occupation_text)): ?>
                                        <p style="font-size:11px; margin:0px; font-weight:bold;">
                                            <?php echo esc_html($occupation_text); ?>
                                        </p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>