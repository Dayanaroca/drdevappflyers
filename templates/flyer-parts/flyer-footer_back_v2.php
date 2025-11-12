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

?>

<table width="100%" cellpadding="0" cellspacing="0" style="width:100%; box-sizing:border-box; padding:0px;">
    <tr style="background:#EFEFEF;">
        <?php if (!empty($inf_footer_col1)): ?>
        <td  style="text-align:left; vertical-align:top; padding:7px 10px 7px 30px; width:238px">
            <div style="font-weight:normal; line-height:1.3; max-height:4em; overflow:hidden;">
                <?php echo wp_kses_post( $inf_footer_col1 ); ?>
            </div>
        </td>
        <?php endif; ?>
        <?php if (!empty($inf_footer_col2)): ?>
        <td  style="text-align:left; vertical-align:top; padding:7px 10px 7px 10px; width:238px">
            <div style="font-weight:normal; line-height:1.3; max-height:4em; overflow:hidden;">
                <?php echo wp_kses_post($inf_footer_col2); ?>
            </div>
        </td>
        <?php endif; ?>
        <?php if (!empty($inf_footer_col3)): ?>
        <td  style="text-align:left; vertical-align:top; padding:7px 30px 7px 10px; width:238px">
            <div style="font-weight:normal; line-height:1.3; max-height:4em; overflow:hidden;">
                <?php echo wp_kses_post($inf_footer_col3); ?>
            </div>
        </td>
        <?php endif; ?>  
    </tr>
    <tr>
         <td colspan="3" style="padding:0; margin:0;">
            <?php include locate_template('templates/flyer-parts/flyer-footer_back.php'); ?>
        </td>
    </tr>
</table>
