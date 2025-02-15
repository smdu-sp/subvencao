<?php 

?>

<div class="accordion">
    <h2>
        <button
            id="`accordion-header-${id}`"
            class="titulo"
            aria-expanded="false"
            aria-controls="`accordion-panel-${id}`"
            style="border-color: <?= $cores[1] ?>"
            @click="toggleAccordion()">
            <span>Chamamento Público nº 03/2024/SMUL</span>
            <div class="icone" aria-hidden="true">
                <?= carregar_svg('chevron-down') ?>
            </div>
        </button>
    </h2>
    <section
        id="`accordion-panel-${id}`"
        aria-labelledby="`accordion-header-${id}`"
        class="conteudo ahidden"
        v-html="conteudo"
        v-show="accordionAberto">
        <?php include 'subvencionado.php'; ?>
    </section>
</div>
