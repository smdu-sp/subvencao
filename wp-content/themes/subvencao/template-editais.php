<?php
/*
Template Name: Editais
*/

get_header();

$fields = get_fields();
$introducao = $fields['introducao'];
$editais = $fields['editais'];

?>

<div class="container-editais">
    <div class="introducao-editais">
        <?= $introducao ?>
    </div>
    <div class="container-conteudo">
        <?php if (count($editais)) {
            foreach ($editais as $key => $edital) {
                include 'components/edital.php';
            }
        } ?>
    </div>
</div>

<?php

get_footer();
