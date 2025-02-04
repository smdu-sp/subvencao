<?php
/*
Template Name: Home
*/

$botoes = get_field('botoes');
$introducao = get_field('introducao');
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
    <div class="introducao">
        <?php echo wpautop($introducao); ?>
    </div>
    <div id="container-mapa">
        <div class="legenda">
            <ul>
                <li>
                    <div class="leg-aiu"></div> AIU Setor Central
                </li>
                <li>
                    <div class="leg-requalifica"></div> Requalifica Centro
                </li>
            </ul>
        </div>
    </div>
</div>

<?php

get_footer();
