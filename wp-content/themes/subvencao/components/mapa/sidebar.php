<?php

$introducao = get_field('introducao');
?>

<div class="introducao-mascara"></div>
<div class="introducao">
    <?php echo wpautop($introducao); ?>
</div>
<button class="button-toggle-introducao" aria-label="Fechar painel lateral"><?= carregar_svg('chevron-left') ?></button>
