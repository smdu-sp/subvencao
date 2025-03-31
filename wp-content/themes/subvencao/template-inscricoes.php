<?php
/*
Template Name: Inscrições
*/

get_header();

$fields = get_fields();
$introducao = $fields['introducao'];
$botao = $fields['botao'];

echo '<pre>';
print_r($introducao['botao']);
echo '</pre>';

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
    <div class="orientacoes-inscricoes">
        <h2 class="titulo-inscricoes">
            <?= $orientacoes['titulo'] ?>
        </h2>
        <?= $orientacoes['texto'] ?>
    </div>
</div>

<?php

get_footer();
