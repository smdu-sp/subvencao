<?php

$html = <<<HTML
<div>
    <p>Foi recebido um envio de prestação de contas no site da Subvenção.</p>
    <br>
    <br>
    <p>Detalhes:</p>
    <p>Termo de Outorga: $_POST[termo_outorga]</p>
    <p>Tipo: $_POST[tipo_prestacao]</p>
    <p>Arquivo: $_SESSION[arquivo]</p>
</div>
HTML;
