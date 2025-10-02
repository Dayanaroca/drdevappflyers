<?php

/**
 * Reusable button
 *
 * @param string $text Button text
 * @param string $url URL to which the button points
 * @param string $aria Accessibility text (aria-label)
 */
function drdev_button($class, $text, $aria = null, $extra_attrs = '', $id = null, $icon = null) {
    $aria_label = $aria ? "aria-label='" . esc_attr($aria) . "'" : "";
    $id_attr    = $id ? "id='" . esc_attr($id) . "'" : "";
    $icon_html = $icon ? "{$icon}" : "";

    return "<button class='{$class} inline-flex items-center gap-2' role='button' {$aria_label} {$id_attr} {$extra_attrs}>"
           . "<span>" . esc_html($text) . "</span>"
           . $icon_html
           . "</button>";
}
/**
* Decorative image
*
* @param string $src Image URL.
* @param string $class Optional CSS classes for styling (e.g., "w-full h-auto").
* @param string $width Optional width (for loading optimization).
* @param string $height Optional height (for loading optimization).
*
* @return string HTML <img>
*/
function drdev_image_decorative($src, $class = '', $id = '', $width = '', $height = '') {
    if (empty($src)) {
        return '';
    }

    $full_src = esc_url(get_template_directory_uri() . $src);

    $class  = $class ? ' class="' . esc_attr($class) . '"' : '';
    $id     = $id ? ' id="' . esc_attr($id) . '"' : '';
    $width  = $width ? ' width="' . intval($width) . '"' : '';
    $height = $height ? ' height="' . intval($height) . '"' : '';

    return sprintf(
        '<img src="%s" alt="" role="presentation" aria-hidden="true" loading="lazy" decoding="async"%s%s%s%s>',
        $full_src,
        $class,
        $id,
        $width,
        $height
    );
}
function drdev_link($class, $text, $url = '#', $aria = null, $extra_attrs = '', $id = null, $icon = null) {
    $aria_label = $aria ? "aria-label='" . esc_attr($aria) . "'" : "";
    $id_attr    = $id ? "id='" . esc_attr($id) . "'" : "";
    $icon_html = $icon ? "{$icon}" : "";
    return "<a href='" . esc_url($url) . "' class='{$class} inline-flex items-center gap-2' role='button' {$aria_label} {$id_attr} {$extra_attrs}>"
           . $icon_html
           . "<span>" . esc_html($text) . "</span>"
           . "</a>";
}
/**
 * Accessible and SEO-friendly image
 *
 * @param string $src Image URL (relative to theme directory).
 * @param string $alt Descriptive alternative text (required).
 * @param string $class Optional CSS classes for styling.
 * @param string $id Optional HTML ID attribute.
 * @param string $width Optional width for optimization.
 * @param string $height Optional height for optimization.
 * @param string $title Optional title attribute (for tooltips/SEO).
 *
 * @return string HTML <img> tag
 */
function drdev_image($src, $alt, $class = '', $id = '', $width = '', $height = '', $title = '') {
    if (empty($src) || empty($alt)) {
        return '';
    }

    $full_src = esc_url(get_template_directory_uri() . $src);

    $class  = $class ? ' class="' . esc_attr($class) . '"' : '';
    $id     = $id ? ' id="' . esc_attr($id) . '"' : '';
    $width  = $width ? ' width="' . intval($width) . '"' : '';
    $height = $height ? ' height="' . intval($height) . '"' : '';
    $title  = $title ? ' title="' . esc_attr($title) . '"' : '';

    return sprintf(
        '<img src="%s" alt="%s"%s%s%s%s%s loading="lazy" decoding="async">',
        $full_src,
        esc_attr($alt),
        $title,
        $class,
        $id,
        $width,
        $height
    );
}

