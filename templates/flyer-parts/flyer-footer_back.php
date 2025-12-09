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



// --- Iconos sociales ---
$theme_uri = get_stylesheet_directory_uri();
$icons = [
    'facebook'  => $theme_uri . '/assets/icons/fb.png',
    'instagram' => $theme_uri . '/assets/icons/instagram.png',
    'linkedin'  => $theme_uri . '/assets/icons/linkedin.png',
    'youtube'   => $theme_uri . '/assets/icons/youtube.png',
    'tiktok'    => $theme_uri . '/assets/icons/tiktok.png',
];

// --- Convertir a Data URI si existe la función ---
foreach ($icons as $key => $url) {
    $icons[$key] = function_exists('file_or_url_to_data_uri') ? file_or_url_to_data_uri($url) : $url;
}

// --- Construir array de enlaces activos ---
$social_links = [
    'facebook'  => [$contact['facebook'], $icons['facebook']],
    'instagram' => [$contact['instagram'], $icons['instagram']],
    'linkedin'  => [$contact['linkedin'], $icons['linkedin']],
    'youtube'   => [$contact['youtube'], $icons['youtube']],
    'tiktok'    => [$contact['tiktok'], $icons['tiktok']],
];

$active_social_links = array_filter($social_links, fn($item) => !empty($item[0]));
$icon_count = max(1, count($active_social_links));
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
                    
            <table cellpadding="0" cellspacing="0" style="display:inline-table; text-align:right;">
                <?php if (!empty(esc_url($contact['site_url'])) && $icon_count > 0): ?>
                <tr>
                    <td colspan="<?php echo $icon_count; ?>" style="font-size:11px; padding-bottom:4px; text-align:right;">
                        <?php echo esc_url($contact['site_url']); ?>
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
