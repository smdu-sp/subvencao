<?php
/*
Template Name: Home
*/

$botoes = get_fields();
get_header();

?>

<div id="container-mapa">
    <div class="container-introducao">
        <p class="introducao">
            Conheça os projetos beneficiados pela iniciativa <span class="introducao-destaque">Subvenção Econômica</span> prevista no Plano Urbanístico do Centro (Lei nº 17.844/2022). Regulamentada pelo Decreto nº 62.878/2023, o principal objetivo da iniciativa é <span class="introducao-destaque">fomentar a requalificação de imóveis para moradias populares na região central.</span>
        </p>
        <a href="/" class="introducao-botao" type="button" aria-label="Informações sobre a iniciativa Subvenção Econômica">Saiba Mais</a>
    </div>
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
