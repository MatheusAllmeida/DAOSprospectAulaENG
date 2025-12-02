<?php
session_start();
require_once(__DIR__ . '/../../models/Prospect.php');
require_once(__DIR__ . '/../../controllers/Prospect/ControllerProspect.php');

use MODELS\Prospect;
use CONTROLLERS\ControllerProspect;

// Verifica se o usuário está logado
if(!isset($_SESSION['usuario'])){
    $_SESSION['erroLogin'] = "Você precisa fazer login para acessar o sistema";
    header("Location: ../../index.php");
    exit;
}

// Verifica se o formulário foi enviado
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    // Captura os dados do formulário
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $celular = isset($_POST['celular']) ? trim($_POST['celular']) : '';
    $facebook = isset($_POST['facebook']) ? trim($_POST['facebook']) : '';
    $whatsapp = isset($_POST['whatsapp']) ? trim($_POST['whatsapp']) : '';
    
    // Validação básica
    if(empty($nome) || empty($email)){
        $_SESSION['erro'] = "Nome e Email são campos obrigatórios!";
        header("Location: cadastrar.php");
        exit;
    }
    
    // Cria o objeto Prospect
    $prospect = new Prospect();
    $prospect->addProspect(null, $nome, $email, $celular, $facebook, $whatsapp);
    
    // Instancia o controller e tenta salvar
    $ctrlProspect = new ControllerProspect();
    
    try {
        $resultado = $ctrlProspect->salvarProspect($prospect);
        
        if($resultado === TRUE){
            $_SESSION['sucesso'] = "Prospect cadastrado com sucesso!";
            header("Location: cadastrar.php");
        }
        
    } catch(\Exception $e) {
        $_SESSION['erro'] = "Erro ao cadastrar prospect: " . $e->getMessage();
        header("Location: cadastrar.php");
    }
    
} else {
    // Se não for POST, redireciona para a página de cadastro
    header("Location: cadastrar.php");
}
exit;
?>