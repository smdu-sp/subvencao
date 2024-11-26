<?php
/*
Template Name: Home
*/

$botoes = get_fields();
get_header();

?>

<div class="container-mapa">
</div>

<div class="container-paginas">
<?php foreach ($botoes as $botao) {
    if ($botao['ativado']) { ?>
        <div class="botao-pagina">
            <a href="<?= $botao['url'] ?>">
                <img src="<?= $botao['imagem']['url'] ?>" alt="<?= $botao['texto_1'] ?> <?= $botao['texto_2'] ?>">
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

<?php

get_footer();
