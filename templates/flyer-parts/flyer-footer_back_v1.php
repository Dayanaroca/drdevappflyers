<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Footer Back end V1
 * Variables:
 * - $brand_phone
 * - $brand_email
 * - $others_links
 * - $product_hashtag
 */

$brand_phone   = get_post_meta($brand_id, 'phone', true);
$brand_email   = get_post_meta($brand_id, 'email', true);
$others_links = get_post_meta($brand_id, 'others_links', true); $contact['site_url']
?>

<table width="100%" cellpadding="0" cellspacing="0" style="width:100%; box-sizing:border-box; padding:0px; border-top:1px solid #000;">
    <tr>
        <td  style="text-align:left; vertical-align:middle; padding:10px 30px 9px 30px;">
            <?php if (!empty($contact['phone'])): ?>
                <a href="tel:<?php echo preg_replace('/\s+/', '', $contact['phone']); ?>" style="display:inline-block; font-weight: 500; text-decoration:none; line-height:11px;">
                    <span style="font-weight: 500; color: #000; font-size: 11px; font-style: italic;">
                        <?php echo esc_html($contact['phone']); ?> &nbsp;&nbsp;  |
                    </span>
                </a>
            <?php endif; ?>
            <?php if (!empty($contact['email'])): ?>
                <a href="mailto:<?php echo sanitize_email($contact['email']); ?>" style="display:inline-block; font-weight: 500; text-decoration:none; line-height:11px;">
                    <span style="font-weight: 500; color: #000; font-size: 11px; font-style: italic;">
                        <?php echo esc_html($contact['email']); ?>&nbsp;&nbsp;   |
                    </span>
                </a>
            <?php endif; ?>
            <?php if (!empty($contact['others_links'])): ?>
                <a href="<?php echo  esc_url($contact['others_links']); ?>" style="display:inline-block; font-weight: 500; text-decoration:none; line-height:11px;;">
                    <span style="font-weight: 500; color: #000; font-size: 11px; font-style: italic;">
                        <?php echo esc_html($contact['others_links']); ?>
                    </span>
                </a>
            <?php endif; ?>
        </td>
        <td style="text-align:right; vertical-align:middle; padding:9px 30px 10px 30px;">
            <?php if (!empty($product_hashtag)): ?>
                <span style="font-weight: 500; color: #000; font-size: 11px; font-style: italic; line-height:13px;">
                    <?php echo esc_html($product_hashtag); ?>
                </span>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
         <td colspan="2" style="padding:0; margin:0;">
            <?php include locate_template('templates/flyer-parts/flyer-footer_back.php'); ?>
        </td>
    </tr>
</table>
