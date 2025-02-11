<?php

$legenda = get_field('mapa_legenda');
$poligonos = array_filter($legenda, function ($value) {
    return $value['tipo_feature'] == 'polygon';
});
$pontos = array_filter($legenda, function ($value) {
    return $value['tipo_feature'] == 'point';
}, ARRAY_FILTER_USE_BOTH);
?>
<div class="legenda">
    <table>
        <thead>
            <tr>
                <th colspan=2>Legenda</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (count($poligonos)) {
            foreach ($poligonos as $key => $linha) {
                include 'linha-legenda.php';
            }
        }

        if (count($pontos)) {
            foreach ($pontos as $key => $linha) {
                include 'linha-legenda.php';
            }
        }
        ?>
        </tbody>
    </table>
</div>
