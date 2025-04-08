<?php

$html = <<<HTML
<div>
    <p>Uma tentativa de envio de Prestação de Contas no site da Subvenção falhou.</p>
    <br>
    <br>
    <p>Detalhes:</p>
    <p>Termo de Outorga: $_POST[termo_outorga]</p>
    <p>Tipo: $_POST[tipo_prestacao]</p>
    <p>Arquivo: $_FILES[arquivo][name] ($_FILES[arquivo][size])</p>
    <p>Código de erro: $_FILES[arquivo][error]</p>
</div>
HTML;
