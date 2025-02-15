<?php

// Resgata as cores da legenda do mapa
$home = get_page_by_path('home');
$cores = Array();

$legenda = get_field('mapa_legenda', $home);
$pontos = array_filter($legenda, function ($value) {
    return $value['tipo_feature'] == 'point';
}, ARRAY_FILTER_USE_BOTH);

foreach ($pontos as $key => $ponto) {
    $index = $ponto['ordem_feature'];
    $cor = $ponto['icone']['cor'];
    $cores[$index] = $cor;
}
