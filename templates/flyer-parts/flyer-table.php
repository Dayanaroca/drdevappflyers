<?php
if (!defined('ABSPATH')) exit;
/**
 * Component: Table
 * Variables:
 * - $post_id
 * - $table_of_contents
 */


$table_of_contents = get_field('table_of_contents', $post_id);

if (empty($table_of_contents)) {
    return; // no hay datos
}

$headers = [];
$columns_data = [];

// Iteramos las columnas posibles
for ($i = 1; $i <= 4; $i++) {
    $col_key = "column_{$i}";
    if (!empty($table_of_contents[$col_key])) {
        $col = $table_of_contents[$col_key]; // grupo
        $title_key = 'title';
        $repeater_key = "contents_{$i}"; // repetidor
        $subfield_key = "column_{$i}_contents"; // WYSIWYG dentro del repetidor

        // Guardamos el header
        $headers[$i] = isset($col[$title_key]) ? $col[$title_key] : '';

        // Guardamos los contenidos de la columna
        if (!empty($col[$repeater_key])) {
            $columns_data[$i] = [];
            foreach ($col[$repeater_key] as $row) {
                $columns_data[$i][] = isset($row[$subfield_key]) ? $row[$subfield_key] : '';
            }
        } else {
            $columns_data[$i] = [];
        }
    }
}

// Determinar el número máximo de filas
$max_rows = 0;
foreach ($columns_data as $col) {
    if (count($col) > $max_rows) $max_rows = count($col);
}

// Generar la tabla
?>
<table width="100%" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse; border-collapse:collapse; box-sizing:border-box; padding:10 30px 10 30px;">
    <tr>
        <?php foreach ($headers as $header): ?>
            <td style="background:#EFEFEF; vertical-align:middle; text-align:center; padding:5px; font-size: 11px; font-weight: 600;">
                <?php echo esc_html($header); ?>
            </td>
        <?php endforeach; ?>
    </tr>

    <?php for ($row = 0; $row < $max_rows; $row++): ?>
        <tr>
            <?php for ($col_num = 1; $col_num <= count($headers); $col_num++): ?>
                <?php
                $cell_content = isset($columns_data[$col_num][$row]) ? $columns_data[$col_num][$row] : '';
                ?>
                <td style="vertical-align:middle; text-align:center; padding:5px; font-size: 10px; font-weight: 400;">
                    <?php echo wp_kses_post($cell_content); ?>
                </td>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
</table>