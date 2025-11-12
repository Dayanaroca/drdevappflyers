<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Included / Not included
 * Variables:
 * - $post_id
 * - $items_included
 * - $items_not_included
 * - $flyer_observations
 */

$items_included       = get_field('items_included', $post_id);        // repeater
$items_not_included   = get_field('items_not_included', $post_id);    // repeater
$flyer_observations   = get_field('flyer_observations', $post_id);    // wysiwyg
$two_columns_option   = get_field('flyer_included_two_columns', $post_id); // checkbox

if ( empty($items_included) && empty($items_not_included) && empty($flyer_observations) ) {
    return;
}

if (isset($two_columns_override)) {
    $two_columns = $two_columns_override;
} else {
    $two_columns = ($two_columns_option === 'Mostrar en dos columnas');
}


$icon_included = get_stylesheet_directory_uri() . '/assets/icons/check.png'; 
$icon_not_included = get_stylesheet_directory_uri() . '/assets/icons/not_check.png';

$icon_included_datauri = file_or_url_to_data_uri($icon_included);
$icon_not_included_datauri = file_or_url_to_data_uri($icon_not_included);
?>

<?php if (!$two_columns): ?>
<!-- UNA COLUMNA -->
<table width="100%" cellpadding="0" cellspacing="0" style="width:100%; padding:10px 30px 10px 30px; border-collapse:collapse;">
    <?php if (!empty($items_included)): ?>
    <tr>
        <td style="font-family:'Inter', sans-serif; font-size:11px; line-height:1.3; vertical-align:top; font-weight:500; padding:4px 0;">
            <div style="font-weight:700; margin-bottom:4px; font-size:11px;">
                <?php esc_html_e('Incluye', 'drdevcustomlanguage'); ?>
            </div>
            <?php foreach ($items_included as $row): ?>
                <div style="margin-bottom:3px; display:flex; align-items:flex-start;">
                    <img src="<?php echo $icon_included_datauri; ?>" width="11" height="11" style="margin-right:4px; vertical-align:middle;">
                    <span style="vertical-align:top; font-weight:normal;"><?php echo wp_kses_post($row['include']); ?></span>
                </div>
            <?php endforeach; ?>
        </td>
    </tr>
    <?php endif; ?>

    <?php if (!empty($items_not_included)): ?>
    <tr>
        <td style="font-family:'Inter', sans-serif; font-size:11px; line-height:1.3; vertical-align:top; font-weight:500; padding-top:6px;">
            <div style="font-weight:700; margin-bottom:4px; font-size:11px;">
                <?php esc_html_e('No Incluye', 'drdevcustomlanguage'); ?>
            </div>
            <?php foreach ($items_not_included as $row): ?>
                <div style="margin-bottom:3px; display:flex; align-items:flex-start;">
                    <img src="<?php echo $icon_not_included_datauri; ?>" width="11" height="11" style="margin-right:4px; vertical-align:middle;">
                    <span style="vertical-align:top; font-weight:normal;"><?php echo esc_html($row['not_include']); ?></span>
                </div>
            <?php endforeach; ?>
        </td>
    </tr>
    <?php endif; ?>

    <?php if (!empty($flyer_observations)): ?>
    <tr>
        <td style="font-family:'Inter', sans-serif; font-size:11px; line-height:1.3; vertical-align:top; padding-top:8px;">
            <div style="font-weight:700; margin-bottom:4px; font-size:11px;">
                <?php esc_html_e('Observaciones', 'drdevcustomlanguage'); ?>
            </div>
            <div style="font-size:10px; font-weight:normal;"><?php echo wp_kses_post($flyer_observations); ?></div>
        </td>
    </tr>
    <?php endif; ?>
</table>

<?php else: ?>
<!-- DOS COLUMNAS -->
<table width="100%" cellpadding="0" cellspacing="0" style="width:100%; padding:10px 30px 10px 30px; border-collapse:collapse;">
    <tr>
        <!-- Columna Izquierda: Incluye + Observaciones -->
        <td width="50%" style="font-family:'Inter', sans-serif; font-size:11px; line-height:1.3; vertical-align:top; font-weight:500; padding:4px 0;">
            <?php if (!empty($items_included)): ?>
                <div style="font-weight:700; margin-bottom:4px; font-size:11px;"><?php esc_html_e('Incluye', 'drdevcustomlanguage'); ?></div>
                <?php foreach ($items_included as $row): ?>
                    <div style="margin-bottom:3px; display:flex; align-items:flex-start;">
                        <img src="<?php echo $icon_included_datauri; ?>" width="11" height="11" style="margin-right:4px; vertical-align:middle;">
                        <span style="vertical-align:top; font-weight:normal;"><?php echo esc_html($row['include']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($flyer_observations)): ?>
                <div style="height:6px;"></div>
                <div style="font-weight:700; margin-bottom:4px; font-size:11px;"><?php esc_html_e('Observaciones', 'drdevcustomlanguage'); ?></div>
                <div style="font-size:10px; font-weight:normal;"><?php echo wp_kses_post($flyer_observations); ?></div>
            <?php endif; ?>
        </td>

        <!-- Columna Derecha: No Incluye -->
        <td width="50%" style="font-family:'Inter', sans-serif; font-size:11px; line-height:1.3; vertical-align:top; font-weight:500; padding:4px 0;">
            <?php if (!empty($items_not_included)): ?>
                <div style="font-weight:700; margin-bottom:4px; font-size:11px;"><?php esc_html_e('No Incluye', 'drdevcustomlanguage'); ?></div>
                <?php foreach ($items_not_included as $row): ?>
                    <div style="margin-bottom:3px; display:flex; align-items:flex-start;">
                        <img src="<?php echo $icon_not_included_datauri; ?>" width="11" height="11" style="margin-right:4px; vertical-align:middle;">
                        <span style="vertical-align:top; font-weight:normal;"><?php echo esc_html($row['not_include']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </td>
    </tr>
</table>
<?php endif; ?>

