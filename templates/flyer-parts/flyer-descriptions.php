<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Descriptions
 * Variables:
 * - $description
 */

$description   = get_post_meta($post_id, 'description', true);
?>

<table width="100%" cellpadding="0" cellspacing="0" style="width:100%; box-sizing:border-box; padding:10px 30px 0px 30px;">
    <tr>
        <td style="text-align:left; vertical-align:top;">
            <?php if (!empty($description)): ?>
                <span style="font-size:13px; color:#000; font-weight: 400; line-height:14px;">
                    <?php echo wpautop( wp_kses_post($description) ); ?>
                </span>
            <?php endif; ?>
        </td>
    </tr>
</table>