<?php
if (!defined('ABSPATH')) exit;
/**
 * Variables:
 * - $post_id
 * - $itinerary
 */

$itinerary = get_field('itinerary', $post_id);
if ( empty($itinerary['date']) ) {
    return;
}

?>
<table width="100%" cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; box-sizing:border-box; padding:0px 45px 0 45px;">
    <tr>
        <td style="text-align:left; vertical-align:top;">
            <span style="font-size:14px; color:<?php echo $brand_color; ?>; font-weight:700; line-height:15px;">
                <?php echo esc_html__('Itinerario', 'drdevflyers'); ?>
            </span>
        </td>
    </tr>
    <tr><td style="border-bottom:1px solid #000; height:6px;"></td></tr>
</table>

<?php
// Por cada día, creamos una tabla separada
foreach ( $itinerary['date'] as $index => $day ) :

    $title = isset($day['itinerary_title']) ? $day['itinerary_title'] : '';
    $desc  = isset($day['itinerary_description']) ? $day['itinerary_description'] : '';

    // Cada día va en su propia tabla completa
    ?>
    <table width="100%" cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; box-sizing:border-box; padding:0px 45px 0 45px; margin-bottom:6px;">
        <tr>
            <td style="vertical-align:top; font-size:13px; color:#000; padding-top:10px; line-height:14px;">
                <?php if ( ! empty( $title ) ) : ?>
                    <div style="font-weight:700; margin-bottom:3px; color:<?php echo $brand_color; ?>">
                        <?php echo esc_html( $title ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $desc ) ) : ?>
                    <div style="font-weight:normal; line-height:14px;">
                        <?php echo wp_kses_post( $desc ); ?>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
    </table>
<?php
endforeach;
?>