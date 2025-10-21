<?php

// Verifica se existe valor pago
$existeValor = $subvencionado['subvencao']['pago'] && is_numeric($subvencionado['subvencao']['pago'][0]);

?>

<div class="container-subvencionado">
    <div class="subvencionado">
        <h3 class="subvencionado-nome">
            <?= $subvencionado['empreendimento']['nome'] ?>
        </h3>
        <div class="subvencionado-info">
            <span>
                <?= $chamamento['chamamento']['processo']['label'] ?>
            </span>
            <span>
                <?= $subvencionado['imovel']['endereco'] ?> - <?= $subvencionado['imovel']['bairro'] ?>, São Paulo/SP.
            </span>
            <span>
                Responsável pelo imóvel: <?= $subvencionado['empreendimento']['responsavel'] ?>
            </span>
            <?php if ($subvencionado['empreendimento']['cnpj']) { ?>
                <span>
                    CNPJ: <?= $subvencionado['empreendimento']['cnpj'] ?>
                </span>
            <?php } ?>
            <?php if ($chamamento['chamamento']['tabela_pontuacao']) { ?>
                <span>
                    <a href="<?= $chamamento['chamamento']['tabela_pontuacao'] ?>">Tabela de Pontuação</a>
                </span>
            <?php } ?>
            <?php if ($subvencionado['imovel']['plano_urbanistico']) { ?>
                <span>
                    <a href="<?= $subvencionado['imovel']['plano_urbanistico'] ?>">Plano Urbanístico</a>
                </span>
            <?php } ?>
        </div>
        <div class="subvencionado-valores">
            <div class="subvencionado-box">
                <span class="subtitulo">Pontuação</span>
                <span class="valor"><?= $subvencionado['subvencao']['pontuacao'] ?></span>
            </div>
            <div class="subvencionado-box">
                <span class="subtitulo">% Subvenção</span>
                <span class="valor"><?= $subvencionado['subvencao']['pct'] ?>%</span>
            </div>
            <div class="subvencionado-box <?= $existeValor ? '' : 'sem-valor' ?>">
                <span class="subtitulo">Valor da Subvenção</span>
                <span class="valor valor-subvencao">R$ <?= $subvencionado['subvencao']['valor'] ?></span>
            </div>
            <?php if ($existeValor) { ?>
                <div class="subvencionado-box">
                    <span class="subtitulo">Valor pago</span>
                    <span class="valor valor-pago">R$ <?= $subvencionado['subvencao']['pago'] ?></span>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
