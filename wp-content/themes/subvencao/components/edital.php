<?php

$links = $edital['links']

?>

<div class="edital">
    <div class="titulo-edital">
        <h2><?= $edital['titulo'] ?></h2>
    </div>
    <div class="descricao-edital">
        <?= $edital['descricao'] ?>
    </div>
    <?php if (count($links)) { 
        foreach ($links as $key => $link) { ?>
            <a href="<?= $link['url'] ?>" class="link-edital" aria-label="<?= $link['aria_label'] ?>"><?= $link['label'] ?></a>
        <?php } 
    } ?>
</div>
