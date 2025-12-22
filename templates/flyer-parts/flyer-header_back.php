<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Header back
 * Variables:
 * - $post_id
 * - $bg_header_back
 */


$bg_header_back = get_post_meta($post_id, 'bg_header_back', true); // ID 
$bg_base64_back = image_id_to_base64_safe($bg_header_back); 
?>
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin:0; padding:0; width:100%;">
    <tr style="padding:0; margin:0; height:207px;">
        <td style="padding:0; margin:0;">
            <?php if (!empty($bg_base64_back)): ?>
                <div style="position:relative; width:100%; height:207px; overflow:hidden; background-image: url('<?php echo get_attached_file($bg_header_back); ?>'); background-size:cover; background-position:center center; background-repeat:no-repeat;">
                </div>
            <?php else: ?>
                <p class="drdev-error">
                    <?= esc_html__('Se ha seleccionado la plantilla con imagen de encabezado para esta página, pero el archivo no es válido o no se ha establecido correctamente.', 'drdevsalaprensa'); ?>
                </p>
            <?php endif; ?>
        </td>
    </tr>
</table>

