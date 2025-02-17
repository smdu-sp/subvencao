<?php

// Resgata os termos de outorga da página de Transparência
$transparencia = get_page_by_path('transparencia');
$subvencionados = get_field('subvencionados', $transparencia);
$termosOutorga = array();

foreach ($subvencionados as $key => $dados) {
    $chamamento = $dados['chamamento'];
    $subvencionado = $dados['subvencionado'];
    $responsavel = $subvencionado['empreendimento']['responsavel'];
    $termoOutorga = $chamamento['termo_de_outorga'];
    $chamamentoValor = $chamamento['processo']['value'];
    $ordem = str_pad($chamamento['ordem'], 3, '0', STR_PAD_LEFT);
    $id = $chamamentoValor . $ordem;

    $termosOutorga[$id] = "$termoOutorga - $responsavel";
}
