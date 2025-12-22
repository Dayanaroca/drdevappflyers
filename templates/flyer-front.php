<?php
if (!defined('ABSPATH')) exit;
/**
 * Front Template
 */

$template_selected_back = intval(get_post_meta($post_id, '_template_selected_back', true)) ?: 1;
$template_footer_back = intval(get_post_meta($post_id, '_template_footer_back', true)) ?: 7;
$product_hashtag   = get_post_meta($post_id, 'hashtag', true);

// --- Date brand ---
$brand_id          = get_post_meta($post_id, '_brand_selected', true);
$brand_logo        = get_post_meta($brand_id, 'brand_logo', true);
$brand_logo_color  = get_post_meta($brand_id, 'brand_logo_color', true);
$brand_color       = get_post_meta($brand_id, 'corporate_color', true) ?: '#000';
$site_url   = get_post_meta($brand_id, 'site_url', true);

$page_height = '279mm';
 
switch (intval($template_footer_back)) {
    case 7:
        $footer_height_px = 80;
        break;
    case 8:
        $footer_height_px = 120;
        break;
    case 9:
        $footer_height_px = 160;
        break;
    default:
        $footer_height_px = 80;
        break;
}        // en px
$footer_height_mm = $footer_height_px / 3.78;

if (!isset($brand_id) || !isset($post_id)) return;

// --- Obtener logo de la marca ---
$brand_logo_footer = get_post_meta($brand_id, 'brand_logo_footer', true);
$brand_logo_footer_base64 = function_exists('image_id_to_base64') ? image_id_to_base64($brand_logo_footer) : '';

// --- Obtener índice de la tarjeta seleccionada ---
$contact_index = get_post_meta($post_id, '_contact_card_selected', true);

// --- Inicializar contacto vacío ---
$contact = [
    'nombre_de_contacto' => '',
    'site_url' => '',
    'email' => '',
    'phone' => '',
    'facebook' => '',
    'instagram' => '',
    'linkedin' => '',
    'youtube' => '',
    'tiktok' => '',
    'others_links' => '',
];

// --- Leer la tarjeta seleccionada del repeater ---
if (have_rows('tarjeta_de_contacto', $brand_id)) {
    while (have_rows('tarjeta_de_contacto', $brand_id)) {
        the_row();
        $current_index = get_row_index() - 1; // ACF empieza en 1
        if ($current_index == $contact_index) {
            $contact = [
                'nombre_de_contacto' => get_sub_field('nombre_de_contacto'),
                'site_url'           => get_sub_field('site_url'),
                'email'              => get_sub_field('email'),
                'phone'              => get_sub_field('phone'),
                'facebook'           => get_sub_field('link_facebook_'),
                'instagram'          => get_sub_field('link_instagram'),
                'linkedin'           => get_sub_field('link_linkedin'),
                'youtube'            => get_sub_field('link_youtube'),
                'tiktok'             => get_sub_field('link_tiktok'),
                'others_links'       => get_sub_field('others_links'),
            ];
            break;
        }
    }
}

$description   = get_post_meta($post_id, 'description', true);
$table_of_contents = get_field('table_of_contents', $post_id);
$items_included       = get_field('items_included', $post_id);        // repeater
$items_not_included   = get_field('items_not_included', $post_id);    // repeater
$flyer_observations   = get_field('flyer_observations', $post_id); 
$bg_header_back = get_post_meta($post_id, 'bg_header_back', true); // ID 
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


<!-- FRONT PAGE -->
<table width="100%" style="page-break-after:always; border-collapse:collapse; width:100%; height:100%;">
  <tr>
    <td valign="top" style="padding:0;">
      <?php include locate_template('templates/flyer-parts/flyer-header.php'); 
       if (!empty($description)) {
          include locate_template('templates/flyer-parts/flyer-descriptions.php'); 
        }
        ob_start();
        include locate_template('templates/flyer-parts/flyer-itinerary.php');
        $itinerary_html = ob_get_clean();
        $template_selected = intval(get_post_meta($post_id, '_template_selected', true)) ?: 1;
        $available_height_px = calculate_available_height($post_id, $template_selected);
        list($part1, $part2) = split_tables_by_available_height($itinerary_html, $available_height_px);
        list($part1, $part2) = fine_tune_itinerary_split($part1, $part2, $available_height_px);
        echo $part1;
      ?>
    </td>
  </tr>
</table>

<!-- BACK PAGE -->
<div class="page-back" style="position:relative; width:100%; height: <?php echo $page_height; ?>; margin:0; padding:0; box-sizing:border-box;">

  <!-- HEADER -->
  <?php if ($template_selected_back == 5) : ?>
    <div class="back-header" style="width:100%; padding:0; margin:0;">
      <?php include locate_template('templates/flyer-parts/flyer-header_back.php'); ?>
      <div style="padding-top:20px">
        <?php if (!empty(trim($part2))) : ?>
        <?php echo $part2; ?>
        <?php endif; ?>
        <?php include locate_template('templates/flyer-parts/flyer-table.php'); ?>
        <?php include locate_template('templates/flyer-parts/flyer-included.php'); ?>
      </div>
    </div> 

  <!-- BODY -->
  <?php elseif ($template_selected_back == 6) : ?>
    <div class="back-body" style="padding:0; padding-bottom: <?php echo $footer_height_px; ?>px; box-sizing:border-box; overflow:visible;">
      <?php include locate_template('templates/flyer-parts/flyer-body_v2.php'); ?>
    </div>
  <?php else : ?>
  <div class="back-body" style="padding-top:45px; padding-bottom: <?php echo $footer_height_px; ?>px; box-sizing:border-box; overflow:visible;">
    <?php if (!empty(trim($part2))) : ?>
      <?php echo $part2; ?>
    <?php endif; ?>
     <?php include locate_template('templates/flyer-parts/flyer-table.php'); ?>
     <?php include locate_template('templates/flyer-parts/flyer-included.php'); ?>
  </div>
  <?php endif; ?>

  <!-- FOOTER FIXED -->
  <div class="back-footer" style="position:fixed; bottom:0; left:0; right:0; height:<?php echo $footer_height_px; ?>px; color:#000; text-align:center; font-size:9px; box-sizing:border-box;">
   <?php if ($template_footer_back == 7) : 
     include locate_template('templates/flyer-parts/flyer-footer_back.php');
     elseif ($template_footer_back == 8) :
      include locate_template('templates/flyer-parts/flyer-footer_back_v1.php');
      elseif ($template_footer_back == 9) :
      include locate_template('templates/flyer-parts/flyer-footer_back_v2.php');
     endif; 
    ?>
  </div>

</div>

