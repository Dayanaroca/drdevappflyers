<?php
if (!defined('ABSPATH')) exit;

/**
 * Función para convertir ID de imagen a Base64 
 */
function image_id_to_base64($id) {
    if (!$id) return '';
    $path = get_attached_file($id);
    if (!file_exists($path)) return '';
    $type = mime_content_type($path);
    $data = file_get_contents($path);
    return 'data:' . $type . ';base64,' . base64_encode($data);
}

/**
 * ID to local route
 */
function file_or_url_to_data_uri($source) {
    if (is_numeric($source) && intval($source) > 0) {
        $path = get_attached_file(intval($source));
        if (!$path || !file_exists($path)) return '';
    } else {
        // If a theme URL is included (http(s)://.../wp-content/...)  map URL to absolute path.
        $src = (string) $source;

        if (strpos($src, '://') === false && file_exists($src)) {
            $path = $src;
        } else {
            // Has http/https scheme -> try to convert URL to server path
            $home = trailingslashit( home_url() );
            $stylesheet_uri = trailingslashit( get_stylesheet_directory_uri() );
            $stylesheet_dir = trailingslashit( get_stylesheet_directory() );

            // Replace theme URL with physical theme path
            if (strpos($src, $stylesheet_uri) === 0) {
                $path = $stylesheet_dir . substr($src, strlen($stylesheet_uri));
            } else {
                // As a fallback try replacing home_url() with ABSPATH
                $home_url = trailingslashit( home_url() );
                if (strpos($src, $home_url) === 0) {
                    $relative = substr($src, strlen($home_url));
                    $path = ABSPATH . $relative;
                } else {
                    return $src;
                }
            }
        }

        if (!isset($path) || !file_exists($path)) {
            return '';
        }
    }

    $mime = mime_content_type($path) ?: 'application/octet-stream';
    $data = file_get_contents($path);
    if ($data === false) return '';
    return 'data:' . $mime . ';base64,' . base64_encode($data);
}