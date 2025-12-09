<?php 
if (!defined('ABSPATH')) exit;

/**
 * Calculate content space for itinerary
 */
function calculate_available_height($post_id, $template_selected) {
    $base_heights_mm = [
        1 => 55,
        2 => 71,
        3 => 87
    ];
    
    $header_height_mm = ($base_heights_mm[$template_selected] ?? 55);
    $descriptions_height_mm = calculate_descriptions_real_height($post_id);
    $margins_mm = 4;
    $page_height_mm = 279;
    $available_height_mm = $page_height_mm - $header_height_mm - $descriptions_height_mm - $margins_mm;
    $available_height_px = $available_height_mm * 3.78;

    return max(20 * 3.78, $available_height_px);
}

function calculate_descriptions_real_height($post_id) {
    $description = get_post_meta($post_id, 'description', true);

    if (empty($description)) {
        return 0;
    }

    $line_height_px = 16;
    $chars_per_line = 100;
    $padding_top = 45;
    $padding_bottom = 45;
    $base_height = $padding_top + $padding_bottom;
    $clean_text = strip_tags($description);
    $total_chars = mb_strlen($clean_text);
    $lines = ceil($total_chars / $chars_per_line);
    $height = $base_height + ($lines * $line_height_px);

    return $height / 3.78;
}

function split_tables_by_available_height($html, $available_height_px) {
    if (trim($html) === '') return ['', ''];

    preg_match_all('/(<table\b[^>]*>.*?<\/table>)/is', $html, $matches);
    $tables = $matches[0];
    if (empty($tables)) return [$html, ''];

    $part1 = '';
    $part2 = '';
    $used_height = 0;
    $effective_available_height = $available_height_px - 15;

    foreach ($tables as $idx => $table_html) {
        $table_height = calculate_table_height($table_html);
        
        if (($used_height + $table_height) <= $effective_available_height) {
            $part1 .= $table_html;
            $used_height += $table_height;
            error_log("✓ Day " . ($idx + 1) . " added to page 1");
        } else {
            $part2 = implode('', array_slice($tables, $idx));
            error_log("✗ From Day " . ($idx + 1) . " onwards moved to page 2");
            break;
        }
    }

    return [trim($part1), trim($part2)];
}

function calculate_table_height($table_html) {
    $text = strip_tags($table_html);
    $len = mb_strlen($text);
    $approx_lines = ceil($len / 80);
    return ($approx_lines * 10) + 20;
}

function fine_tune_itinerary_split($part1, $part2, $available_height_px) {
    if (empty(trim($part2))) {
        return [$part1, $part2];
    }

    preg_match_all('/(<table[^>]*>.*?<\/table>)/is', $part1, $tables1);
    preg_match_all('/(<table[^>]*>.*?<\/table>)/is', $part2, $tables2);

    $days_part1 = count($tables1[0]);
    $days_part2 = count($tables2[0]);

    return [$part1, $part2];
}