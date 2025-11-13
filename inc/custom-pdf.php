<?php
if (!defined('ABSPATH')) exit;
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 120);
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M'); 

// --------------------------------------------------------------------
// Register the admin_post endpoints
// --------------------------------------------------------------------
add_action('admin_post_preview_flyer_pdf', 'handle_preview_flyer_pdf');
add_action('admin_post_export_flyer_pdf', 'handle_export_flyer_pdf');

// --------------------------------------------------------------------
// PDF PREVIEW (opens in browser)
// --------------------------------------------------------------------
function handle_preview_flyer_pdf() {
    require_once ABSPATH . 'wp-content/themes/drdevappflyers/vendor/autoload.php';

    if (empty($_GET['id'])) {
        wp_die('Post ID not specified.');
    }

    $post_id = intval($_GET['id']);
    if (!$post_id) {
        wp_die('Invalid post ID.');
    }

    $html = generate_flyer_html($post_id);
    if (empty($html)) {
        wp_die('The HTML for the flyer could not be generated.');
    }

    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true);
    $options->setChroot(get_template_directory());
    $options->set('isHtml5ParserEnabled', true);
    $options->set('dpi', 96);
    $options->setChroot(ABSPATH);
    $options->set('isPhpEnabled', true);

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->setPaper('letter', 'portrait');
    // DEBUG: salvar HTML completo para inspección
   // @file_put_contents( get_template_directory() . '/dompdf_full_debug.html', $html );

    $dompdf->loadHtml($html);   
    $dompdf->render();
    $page_count = $dompdf->getCanvas()->get_page_count();

    // if ($page_count > 2) {
    //     // Mostrar alerta y no generar PDF
    //     wp_die('El contenido excede las dos páginas. Por favor revise el contenido o cambie la plantilla.');
    // }
    $dompdf->stream('flyer-preview.pdf', ['Attachment' => false]);
    exit;
}

// --------------------------------------------------------------------
// EXPORTAR PDF (descarga el archivo)
// --------------------------------------------------------------------
function handle_export_flyer_pdf() {
    require_once ABSPATH . 'wp-content/themes/drdevappflyers/vendor/autoload.php';

    $post_id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
    if (!$post_id) {
        wp_die('Invalid post');
    }

    $brand_id          = get_post_meta($post_id, '_brand_selected', true);
    $product_name      = get_the_title($post_id);
   

    $brand_name       = get_the_title($brand_id);
   

    // Generate HTML from the templates
    ob_start();
    $front_template_file = locate_template("templates/flyer-front.php");
    if ($front_template_file) {
        $template_post_id = $post_id;
        include $front_template_file;
    }

    $html = ob_get_clean();

    if (empty($html)) {
        wp_die('The PDF content could not be generated.');
    }

    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('dpi', 96);
    $options->set('defaultFont', 'Inter');
    $options->setChroot(get_template_directory());
    $dompdf = new \Dompdf\Dompdf($options);

    $dompdf->setPaper('letter', 'portrait'); // tamaño carta
    $dompdf->loadHtml($html);
    $dompdf->render();
    $page_count = $dompdf->getCanvas()->get_page_count();

    if ($page_count > 2) {
        // Mostrar alerta y no generar PDF
        wp_die('El contenido excede las dos páginas. Por favor revise el contenido o cambie la plantilla.');
    }
    // Descargar
    $filename = sprintf('flyer-%s-%s.pdf',
        sanitize_title($product_name),
        sanitize_title($brand_name)
    );

    $dompdf->stream($filename, ['Attachment' => true]);
    exit;

}

function generate_flyer_html($post_id) {
    if (!$post_id || get_post_type($post_id) !== 'tourist-product') {
        return '';
    }

    $template_selected = get_post_meta($post_id, '_template_selected', true) ?: '1';

    ob_start();

    // include the templates
    $front_template_file = locate_template("templates/flyer-front.php");
    if ($front_template_file) {
        $template_post_id = $post_id;
        include $front_template_file;
    }

    $html = ob_get_clean();

    if (empty($html)) {
        $html = '<p>The HTML for the flyer could not be generated (templates not found).</p>';
    }

    return $html;
}
