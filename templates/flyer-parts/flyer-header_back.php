<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Header back
 * Variables:
 * - $post_id
 * - $bg_header_back
 */


$bg_header_back = get_post_meta($post_id, 'bg_header_back', true); // ID 
$bg_base64_back = image_id_to_base64($bg_header_back);
?>
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin:0; padding:0; width:100%;">
    <tr style="padding:0; margin:0; height:207px;">
        <td style="padding:0; margin:0;">
            <?php if (!empty($bg_base64_back)): ?>
                <div style="position:relative; width:100%; height:207px; overflow:hidden;">
                    <img src="<?php echo esc_attr($bg_base64_back); ?>" 
                        alt="Background"
                        style="width:100%; height:100%; object-fit:cover; object-position:center; position:absolute; top:0; left:0; z-index:0; display:block;">
                </div>
            <?php else: ?>
                <p class="drdev-error">
                    <?= esc_html__('Se ha seleccionado la plantilla con imagen de encabezado para esta página, pero el archivo no es válido o no se ha establecido correctamente.', 'drdevsalaprensa'); ?>
                </p>
            <?php endif; ?>
        </td>
    </tr>
</table>

