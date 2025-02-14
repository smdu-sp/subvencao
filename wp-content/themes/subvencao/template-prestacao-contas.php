<?php
/*
Template Name: Prestação de Contas
*/

ob_start();
session_start();

get_header();
$termosOutorga = $wpdb->get_results("SELECT * FROM termos_outorga");
$mensagemEnvio = false;

require_once 'api/prestacao-contas.php';

?>

<div class="container-prestacao">
    <?php if ($mensagemEnvio) { // Caso tenha ocorrido envio do form, exibir mensagem e não carregar o form ?>
        <p class="introducao-prestacao">
            <?= $mensagemEnvio ?>
        </p>
    <?php exit; } ?>
    <p class="introducao-prestacao">
        Nesta página o subvencionado enviará os documentos e arquivos relacionados à prestação de contas da iniciativa.
    </p>
    <section class="instrucoes">
        <h2 class="subtitulo">Entenda as regras</h2>
        <div>
            <a class="link" href="/"><span>Instrução Normativa nº 01/2024/SMUL</span></a>
        </div>
    </section>
    <section class="instrucoes">
        <h2 class="subtitulo">Faça o download dos arquivos</h2>
        <div>
            <a class="link" href="/">Anexo I (Instrução Normativa nº 01/2024/SMUL)</span></a>
        </div>
        <div>
            <a class="link" href="/"><span>Anexo II (Instrução Normativa nº 01/2024/SMUL)</span></a>
        </div>
    </section>
    <form id="form-prestacao" class="form-prestacao" action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <select class="select-termo" name="termo_outorga" id="termo_outorga" required>
            <option value="" selected hidden disabled>Selecione o Termo de Outorga</option>
            <?php foreach ($termosOutorga as $termo) { ?>
                <option value="<?= $termo->id ?>"><?= $termo->nome ?></option>
            <?php } ?>
        </select>
        <div class="campos-radio">
            <fieldset>
                <legend class="label-radio">Selecione o tipo de prestação de contas</legend>
                <div class="container-radio">
                    <div class="radio">
                        <input type="radio" name="tipo_prestacao" id="anual" value="1" required>
                        <label for="anual">Anual</label>
                    </div>
                    <div class="radio">
                        <input type="radio" name="tipo_prestacao" id="marco" value="2" required>
                        <label for="marco">Marco</label>
                    </div>
                </div>
            </fieldset>
        </div>
        <div>
            <span class="label-arquivo">Faça o upload dos seus documentos</span>
        </div>
        <div class="container-arquivo">
            <div class="botao-arquivo">
                <div>
                    <input type="file" name="arquivo" id="arquivo" required>
                    <label class="botao-upload" for="arquivo">
                        <?= carregar_svg('folder') ?>
                        <span>Pesquisar arquivos</span>
                    </label>
                </div>
                <div id="nome-arquivo" class="nome-arquivo hidden">
                    <span></span>
                </div>
            </div>
            <div id="erros-arquivo" class="erros-arquivo">
                <span class="hidden erro"></span>
            </div>
        </div>
        <div class="form-rodape">
            <button id="botao-enviar" class="botao-enviar" title="Preencha o formulário corretamente para realizar o envio" type="submit" disabled>Enviar</button>
        </div>
    </form>
</div>

<script>
    const form = document.getElementById('form-prestacao');
    const campos = form.querySelectorAll('input, select, textarea');
    const arquivo = document.getElementById('arquivo');
    const nomeArquivoEl = document.getElementById('nome-arquivo');
    const errosArquivo = document.getElementById('erros-arquivo').querySelector('span');
    const botaoEnviar = document.getElementById('botao-enviar');
    const tituloBotao = botaoEnviar.getAttribute('title');
    const arrayBytes = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    let erros = [];

    nomeArquivoEl.classList.add('hidden');
    errosArquivo.classList.add('hidden');
    errosArquivo.innerHTML = '';

    // Validação dos inputs
    form.addEventListener('input', e => {
        validarFormulario(e.target.form);
    });

    form.addEventListener('change', e => {
        validarFormulario(e.target.form);
    });

    function validarFormulario(form) {
        erros = erros.filter(item => item != 'campo vazio');

        botaoEnviar.removeAttribute('disabled');
        botaoEnviar.removeAttribute('title');

        for (const campo of campos) {
            if ((campo.tagName === 'INPUT' || campo.tagName === 'TEXTAREA') && campo.value.trim() === '') {
                erros.push('campo vazio');
            }

            if (campo.tagName === 'SELECT' && campo.value === '') {
                erros.push('campo vazio');
            }

            if (campo.type === 'radio') {
                const grupoRadio = form.querySelectorAll(`input[name="${campo.name}"]`);
                const selecionado = Array.from(grupoRadio).some(radio => radio.checked);
                if (!selecionado) {
                    erros.push('campo vazio');
                }
            }
        }

        if (erros.length > 0) {
            botaoEnviar.setAttribute('disabled', 'disabled');
            botaoEnviar.setAttribute('title', tituloBotao);
        }
    }

    // Validação do envio de arquivo
    arquivo.addEventListener('change', e => {
        errosArquivo.innerHTML = '';
        errosArquivo.classList.add('hidden');
        erros = erros.filter(item => item != 'tamanho');
        nomeArquivoEl.classList.add('hidden');

        let nomeArquivo = '';

        if (e.target.files.length) {
            nomeArquivo = e.target.files[0].name;
        }

        if (nomeArquivo) {
            let i = 0;
            let tamanho = e.target.files[0].size;

            if (tamanho > 250 * 1024 * 1024) {
                erros.push('tamanho');
            }

            while (tamanho > 1024 && i < 5) {
                i++;
                tamanho = (tamanho / 1024).toFixed(2);
            }

            tamanho = tamanho.toString()

            nomeArquivoEl.innerHTML = `${nomeArquivo} (${tamanho.replace('.', ',')} ${arrayBytes[i]})`;
            nomeArquivoEl.classList.remove('hidden');
        }

        for (const erro of erros) {
            switch (erro) {
                case 'tamanho':
                    errosArquivo.innerHTML = 'O tamanho do arquivo não deve ultrapassar 250 MB. ';
                    errosArquivo.classList.remove('hidden');
                    break;
            }
        }
    });
</script>

<?php

get_footer();
