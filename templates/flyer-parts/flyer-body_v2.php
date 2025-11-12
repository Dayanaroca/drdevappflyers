<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Body V2
 * Variables:
 * - $post_id
 * - $flyer_bg_side_back
 */

$flyer_bg_side_back = get_post_meta($post_id, 'flyer_bg_side_back', true); // ID 
$flyer_bg_side_back_base64 = image_id_to_base64($flyer_bg_side_back);
?>
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin:0; padding:0;">
    <tr>
        <td width="50%" style="border-collapse:collapse; margin:0; padding:0; width:50%; background-image:url('<?php echo $flyer_bg_side_back_base64; ?>'); background-size:cover; background-repeat:no-repeat; background-position:center;">
            <div style="height:100%; line-height:0; font-size:0;">&nbsp;</div>
        </td>
        <td width="50%" style="font-family:'Inter', sans-serif; font-size:11px; line-height:1.3; vertical-align:top; font-weight:500; padding:4px 0;">
            <?php if (!empty(trim($part2))) : ?>
                <?php echo $part2; ?>
            <?php endif; ?>
            <?php
            $two_columns_override = false;
            include locate_template('templates/flyer-parts/flyer-included.php');
            ?>
        </td>
    </tr>
</table>