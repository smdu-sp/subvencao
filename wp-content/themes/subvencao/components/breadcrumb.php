<?php

$cor = get_field('cor');
?>

<div id="breadcrumb" class="bg-<?= $cor ?>">
    <a class="botao-voltar" href="/">
        <div class="seta-voltar"><?= carregar_svg('arrow-left') ?></div>
        <span class="texto-voltar">voltar à página inicial</span>
    </a>
    <div class="titulo-interna">
        <h1><?= get_the_title() ?></h1>
    </div>
</div>

<style>
:root {
    --corDaPagina: var(--<?= $cor ?>);

}
</style>
