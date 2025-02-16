<?php

$arrayChamamentos = Array();
$menor = 1;
$maior = 1;

foreach ($subvencionados as $key => $subvencionado) {
    $chamamento = $subvencionado['chamamento']['processo']['value'];
    $ordem = $subvencionado['chamamento']['ordem'];

    if ($chamamento > $maior) {
        $maior = $chamamento;
    }

    if (! array_key_exists($chamamento, $arrayChamamentos)) {
        $arrayChamamentos[$chamamento] = array();
    }

    $arrayChamamentos[$chamamento][$ordem] = $subvencionado;
}

// Organiza a ordem de mais recente para mais antigo
for ($i = $maior; $i >= $menor; $i--) {
    if (array_key_exists($i, $arrayChamamentos)) {
        // Pega o nome do chamemento do primeiro subvencionado
        $chamamento = reset($arrayChamamentos[$i])['chamamento']['processo']['label']
?>
        <div class="accordion">
            <h2>
                <button
                    id="accordion-header-<?= $i ?>"
                    class="titulo"
                    aria-expanded="false"
                    aria-controls="accordion-panel-<?= $i ?>"
                    style="border-color: <?= $cores[$i] ?>">
                    <span><?= $chamamento ?></span>
                    <div class="icone" aria-hidden="true">
                        <?= carregar_svg('chevron-down') ?>
                    </div>
                </button>
            </h2>
            <section
                id="`accordion-panel-<?= $i ?>`"
                aria-labelledby="`accordion-header-<?= $i ?>`"
                class="conteudo hidden transparente">
                <?php
                foreach ($arrayChamamentos[$i] as $key => $chamamento) {
                    $subvencionado = $chamamento['subvencionado'];
                    include 'subvencionado.php';
                }
                ?>
            </section>
        </div>

<?php
    }
}
?>
<script>
    const botoes = document.querySelectorAll('.accordion button')
    for (const botao of botoes) {
        botao.addEventListener('click', (event) => {
            const section = botao.parentElement.nextElementSibling
            const icone = botao.querySelector('svg')
            let timeout = 0

            botao.blur()

            section.classList.toggle('transparente')
            
            // Adiciona delay no fechamento do accordion
            if (icone.classList.contains('inverter')) {
                timeout = 300
            }

            setTimeout(() => {
                section.classList.toggle('hidden')
                icone.classList.toggle('inverter')
                botao.ariaExpanded = botao.ariaExpanded !== 'true'
            }, timeout)
        })
    }
</script>
