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

<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin:0; padding:0; width:100%; background-image:url('<?php echo $bg_base64_back; ?>'); background-size:cover; background-repeat:no-repeat; background-position:center; height:207px;">
    <tr>
        <td style="padding:0; margin:0;">
        </td>
    </tr>
</table>