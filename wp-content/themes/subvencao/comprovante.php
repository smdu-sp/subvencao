<?php

include_once 'header.php';

$nomeContato = $_POST['nome'];
$email = $_POST['email'];

$html = <<<HTML
<div class="comprovante" id="comprovante" style="font-family: Tahoma, Arial, sans-serif; max-width: 600px; margin: auto; margin-top: 60px;">
  <div style="margin-bottom: 16px">
    <img style="width: 133px; height: 130px; display: block; margin: 0 auto;" src="https://cmpu.prefeitura.sp.gov.br//assets/img/comprovante-logo-smul.png" alt="Logo da Secretaria Municipal de Urbanismo e Licenciamento">
  </div>
  <div style="margin-bottom: 16px;">
    <h1 style="font-size: 18px; font-weight: bold; text-align: center;">COMPROVANTE DE RECEBIMENTO DE DOCUMENTAÇÃO</h1>
  </div>
  <div style="margin-bottom: 48px">
    <p style="font-size: 16px; text-align: center;">Protocolo nº $protocolo</p>
  </div>
  <p style="font-size: 16px; margin-bottom: 16px;">Recebemos do(a) Sr(a).</p>
  <p style="font-size: 16px; margin-bottom: 16px;">Nome: $nomeContato </p>
  <p style="font-size: 16px; margin-bottom: 16px;">E-mail: $email </p>
  <p style="font-size: 16px; margin: 20px 0;">Entrega de documentação referente aos Pedidos de Providências efetuada com sucesso. A documentação seguirá para a análise da Comissão Especial de Avaliação.</p>
</div>
HTML;
?>

<link rel="stylesheet" href="/wp-content/themes/lc-blank-master/estilos.css">

<!-- <main id="textoComprovante">
  <div id="app">
    <div id="header-instrucoes" class="header header-instrucoes">
      <p>Inscrição realizada com sucesso!</p>
      <p>Uma cópia do comprovante foi enviado para o endereço de e-mail informado, caso não tenha recebido, verifique
        sua pasta de "spam".</p>
    </div>
  </div>
</main> -->

<?php
echo $html;

// Envio de email
$emailFrom = 'subvencao@PREFEITURA.SP.GOV.BR';
$params = "-f {$emailFrom}";
$assunto = "Segundo Chamamento Público";
$headers = "From: SUBVENÇÃO<{$emailFrom}>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

@mail($email, $assunto, $html, $headers, $params);

?>

<center>
  <p class="instrucoes" id="header-instrucoes">Uma cópia do comprovante foi enviado para o endereço de e-mail informado, caso não tenha recebido, verifique
    sua pasta de "spam".</p>
  <button id="botaoImprimir" style="border-style: revert; -webkit-appearance: auto; appearance: auto" onClick="imprimir()">Imprimir Comprovante</button>
  <div id="botao-voltar">
    <a href="https://subvencao.prefeitura.sp.gov.br/formulario-fase-dois/" class="voltar" id="botao-voltar"><b>Enviar nova inscrição</b></a>
  </div>
</center>

<style>
  .instrucoes {
    margin-top: 50px;
    margin-bottom: 10px;
    font-family: sans-serif;
  }

  #botaoImprimir {
    padding: 5px 10px;
    background-color: azure;
    border-radius: 5px;
    margin-top: 20px;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1px;
  }

  .voltar {
    font-size: 15px;
    text-decoration: none;
    font-family: sans-serif;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1px;
    color: black;
  }
  #botao-voltar {
    margin-top: 50px;
  }
  .voltar:hover {
    transition: all 0.5s;
    color: blue;
  }
</style>


<script>
  window.onafterprint = function() {
    var impr = document.getElementById('botaoImprimir');
    var instrucoes = document.getElementById('header-instrucoes');
    var botao_voltar = document.getElementById('botao-voltar');
    botao_voltar.style.display = 'block';
    impr.style.display = 'block';
    instrucoes.style.display = 'block';
  }

  function imprimir() {
    var impr = document.getElementById('botaoImprimir');
    impr.style.display = 'none';
    var instrucoes = document.getElementById('header-instrucoes');
    instrucoes.style.display = 'none';
    var botao_voltar = document.getElementById('botao-voltar');
    botao_voltar.style.display = 'none'; 
    window.print();
  }
</script>