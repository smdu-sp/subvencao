<?php
/*
Template Name: Formulário Fase Dois
*/

session_start();

date_default_timezone_set('America/Sao_Paulo');
$hora_atual = time();
// $hora_abertura = $hora_atual - mktime(10, 12, 0, 7, 31, 2024);
// Hora de abertura da segunda fase de providências:
$hora_abertura = $hora_atual - mktime(0, 0, 0, 8, 5, 2024);
$hora_fechamento =  mktime(23, 59, 59, 8, 9, 2024) - $hora_atual;

 
if ($hora_abertura < 0 || $hora_fechamento < 0 ) {
  // header('Location: https://subvencao.prefeitura.sp.gov.br/');
  // exit;
}
 
get_header(); ?>

<?php if (have_posts()) :
  while (have_posts()) :
    the_post(); ?>

    <?php
    the_content();
    include_once 'protocolo.php';
    $vue = 'vue.js';
    echo "<script type='text/javascript' src='../wp-content/themes/lc-blank-master/{$vue}'></script>";
    if (@$_POST['token']) {
      if ($_POST['token'] != $_SESSION['token']) {
        echo "<div class='mensagem-erro'>Formulário já enviado anteriormente.</div>";
        get_footer();
        return;
      }
    }
    // Formulário da eleição do CPMU 2023
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['enviar'])) {

        function registraLog($id, int $etapa, string $status = "OK")
        {
          global $wpdb;
          $wpdb->show_errors();

          if ($etapa === 1)
            $evento = "Iniciado o registro de formulário";
          if ($etapa === 2)
            $evento = "Verificação do recebimento do arquivo";
          if ($etapa === 3)
            $evento = "Registro da inscrição no banco de dados";

          $sqlData = [];
          $sqlData["id_inscricao"] = $id;


          // echo "<br>Log: " . $idInscricao . " - " . $evento . " - " . $status . "<br>";
          return $wpdb->insert('logs_fase_dois', $sqlData);
        }

        function registraInscricao(string $numeroProtocolo, int $cancelado = 0)
        {
          global $wpdb;
          $wpdb->show_errors();
          $camposForm = [
            'nome',
            'email',
          ];

          $sqlData = [];
          foreach ($camposForm as $key => $coluna) {
            $sqlData[$coluna] = $_POST[$coluna];
          }
          // $sqlData["numero_protocolo"] = $numeroProtocolo;
          $sqlData["cancelado"] = $cancelado;


          if ($cancelado)
            echo "<br>Inscrição cancelada<br>";
          else
            return $wpdb->insert('dados_fase_dois', $sqlData);
        }

        $anexos = $_FILES;
        $quantidadeDeArquivos = count(array_filter($anexos, function ($anexo) {
          return !empty($anexo['name']);
        }));

        global $wpdb;
        $wpdb->show_errors();

        // Query que garante que o valor do AUTO_INCREMENT esteja atualizado
        $resetQuery = "ANALYZE TABLE `dados_fase_dois`;";
        $wpdb->query($resetQuery);

        // Inicia registro da inscrição
        $queryId = "SELECT  `AUTO_INCREMENT`
                    FROM    INFORMATION_SCHEMA.TABLES
                    WHERE   TABLE_SCHEMA = 'subvencao'
                    AND     TABLE_NAME   = 'dados_fase_dois';";
        $inscricaoAutoIncrement = $wpdb->get_results($queryId);
        $idInscricao = $inscricaoAutoIncrement[0]->AUTO_INCREMENT;

        if ($idInscricao > 0) {
          registraLog($idInscricao, 1);
          $protocolo = geraProtocolo($idInscricao);
        } else {
          echo "<div class='mensagem-erro'>Houve um erro no acesso ao servidor de registro, tente novamente mais tarde.</div>";
          return;
        }

        // Checa se ambos os arquivos foram recebidos

        // Checa o tamanho dos arquivos recebidos

        // ENVIO DE ANEXO
        $target_dir = get_template_directory() . "/../../uploadsFaseDois/arquivos/" . str_pad($idInscricao, 3, "0", STR_PAD_LEFT) . "/";
        mkdir($target_dir, 0777, true);

        $ext_titular = pathinfo($_FILES['arquivo']['name'])['extension'];



        $arquivo = $target_dir . $protocolo . "." . $ext_titular;

        // Checa se já existe arquivo de mesmo nome no servidor
        if ((file_exists($arquivo))) {
          registraLog($idInscricao, 2, "Falha: arquivo(s) já existe(m) no local de destino");
          $wpdb->query($resetQuery);
          $inscricaoAutoIncrement = $wpdb->get_results($queryId);
          $autoIncrementAtual = $inscricaoAutoIncrement[0]->AUTO_INCREMENT;

          if ($autoIncrementAtual == $idInscricao) {
            registraInscricao($protocolo, 1);
          }
          echo "<div class='mensagem-erro'>Desculpe, não foi possível enviar os arquivos. Tente novamente. Se o erro persistir, por favor, envie um e-mail para smduaticsistemas@prefeitura.sp.gov.br e informe este erro.</div>";
          return;
        } else {

          $uploaded = move_uploaded_file($_FILES["arquivo"]["tmp_name"], $arquivo);
          chmod($arquivo, 0777);

          // Função para compactar os arquivos
          $zip = new ZipArchive();
          $target_dir_zip = get_template_directory() . "/../../downloadsFaseDois/arquivos";
          @mkdir($target_dir_zip, 0777, true);

          $fileName = $protocolo . '.zip';

          $path = $target_dir_zip;

          $fullPath = $path . DIRECTORY_SEPARATOR . $fileName;

          if (strpos($arquivo, "\\") !== false) {
            $arquivo = str_replace("\\", "/", $arquivo);
          }

          if ($zip->open($fullPath, ZipArchive::CREATE)) {
            $zip->addFile(
              $arquivo,
              $protocolo . "." . $ext_titular
            );
            $zip->close();
          }

          if ($uploaded) {
            registraLog($idInscricao, 2);
            registraInscricao($protocolo);

            $wpdb->query($resetQuery);
            $inscricaoAutoIncrement = $wpdb->get_results($queryId);
            $NovoIdInscricao = $inscricaoAutoIncrement[0]->AUTO_INCREMENT;


            if ($idInscricao + 1 == $NovoIdInscricao) {
              registraLog($idInscricao, 3);
              include_once('comprovante.php');
              get_footer();
            } else {
              registraLog($idInscricao, 3, "Falha: inscrição não foi inserida no banco de dados");
              registraInscricao($protocolo, 1);
              unlink($arquivo);
              rmdir($target_dir);
              echo "<div class='mensagem-erro'>Falha no cadastro da inscrição, por favor tente novamente.</div>";
            }

            $token = uniqid();
            $_SESSION['token'] = $token;
            $_SESSION['rev'] =  $_SESSION['token'];
            return;
          } else {
            registraLog($idInscricao, 2, "Falha: erro desconhecido");
            registraInscricao($protocolo, 1);

            echo "<div class='mensagem-erro'>Houve um erro no envio dos arquivos. Verifique o tamanho dos arquivos enviados (não podem ultrapassar 250 MB no total) e tente novamente.</div>";
          }
        }
      } else {
        registraLog($idInscricao, 2);
        registraInscricao($protocolo);

        $wpdb->query($resetQuery);
        $inscricaoAutoIncrement = $wpdb->get_results($queryId);
        $NovoIdInscricao = $inscricaoAutoIncrement[0]->AUTO_INCREMENT;


        if ($idInscricao + 1 == $NovoIdInscricao) {
          registraLog($idInscricao, 3);
          echo '<script>var inscricao = true;</script>';
          get_footer();
        }

        $token = uniqid();
        $_SESSION['token'] = $token;
        echo "<div class='mensagem-erro'>Houve um erro no envio dos arquivos. Verifique o tamanho dos arquivos enviados (não podem ultrapassar 250 MB no total) e tente novamente.</div>";
        return;
      }
    }

    ?>


    <head>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link rel="stylesheet" href="/wp-content/themes/lc-blank-master/estilos.css">

    </head>

    <body>

      <div id="app" class="container">

        <div class="logo">
          <img src="../../assets/img/capa.png" alt="banner Aiu Vl">
        </div>
        <main class="conteudo-principal">
          <div class="conteudo" id="conteudo">
            <div>
              <h1>A Prefeitura de São Paulo, por meio da Secretaria Municipal de Urbanismo e Licenciamento (SMUL), abriu o <b>segundo chamamento público</b> para que interessados em <b>requalificar imóveis no centro da cidade</b> apresentem seus projetos e solicitem subvenção econômica do Município para executar as obras.
              </h1>
              <h2><b>Chamamento Público nº 02/2024/SMUL</b></h2>
              <h3 class="sub-titulo">2º Chamamento Público</h3>
              <p>Prazo para envio das providências: 05/08/2024 a 09/08/2024.</p>
            </div>
            <div class="link">
              <a href="https://www.prefeitura.sp.gov.br/cidade/secretarias/licenciamento/acesso_a_informacao/index.php?p=357676">Clique aqui para acessar o edital</a>
            </div>
            <div>
              <form method="post" class="needs-validation" id="form" enctype="multipart/form-data">
                <?php $token = uniqid();
                $_SESSION['token'] = $token; ?>
                <input type="hidden" name="token" value="<?php echo $token; ?>" />
                <input type="hidden" name="protocolo" value="<?php echo $protocolo; ?>"/>
                <div class="form-group campo">
                  <label for="nome"><b>NOME DO SOLICITANTE</b></label>
                  <input type="text" class="form-control nome" name="nome" id="nome" aria-describedby="nome" placeholder="DIGITE O NOME COMPLETO" required>
                </div>
                <div class="form-group campo">
                  <label for="nome"><b>EMAIL DO SOLICITANTE</b></label>
                  <input type="email" class="form-control nome" name="email" id="email" aria-describedby="email" placeholder="DIGITE O EMAIL" required>
                </div>
                <label for="nome" class="card-formulario"><b>ARQUIVOS</b></label>
                <P style="margin: 0;">Recomendamos que os documentos da candidatura sejam
                  enviados no formato de pasta compactada (Arquivo ZIP).
                  <a href="/instrucoes-para-envio-da-documentacao/" style="text-decoration: underline" aria-label="Instruções para envio de pasta compactada">Clique aqui</a>
                  para instruções sobre como compactar os arquivos.
                </P></br>
                <div class="container_anexo">
                  <div class="item-anexo">
                    <div class="botao-anexo">
                      <input type="file" id="anexo_titular" name="arquivo" @change="mudaAnexoTitular" ref="arquivo_titular" required />
                    </div>
                  </div>
                  <div class="tamanho_arquivo">
                    <span id='arquivo_titular'></span>
                    <span id='' v-if="arquivoTitular.tamanho">({{ arquivoTitular.tamanho }})</span>
                  </div>
                  <div v-if="arquivoTitular.tamanhoExcessivo" style="text-align: center;">
                    <span style="color:red;">O tamanho do arquivo ultrapassou o limite de 250 MB. Separe em arquivos menores e envie separadamente.</span>
                  </div>
                </div>
                <div>
                  <button type="submit" id="enviar" class="btn btn-primary" name="enviar">Enviar</button>
                </div>
              </form>
            </div>
          </div>
        </main>
        <footer>
          <div class="container-footer">
            <div class="logo-footer">
              <img src="../../assets/img/logo.png" alt="banner Aiu Vl">
            </div>
            <div class="conteudo-footer">
              <p>Secretaria Municipal de <br>Urbanismo e Licenciamento</p>
              <p class="prf">Prefeitura de São Paulo</p>
            </div>
            <div class="redes">
              <div class="text-redes">
                <p>Acompanhe<br> nossas redes:</p>
              </div>
              <div class="redes-sociais">
                <a href="https://www.facebook.com/smulsp" target="_blank"><img src="../../assets/img/facebook.png" alt="facebook"></a>
                <a href="https://www.instagram.com/smul_sp/" target="_blank"><img src="../../assets/img/instagram.png" alt="instagram"></a>
                <a href="https://twitter.com/smul_sp" target="_blank"><img src="../../assets/img/twitter.png" alt="twitter"></a>
              </div>
            </div>
          </div>
        </footer>
      </div>

    </body>

    <script type="text/javascript">
      window.addEventListener('load', function() {
        if (inscricao == true) {
          inscricao = false;
          document.getElementById("form").style.display = "none";
          document.getElementById("mensagem").style.display = "block";
        }
      })

      function validateForm() {

        var anx_aceite_titular = document.getElementById("anexo_titular");

        if (anx_aceite_titular.files.length === 0) {
          txt_carta_titular.style.color = 'red';
          txt_carta_titular.scrollIntoView();
          event.preventDefault();
        }
        return true;
      }

      function insere_dados() {

        const indice = document.getElementById('membros').value;

        var indiceId = pessoa.membro.indexOf(indice);

        if (indiceId !== -1) {

          var entidade = pessoa.entidade[indiceId];
          var cargo = pessoa.cargo[indiceId];
          var membro = pessoa.membro[indiceId];
          var setor = pessoa.setor[indiceId];

          var titularidade = document.getElementById("titularidade_conselheira");
          var entidade_ = document.getElementById("entidade_conselheira");
          var setor_campo1 = document.getElementById("sgm_indicado");
          var setor_campo2 = document.getElementById("sgm_suplente");

          titularidade.value = cargo;
          entidade_.value = entidade;
          setor_campo1.value = setor;
          setor_campo2.value = setor;

          const selectedValue = document.getElementById('colegiado').value;

          var limpar_campos = document.getElementsByClassName('limpar_campos_auto');

          if (selectedValue > 1) {
            for (var i = 0; i < limpar_campos.length; i++) {
              limpar_campos[i].value = "";
            }
          }

        } else {

          alert("ID não encontrado");
        }


      }

      var app = new Vue({
        el: '#app',
        data: {
          tipoInscricao: '',
          segmento: '',
          email: {
            valor: '',
            confirmacao: '',
            diferente: false,
            invalido: false,
          },
          arquivoTitular: {
            tamanho: '',
            tamanhoExcessivo: false,
          },
          validacao: false,
          colegiado: 0,
        },

        methods: {
          exibeModal: function() {
            var modal = document.getElementById("modalEnvio");
            modal.style.display = "flex";
          },
          converterTamanho: function(tamanho) {
            let sufixos = ['B', 'kB', 'MB', 'GB'];
            let index = 0;
            let fixedPlaces = 0;

            while (tamanho / 1024 > 1) {
              tamanho = tamanho / 1024;
              index++;
            }

            if (index > 0) {
              fixedPlaces = 2;
            }

            tamanho = tamanho.toFixed(fixedPlaces).replace('.', ',');
            return `${tamanho} ${sufixos[index]}`;
          },
          mudaAnexoTitular: function() {
            const actualBtn3 = document.getElementById('anexo_titular');
            const fileChosen = document.getElementById('arquivo_titular');
            fileChosen.textContent = 'Nenhum arquivo selecionado';
            this.arquivoTitular.tamanho = '';
            this.arquivoTitular.tamanhoExcessivo = false;

            if (actualBtn3.files[0] !== undefined) {
              fileChosen.textContent = actualBtn3.files[0].name
              this.verificarTamanhoAnexoTitular();
            }
          },
          verificarTamanhoAnexoTitular: function() {
            this.arquivoTitular.tamanhoExcessivo = false;
            const arquivoTitular = this.$refs.arquivo_titular.files[0];
            var enviar = document.getElementById('enviar');
            enviar.removeAttribute("disabled", "disabled");
            if (arquivoTitular !== undefined) {
              var tamanho = arquivoTitular.size;
              this.arquivoTitular.tamanho = this.converterTamanho(tamanho);

              if (tamanho > 250 * 1024 * 1024) {
                this.arquivoTitular.tamanhoExcessivo = true;
                enviar.setAttribute("disabled", "disabled");
              }
            }
          },
          validarFormulario: function() {
            this.validarEmail();

            if (
              typeof this.email.valor === 'string' && this.email.valor.length > 0 &&
              !this.email.diferente &&
              !this.email.invalido &&
              !this.arquivoTitular.tamanhoExcessivo

            ) {
              this.validacao = true
              return;
            }

            this.validacao = false;
          },
          validarEmail: function() {
            // Valida e-mail 
            const campoEmail = document.querySelector('#email_contato');
            const campoEmailConfirmacao = document.querySelector('#email_confirme');
            this.email.preenchido = false;

            if (!campoEmail.checkValidity()) {
              this.email.invalido = true;
            }

            if (campoEmail.checkValidity() && campoEmailConfirmacao.checkValidity()) {
              this.email.invalido = false;
            }

            if ((this.email.valor !== this.email.confirmacao) && (this.email.valor.length > 0) && (this.email.confirmacao.length > 0)) {
              this.email.diferente = true;
            }

            if (this.email.valor === this.email.confirmacao) {
              this.email.diferente = false;
            }

            if (this.email.valor.length > 0 && this.email.confirmacao.length > 0) {
              this.email.preenchido = true;
            }
          },
        },
        watch: {
          tipoInscricao: function(newValue, oldValue) {
            if (oldValue === "") {
              this.$nextTick(() => {
                document.getElementById("botao-enviar").addEventListener("click", function(event) {
                  // event.preventDefault()
                });
              });
            }
          },
        },
      })
    </script>

  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
