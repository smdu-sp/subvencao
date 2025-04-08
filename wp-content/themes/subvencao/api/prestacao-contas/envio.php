
<?php 
// Envio do formulário de prestação de contas

// Token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Verifica se o formulário foi enviado e inserido corretamente
if (isset($_SESSION['form_enviado'])) {
    $formEnviado = $_SESSION['form_enviado'];

    if ($formEnviado) {
        $mensagemEnvio = 'Formulário enviado com sucesso!';
    } else {
        $mensagemEnvio = 'Houve um erro no envio do formulário, tente novamente mais tarde.';
    }

    require_once 'components/email/envio.php';    
    unset($_SESSION['form_enviado']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['form_enviado'] = false;

    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Processa os dados do formulário
        $campos = [
            'termo_outorga',
            'tipo_prestacao',
            'arquivo'
        ];
        $erro = false;

        // Validação dos campos
        foreach ($campos as $campo) {
            if ($campo != 'arquivo' && empty($_POST[$campo])) {
                $erro = true;
            }
        
            if ($campo == 'arquivo') {
                if ($_FILES[$campo]['error'] == UPLOAD_ERR_NO_FILE) {
                    $erro = true;
                }

                if ($_FILES[$campo]['size'] > 262144000) { // Limite de 250 MB
                    $erro = true;
                }
            }
        }

        if (!$erro) {
            global $wpdb;
            $sqlData = [];

            foreach ($campos as $coluna) {
                if ($coluna != 'arquivo') {
                    $sqlData[$coluna] = $_POST[$coluna];
                }
            }

            $dirUpload = '/prestacao-contas/arquivos/';
            $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

            // Adiciona string aleatória para evitar colisão de nomes e impedir os arquivos de serem encontrados após upload
            $randomString = bin2hex(random_bytes(32));
            $arquivo = $dirUpload . $randomString . "." . $extensao;

            $sqlData['arquivo'] = $arquivo;
            
            $arquivo = get_template_directory() . '/../../uploads' . $arquivo;
            $uploaded = move_uploaded_file($_FILES['arquivo']['tmp_name'], $arquivo);
            chmod($arquivo, 0777);

            $wpdb->insert('prestacao_contas', $sqlData);

            $_SESSION['form_enviado'] = true;
            $_SESSION['arquivo'] = $arquivo;
        }
    }

    // Impede o envio duplicado do formulário (PRG)
    header('Location: ' . $_SERVER['REQUEST_URI'], true, 303);
    exit;
}
