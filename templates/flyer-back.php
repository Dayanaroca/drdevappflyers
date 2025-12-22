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

$template_selected_back = intval(get_post_meta($post_id, '_template_selected_back', true)) ?: 1;

switch (intval($template_selected_back)) {
    case 1:
        include locate_template('templates/flyer-parts/flyer-header_back.php');
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