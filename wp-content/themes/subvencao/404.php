<?php

get_header();

?>

<div class="container-404" style="text-align: center; padding: 100px 20px;">
    <h1>Página não encontrada (404)</h1>
    <p>O conteúdo que você tentou acessar não existe.</p>

    <div style="margin: 20px 0; font-size: 1.2em;">
        Redirecionando para a página inicial em <strong id="timer">5</strong> segundos...
    </div>

    <a class="link-edital" href="<?php echo home_url('/'); ?>" class="btn-home" style="text-decoration: underline;">
        Ir para a Home imediatamente
    </a>
</div>

<?php

get_footer();

?>
