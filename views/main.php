<?php
session_start();
require_once('../models/Usuario.php');
require_once('../controllers/Prospect/ControllerProspect.php');

use MODELS\Usuario;
use CONTROLLERS\ControllerProspect;

if(isset($_SESSION['usuario'])){
    $usuario = unserialize($_SESSION['usuario']);
    
    // Busca estatísticas
    $ctrlProspect = new ControllerProspect();
    $prospects = $ctrlProspect->buscarProspects();
    $totalProspects = count($prospects);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bem Vindo ao Sistema</title>
    <link rel="stylesheet" type="text/css" href="../libs/bootstrap/css/bootstrap.css">
    <meta charset="UTF-8">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background: url('https://media1.tenor.com/m/E8LKvzsigeUAAAAd/mcqueen-lightning.gif') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
    }
    .dashboard-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 30px;
    }
    .card-stats {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
        margin-bottom: 20px;
    }
    .stats-number {
        font-size: 48px;
        font-weight: bold;
        color: #007bff;
    }
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
        margin-bottom: 30px;
    }
    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    .action-btn {
        flex: 1;
        min-width: 200px;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
        text-decoration: none;
        color: white;
        font-weight: bold;
        transition: transform 0.2s;
    }
    .action-btn:hover {
        transform: translateY(-5px);
        text-decoration: none;
        color: white;
    }
    .btn-cadastrar {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .btn-listar {
        background: linear-gradient(135deg, #4776E6 0%, #8E54E9 100%);
    }
</style>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="textoNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-link active">
                        <a class="nav-link" href="#">Home<span class="sr-only">(Página atual)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="prospects/cadastrar.php">Cadastrar Prospect</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="prospects/listar.php">Listar Prospects</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Bem Vindo: <?php echo $usuario->nome; ?>
                </span>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="welcome-card">
            <h1>👋 Bem-vindo, <?php echo $usuario->nome; ?>!</h1>
            <p style="font-size: 18px; margin-top: 15px;">Sistema de Gerenciamento de Prospects</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card-stats text-center">
                    <h3>Total de Prospects</h3>
                    <div class="stats-number"><?php echo $totalProspects; ?></div>
                    <p class="text-muted">prospects cadastrados no sistema</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-stats text-center">
                    <h3>Ações Rápidas</h3>
                    <div class="action-buttons" style="flex-direction: column;">
                        <a href="prospects/cadastrar.php" class="action-btn btn-cadastrar">
                             Cadastrar Novo Prospect
                        </a>
                        <a href="prospects/listar.php" class="action-btn btn-listar">
                             Ver Todos os Prospects
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}else{
    $_SESSION['erroLogin'] = "Você precisa fazer login para acessar o sistema";
    header("Location: ../index.php");
}
?>