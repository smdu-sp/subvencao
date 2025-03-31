<?php
/*
Template Name: Inscrições
*/

get_header();

$fields = get_fields();
$introducao = $fields['introducao'];
$instrucoes = $fields['instrucoes'];

?>

<div class="container-inscricoes">
    <div class="introducao-inscricoes">
        <h2 class="titulo-inscricoes">
            <?= $introducao['titulo'] ?>
        </h2>
        <?= $introducao['texto'] ?>
        <?php
        if ($introducao['botao']['url']) { ?>
            <div class="botao-externo">
                <a href="<?= $introducao['botao']['url'] ?>">
                    <span>
                        <?= $introducao['botao']['label'] ?> <?= carregar_svg('external-link') ?>
                    </span>
                </a>
            </div>
        <?php }
        ?>
    </div>
    <div class="instrucoes-inscricoes">
        <h2 class="subtitulo-inscricoes">
            <?= $instrucoes['titulo'] ?>
        </h2>
        <?= $instrucoes['texto'] ?>
    </div>
</div>

<?php

get_footer();
