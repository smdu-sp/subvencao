<?php
/*
Template Name: Transparência
*/

get_header();

global $wpdb;
$introducao = get_field('introducao');
$subvencionados = get_field('subvencionados');

include_once 'components/cores.php';

?>

<div class="container-transparencia">
    <div class="introducao">
        <?= $introducao ?>
    </div>
    <div class="container-subvencionados">
        <?php require_once 'components/accordion/accordion.php'; ?>
    </div>
</div>

<?php

get_footer();
