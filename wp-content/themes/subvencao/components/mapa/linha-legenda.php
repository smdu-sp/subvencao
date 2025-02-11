<?php

$classe = "leg-$linha[tipo_feature]";
$style = "width: {$linha['icone']['largura']}px; ";
$style .= "height: {$linha['icone']['altura']}px; ";
$style .= "background-color: {$linha['icone']['cor']}; ";
if ($linha['borda']['possui_borda']) {
    $style .= "border: {$linha['borda']['tamanho']}px solid {$linha['borda']['cor']}; ";
}

if ($linha['tipo_feature'] == 'point') {
    $style .= 'border-radius: 50%; ';
}

?>

<tr>
    <th aria-hidden="true">
        <div class="<?= $classe ?>" style="<?= $style ?>"></div>
    </th>
    <td>
        <span class="leg-label">
            <?= $linha['label'] ?>
        </span>
    </td>
</tr>
