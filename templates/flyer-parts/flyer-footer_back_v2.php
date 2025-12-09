<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Footer Back end V2
 * Variables:
 * - $inf_footer_col1
 * - $inf_footer_col2
 * - $inf_footer_col3
 */

$inf_footer_col1 = get_field('inf_footer_col1', $post_id);
$inf_footer_col2   = get_field('inf_footer_col2', $post_id);
$inf_footer_col3   = get_field('inf_footer_col3', $post_id);

$columns = [
    !empty($inf_footer_col1),
    !empty($inf_footer_col2),
    !empty($inf_footer_col3),
];

$colspan_count = count(array_filter($columns));

if (empty($brand_color) || strtolower($brand_color) === '#000' || strtolower($brand_color) === '#000000') {
    $brand_color_light = '#EFEFEF';
} else {
    $brand_color_light = lighten_color($brand_color, 10);
}

?>


<table width="100%" cellpadding="0" cellspacing="0" style="width:100%; box-sizing:border-box; padding:0;">
    <tr>
        <td colspan="<?php echo $colspan_count; ?>" 
            style="position:relative; background:<?php echo $brand_color_light; ?>; padding:0;">

            <!-- OVERLAY BLANCO ENCIMA DEL FONDO -->
            <div style="
                position:absolute; 
                top:0; left:0; 
                width:100%; height:100%; 
                background:rgba(255,255,255,0.6); 
                z-index:1;">
            </div>

            <!-- CONTENIDO REAL DEL FOOTER (encima del overlay) -->
            <table width="100%" cellpadding="0" cellspacing="0" 
                   style="position:relative; z-index:2; border-collapse:collapse;">
                <tr>
                    <?php if (!empty($inf_footer_col1)): ?>
                    <td style="text-align:left; vertical-align:top; padding:7px 10px 7px 30px; width:238px;">
                        <div style="font-size:10px; font-weight:normal; line-height:11px; max-height:6em; overflow:hidden;">
                            <?php echo wp_kses_post($inf_footer_col1); ?>
                        </div>
                    </td>
                    <?php endif; ?>

                    <?php if (!empty($inf_footer_col2)): ?>
                    <td style="text-align:left; vertical-align:top; padding:7px 10px 7px 10px; width:238px;">
                        <div style="font-size:10px; font-weight:normal; line-height:11px; max-height:6em; overflow:hidden;">
                            <?php echo wp_kses_post($inf_footer_col2); ?>
                        </div>
                    </td>
                    <?php endif; ?>

                    <?php if (!empty($inf_footer_col3)): ?>
                    <td style="text-align:left; vertical-align:top; padding:7px 30px 7px 10px; width:238px;">
                        <div style="font-size:10px; font-weight:normal; line-height:11px; max-height:6em; overflow:hidden;">
                            <?php echo wp_kses_post($inf_footer_col3); ?>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <?php if ($colspan_count > 0): ?>
        <td colspan="<?php echo $colspan_count; ?>" style="padding:0; margin:0;">
            <?php include locate_template('templates/flyer-parts/flyer-footer_back.php'); ?>
        </td>
        <?php endif; ?>
    </tr>
</table>


