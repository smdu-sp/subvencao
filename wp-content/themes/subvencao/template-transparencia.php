<?php
/*
Template Name: Transparência
*/

get_header();
get_breadcrumb();

global $wpdb;
$empreendimentos = $wpdb->get_results("SELECT * FROM empreendimentos");

?>

<div class="container-transparencia">
    <p class="introducao">Conheça os empreendimentos que foram selecionados na iniciativa da subvenção econômica.</p>
    <div class="container-empreendimentos">
        <?php foreach ($empreendimentos as $empreendimento) { ?>
            <div class="empreendimento">
                <div class="empreendimento-header">
                    <h2 class="titulo"><?= $empreendimento->nome ?></h2>
                    <span class="endereco"><?= $empreendimento->endereco ?> - <?= $empreendimento->bairro ?>, São Paulo/SP.</span>
                </div>
                <div class="empreendimento-conteudo">
                    <div class="responsavel">
                        <span class="subtitulo">Responsável pelo Imóvel</span>
                        <span class="conteudo"><?= $empreendimento->responsavel ?></span>
                    </div>
                    <a class="link" href="<?= $empreendimento->plano_urbanistico ?>" class="icone">
                        <span class="subtitulo">Plano Urbanístico</span>
                        <div class="icone"><?= carregar_svg('arrow-up-right-from-square-light') ?></div>
                    </a>
                    <a class="link" href="<?= $empreendimento->pontuacao ?>" class="icone">
                        <span class="subtitulo">Pontuação</span>
                        <div class="icone"><?= carregar_svg('arrow-up-right-from-square-light') ?></div>
                    </a>
                    <a class="link" href="<?= $empreendimento->valores ?>" class="icone">
                        <span class="subtitulo">Valores</span>
                        <div class="icone"><?= carregar_svg('arrow-up-right-from-square-light') ?></div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php

get_footer();
