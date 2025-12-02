<?php
session_start();
require_once(__DIR__ . '/../../models/Usuario.php');
use MODELS\Usuario;

if(!isset($_SESSION['usuario'])){
    $_SESSION['erroLogin'] = "Você precisa fazer login para acessar o sistema";
    header("Location: ../../index.php");
    exit;
}

$usuario = unserialize($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Prospect</title>
    <link rel="stylesheet" type="text/css" href="../../libs/bootstrap/css/bootstrap.css">
    <link rel="shortcut icon" href="../../assets/customer.jpg" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://media1.tenor.com/m/E8LKvzsigeUAAAAd/mcqueen-lightning.gif') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container-form {
            max-width: 700px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group label {
            font-weight: bold;
            color: #333;
        }
        .btn-voltar {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="textoNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../main.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Cadastrar Prospect<span class="sr-only">(Página atual)</span></a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Bem Vindo: <?php echo $usuario->nome; ?>
                </span>
            </div>
        </nav>
    </header>

    <div class="container-form">
        <h2> Cadastrar Novo Prospect</h2>
        
        <?php
        if(isset($_SESSION['sucesso'])){
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['sucesso'] . '</div>';
            unset($_SESSION['sucesso']);
        }
        if(isset($_SESSION['erro'])){
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erro'] . '</div>';
            unset($_SESSION['erro']);
        }
        ?>

        <form action="processar_cadastro.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo *</label>
                <input type="text" class="form-control" id="nome" name="nome" 
                       placeholder="Digite o nome completo" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" class="form-control" id="email" name="email" 
                       placeholder="Digite o email" required>
            </div>

            <div class="form-group">
                <label for="celular">Celular</label>
                <input type="text" class="form-control" id="celular" name="celular" 
                       placeholder="(00) 00000-0000">
            </div>

            <div class="form-group">
                <label for="facebook">Facebook</label>
                <input type="text" class="form-control" id="facebook" name="facebook" 
                       placeholder="URL do Facebook">
            </div>

            <div class="form-group">
                <label for="whatsapp">WhatsApp</label>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" 
                       placeholder="(00) 00000-0000">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Cadastrar Prospect</button>
            <a href="../main.php" class="btn btn-secondary btn-block btn-voltar">Voltar</a>
        </form>
    </div>

    <script src="../../libs/bootstrap/js/bootstrap.js"></script>
</body>
</html>