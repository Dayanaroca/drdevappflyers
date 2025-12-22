<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Header
 * Variables:
 * - $post_id
 * - $product_name
 * - $product_hashtag
 * - $brand_logo (ID)
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
$flyer_price_from  = get_post_meta($post_id, 'flyer_price_from', true);
$bg_base64 = image_id_to_base64_safe($bg_header);
$logo_base64 = image_id_to_base64_safe($brand_logo);
$gradient = get_stylesheet_directory() . '/assets/images/gradient_etg.png';
$data_uri_gradient = file_or_url_to_data_uri( $gradient );


switch (intval($template_selected)) {
    case 1:
        $size_header_front = '250px';
        $size_title = '20px';
        $col_width = '500px';
        $td_height = '0px';
        break;
    case 2:
        $size_header_front = '290px';
        $size_title = '24px';
        $col_width = '350px';
        $td_height = '0px';
        break;
    case 3:
        $size_header_front = '340px';
        $size_title = '24px';
        $col_width = '350px';
        $td_height = '60px';
        break;
    default:
        $size_header_front = '207px';
        $size_title = '20px';
        $col_width = '500px';
        $td_height = '0px';
        break;
}

 $info_items = [
        ['icon'   => get_stylesheet_directory_uri() . '/assets/icons/calendar.svg', 'label' => __('Duración:', 'drdevflyers'), 'meta'   => 'duration' ],
        [ 'icon'   => get_stylesheet_directory_uri() . '/assets/icons/hotel.svg', 'label'  => __('Ubicación:', 'drdevflyers'), 'meta'   => 'accommodation'],
        [ 'icon'   => get_stylesheet_directory_uri() . '/assets/icons/person.svg', 'label'  => __('Mínimo:', 'drdevflyers'), 'meta'   => 'minimum_number_of_people'],
        [ 'icon'   => get_stylesheet_directory_uri() . '/assets/icons/person.svg', 'label'  => __('Máximo:', 'drdevflyers'), 'meta'   => 'maximum_number_of_people'],
        [ 'icon'   => get_stylesheet_directory_uri() . '/assets/icons/flag.svg', 'label'  => '', 'meta'   => 'departures'],
    ];
?>
<div style="position:relative; height:<?php echo $size_header_front; ?>; overflow:hidden; margin-bottom:40px; background-image: url('<?php echo get_attached_file($bg_header); ?>'); background-size:cover; background-position:center center; background-repeat:no-repeat;">

    <!-- Overlay -->
    <div style="position:absolute; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:1;">    
    </div>

    <!-- Contenido superior: logo + hashtag -->
    <div style="position:absolute; top:20px; left:45px; right:45px; z-index:2;">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="text-align:left;">
                    <?php if (!empty($product_hashtag)): ?>
                        <span style="font-size:14px; color:#fff; font-weight:600;">
                            <?php echo esc_html($product_hashtag); ?>
                        </span>
                    <?php endif; ?>
                </td>
                <td style="text-align:right;">
                    <?php if (!empty($logo_base64)): ?>
                        <img src="<?php echo $logo_base64; ?>" 
                             alt="Logo" 
                             style="max-width:200px; max-height:100px; object-fit:contain;">
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Contenido inferior: título + precio + info -->
    <div style="position:absolute; bottom:30px; left:45px; right:45px; z-index:2;">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="vertical-align:bottom; color:#fff;">
                    <?php if (!empty($product_name)): ?>
                        <h1 style="color:#fff; font-size:<?php echo $size_title; ?>; line-height:1; font-weight:bold; margin:0 0 10px 0; width:<?php echo $col_width; ?>">
                            <?php echo esc_html($product_name); ?>
                        </h1>
                        <hr style="border-color:#fff; width:100px; margin:0 0 10px 0;">
                    <?php endif; ?>

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
                <td style="width:120px; vertical-align:bottom;">
                    <?php if (!empty(($flyer_price_from || $flyer_price_from === "1")) || (!empty($price) && !empty($currency)) || (!empty($occupation_text))): ?>
                    <table valign="middle" cellspacing="0" cellpadding="0" style="background-color:#fff; color:#000; padding:6px 5px; border-radius:4px;">
                        <?php if (!empty($flyer_price_from) && ($flyer_price_from === "1")): ?>
                        <tr>
                            <td>                                            
                                <p style="margin:0; font-weight:bold; font-size:11px; line-height:1">
                                    <?php echo esc_html__('Desde:', 'drdevflyers'); ?>
                                </p>                                           
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>
                            <?php if (!empty($price) && !empty($currency)): ?>                                        
                                <p style="margin:0; line-height:1">
                                    <span style="font-size:20px; font-weight:normal; color:#000;"><?php echo esc_html($currency); ?></span>
                                    <span style="font-size:20px; font-weight:bold; color:#000;"><?php echo esc_html($price); ?></span>
                                </p>
                            <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                           <td>                                                
                            <?php if (!empty($occupation_text)): ?>
                                <p style="font-size:11px; margin:0px; font-weight:bold;">
                                    <?php echo esc_html($occupation_text); ?>
                                </p>
                            <?php endif; ?>
                           </td>
                        </tr>
                    </table>  
                    <?php endif; ?>                                  
                </td>
            </tr>
        </table>
    </div>
</div>