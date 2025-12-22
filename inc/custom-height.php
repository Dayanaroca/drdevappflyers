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
    //$page1_bottom_padding_px = 10;
    //$page1_bottom_padding_mm = $page1_bottom_padding_px / 3.78;
    //$available_height_mm = $page_height_mm - $header_height_mm - $descriptions_height_mm - $margins_mm - $page1_bottom_padding_mm;
    $available_height_mm = $page_height_mm - $header_height_mm - $descriptions_height_mm - $margins_mm;
    $available_height_px = $available_height_mm * 3.78;
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
    libxml_use_internal_errors(true);

    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->loadHTML(
        '<!DOCTYPE html><html><body>'.$table_html.'</body></html>',
        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
    );
    $xpath = new DOMXPath($dom);

    $height = 0;

    // Parámetros REALISTAS para Dompdf
    $chars_per_line = 55;      // clave
    $line_height_px = 14;      // Dompdf suele renderizar >14
    $paragraph_margin = 4;

    // Párrafos
    foreach ($xpath->query('//p') as $p) {
        $text = trim($p->textContent);
        if ($text === '') continue;
        $length = mb_strlen($text);
        $lines  = ceil($length / $chars_per_line);

       if ($length > 300) {
            $compression = min(0.80, 1 - ($length / 6000));
            $lines *= $compression;
        }
        
        $height += ($lines * $line_height_px) + $paragraph_margin;
    }

    // <br>
    $brs = $xpath->query('//br');
    $height += $brs->length * $line_height_px;

    // Listas
    foreach ($xpath->query('//li') as $li) {
        $text = trim($li->textContent);
        $lines = ceil(mb_strlen($text) / $chars_per_line);
        $height += ($lines * $line_height_px) + 4;
    }

    // Títulos dentro de la tabla
    foreach ($xpath->query('//strong') as $strong) {
        $height += 3;
    }

    // Padding / respiración GENERAL de la tabla
    $height += 10;
    // Respiración final SOLO si la tabla es muy larga
    if ($height > 300) {
        $height -= 6;
    }
    error_log("Table height calculated: ".$height);


    return $height;
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