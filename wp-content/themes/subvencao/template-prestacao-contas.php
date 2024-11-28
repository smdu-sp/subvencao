<?php
/*
Template Name: Prestação de Contas
*/

get_header();
get_breadcrumb();

?>

<div class="container-prestacao">
    <p class="introducao-prestacao">
        Nesta página o subvencionado enviará os documentos e arquivos relacionados à prestação de contas da iniciativa.
    </p>
    <section class="instrucoes">
        <h2 class="subtitulo">Entenda as regras</h2>
        <a href="/">Instrução Normativa nº 01/2024/SMUL</a>
    </section>
    <section class="instrucoes">
        <h2 class="subtitulo">Faça o download dos arquivos</h2>
        <a href="/">Anexo I (Instrução Normativa nº 01/2024/SMUL)</a>
        <a href="/">Anexo II (Instrução Normativa nº 01/2024/SMUL)</a>
    </section>
    <form id="form-prestacao" action="">
        <select class="select-termo" name="termo" id="termo">
            <option value="" selected hidden disabled>Selecione o Termo de Outorga</option>
        </select>
        <fieldset>
            <legend class="label-radio">Selecione o tipo de prestação de contas</legend>
            <div class="container-radio">
                <div>
                    <input type="radio" name="marco" id="anual" value="anual">
                    <label for="anual">Anual</label>
                </div>
                <div>                    
                    <input type="radio" name="marco" id="marco" value="marco">
                    <label for="marco">Marco</label>
                </div>
            </div>
        </fieldset>
        <label class="label-arquivo" for="arquivo">Faça o upload dos seus documentos</label>
        <input type="file" name="arquivo" id="arquivo">
        <div class="form-rodape">
            <button class="botao-enviar" type="submit">Enviar</button>
        </div>
    </form>
</div>

<?php

get_footer();
