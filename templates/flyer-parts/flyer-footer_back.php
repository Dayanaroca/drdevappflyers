<?php
/**
 * Component: Footer Back end
 * Variables:
 * - $brand_logo_footer
 * - $site_url
 * - $link_facebook_
 * - $link_instagram
 * - $link_linkedin
 * - $link_youtube
 * - $link_tiktok
 */

$brand_logo_footer   = get_post_meta($brand_id, 'brand_logo_footer', true);
$brand_logo_footer_base64 = image_id_to_base64($brand_logo_footer);
$link_facebook   = get_post_meta($brand_id, 'link_facebook_', true);
$link_instagram   = get_post_meta($brand_id, 'link_instagram', true);
$link_linkedin   = get_post_meta($brand_id, 'link_linkedin', true);
$link_youtube   = get_post_meta($brand_id, 'link_youtube', true);
$link_tiktok   = get_post_meta($brand_id, 'link_tiktok', true);
$icon_fb = get_stylesheet_directory_uri() . '/assets/icons/fb.png';
$icon_instagram = get_stylesheet_directory_uri() . '/assets/icons/instagram.png';
$icon_linkedin = get_stylesheet_directory_uri() . '/assets/icons/linkedin.png';
$icon_youtube = get_stylesheet_directory_uri() . '/assets/icons/youtube.png';
$icon_tiktok = get_stylesheet_directory_uri() . '/assets/icons/tiktok.png';
$icon_fb_datauri = file_or_url_to_data_uri($icon_fb);
$icon_instagram_datauri = file_or_url_to_data_uri($icon_instagram);
$icon_linkedin_datauri = file_or_url_to_data_uri($icon_linkedin);
$icon_youtube_datauri = file_or_url_to_data_uri($icon_youtube);
$icon_tiktok_datauri = file_or_url_to_data_uri($icon_tiktok);

?>

<table width="100%" cellpadding="0" cellspacing="0" style="width:100%; box-sizing:border-box; padding:0px 30px 0px 30px; border-top:1px solid #000;">
    <tr>
        <!-- LOGO A LA IZQUIERDA -->
        <td colspan="<?php echo $icon_count; ?>" style="text-align:left; vertical-align:bottom; padding-top:10px;">
            <?php if (!empty($brand_logo_footer_base64)): ?>
                <img src="<?php echo $brand_logo_footer_base64; ?>" alt="Logo" style="height:52px; max-height:128px; object-fit:contain;">
            <?php endif; ?>
        </td>

       <td style="text-align:right; vertical-align:bottom; padding-top:10px;">
            <?php 
            $social_links = [
                'facebook'  => [$link_facebook, $icon_fb_datauri],
                'instagram' => [$link_instagram, $icon_instagram_datauri],
                'youtube'   => [$link_youtube, $icon_youtube_datauri],
                'linkedin'  => [$link_linkedin, $icon_linkedin_datauri],
                'tiktok'    => [$link_tiktok, $icon_tiktok_datauri],
            ];
            // Filtramos solo los que existen
            $active_social_links = array_filter($social_links, function($item) {
                return !empty($item[0]);
            });
            // Contamos los iconos activos
            $icon_count = count($active_social_links);
            ?>            
            <table cellpadding="0" cellspacing="0" style="display:inline-table; text-align:right;">
                <?php if (!empty($site_url) && $icon_count > 0): ?>
                <tr>
                    <td colspan="<?php echo $icon_count; ?>" style="font-size:11px; padding-bottom:4px; text-align:right;">
                        <?php echo wp_kses_post($site_url); ?>
                    </td>
                </tr>
                <?php endif; ?>
                
                <tr>
                    <?php foreach ($active_social_links as $key => [$link, $icon_datauri]): ?>
                        <td style="width:25px; height:20px; text-align:center; vertical-align:middle;">
                            <a href="<?php echo esc_url($link); ?>" style=" display:inline-block; width:16px; height:16px; background:url('<?php echo $icon_datauri; ?>') no-repeat center center; background-size:contain;"> </a>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </td>
    </tr>
</table>
