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
        class="conteudo hidden transparente"
        v-html="conteudo"
        v-show="accordionAberto">
        <?php include 'subvencionado.php'; ?>
    </section>
</div>

<div class="accordion">
    <h2>
        <button
            type="button"
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
        class="conteudo hidden transparente"
        v-html="conteudo"
        v-show="accordionAberto">
        <?php include 'subvencionado.php'; ?>
    </section>
</div>

<script>
    const botoes = document.querySelectorAll('.accordion button')
    for (const botao of botoes) {
        botao.addEventListener('click', (event) => {
            const section = botao.parentElement.nextElementSibling
            const icone = botao.getElementsByClassName('icone')[0]
            let timeout = 0

            botao.blur()
            
            if (icone.classList.contains('inverter')) {
                timeout = 300
            } 
            
            section.classList.toggle('transparente')
            
            // Adiciona delay no fechamento do accordion
            setTimeout(() => {
                section.classList.toggle('hidden')
                icone.classList.toggle('inverter')
            }, timeout)
        })
    }
</script>
