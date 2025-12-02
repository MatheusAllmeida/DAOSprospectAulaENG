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

// Verifica se foi passado o código
if(!isset($_GET['cod']) || empty($_GET['cod'])){
    $_SESSION['erro'] = "Código do prospect não informado!";
    header("Location: listar.php");
    exit;
}

$codigo = intval($_GET['cod']);

if($codigo <= 0){
    $_SESSION['erro'] = "Código do prospect inválido!";
    header("Location: listar.php");
    exit;
}

// Cria o objeto Prospect
$prospect = new Prospect();
$prospect->codigo = $codigo;

// Instancia o controller e tenta excluir
$ctrlProspect = new ControllerProspect();

try {
    $resultado = $ctrlProspect->excluirProspect($prospect);
    
    if($resultado === TRUE){
        $_SESSION['sucesso'] = "Prospect excluído com sucesso!";
    }
    
} catch(\Exception $e) {
    $_SESSION['erro'] = "Erro ao excluir prospect: " . $e->getMessage();
}

header("Location: listar.php");
exit;
?>