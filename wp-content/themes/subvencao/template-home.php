<?php
/*
Template Name: Home
*/

$botoes = get_field('botoes');
get_header();

?>

<div class="container-paginas">
    <?php
    if (count($botoes)) {
        foreach ($botoes as $botao) { ?>
            <div class="botao-pagina">
                <a href="<?= $botao['url'] ?>">
                    <div class="container-titulo-pagina">
                        <?php if ($botao['texto_1']) { ?>
                            <span class="titulo_1"><?= $botao['texto_1'] ?></span>
                        <?php } ?>
                        <?php if ($botao['texto_2']) { ?>
                            <span class="titulo_2"><?= $botao['texto_2'] ?></span>
                        <?php } ?>
                    </div>
                </a>
            </div>
    <?php }
    } ?>
</div>

<div class="container-conteudo">
    <?php require_once 'components/mapa/sidebar.php' ?>
    <div id="container-mapa">
        <?php require_once 'components/mapa/legenda.php' ?>
    </div>
</div>

<?php

get_footer();
