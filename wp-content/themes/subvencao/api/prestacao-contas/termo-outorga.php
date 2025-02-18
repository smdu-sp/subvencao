<?php

// Resgata os termos de outorga da página de Transparência
$transparencia = get_page_by_path('transparencia');
$subvencionados = get_field('subvencionados', $transparencia);
$termosOutorga = array();

foreach ($subvencionados as $key => $dados) {
    $chamamento = $dados['chamamento'];
    $subvencionado = $dados['subvencionado'];
    $termoOutorga = $chamamento['termo_de_outorga'];

    if (! $termoOutorga) {
        continue;
    }

    $responsavel = $subvencionado['empreendimento']['responsavel'];
    $chamamentoValor = $chamamento['processo']['value'];
    $ordem = str_pad($chamamento['ordem'], 3, '0', STR_PAD_LEFT);
    $id = $chamamentoValor . $ordem;

    $termosOutorga[$id] = "$termoOutorga - $responsavel";
}

uasort($termosOutorga, function($a, $b) {
    $aAno = substr($a, 3, 4);
    $bAno = substr($b, 3, 4);

    if ($aAno != $bAno) {
        return ($aAno < $bAno) ? -1 : 1;
    }

    $aNum = substr($a, 0, 2);
    $bNum = substr($b, 0, 2);

    if ($aNum == !$bNum) {
        return 0;
    }

    return ($aNum < $bNum) ? -1 : 1;
});
