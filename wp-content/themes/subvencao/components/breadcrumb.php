<?php

?>

<div id="breadcrumb">
    <div class="breadcrumb-titulo">
        <div class="titulo-interna">
            <h1><?= get_the_title() ?></h1>
        </div>
    </div>
    <div class="breadcrumb-voltar">
        <a class="botao-voltar" href="/">
            <div class="seta-voltar"><?= carregar_svg('arrow-back') ?></div>
            <span class="texto-voltar">voltar</span>
        </a>
    </div>
</div>
