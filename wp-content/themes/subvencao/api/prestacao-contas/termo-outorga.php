<?php

// Resgata os termos de outorga da página de Transparência
$transparencia = get_page_by_path('transparencia');
$subvencionados = get_field('subvencionados', $transparencia);
$termosOutorga = array();

foreach ($subvencionados as $key => $subvencionado) {
    $termoOutorga = $subvencionado['chamamento']['termo_de_outorga'];
    $chamamento = $subvencionado['chamamento']['processo']['value'];
    $ordem = str_pad($subvencionado['chamamento']['ordem'], 3, '0', STR_PAD_LEFT);
    $id = $chamamento . $ordem;

    $termosOutorga[$id] = $termoOutorga;
}
