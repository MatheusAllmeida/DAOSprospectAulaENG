<?php
session_start();
require_once(__DIR__ . '/../../models/Usuario.php');
require_once(__DIR__ . '/../../controllers/Prospect/ControllerProspect.php');

use MODELS\Usuario;
use CONTROLLERS\ControllerProspect;

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

$usuario = unserialize($_SESSION['usuario']);
$ctrlProspect = new ControllerProspect();

// Busca o prospect pelo código
$prospects = $ctrlProspect->buscarProspects();
$prospectEditar = null;

foreach($prospects as $p){
    if($p->codigo == $_GET['cod']){
        $prospectEditar = $p;
        break;
    }
}

if($prospectEditar === null){
    $_SESSION['erro'] = "Prospect não encontrado!";
    header("Location: listar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Prospect</title>
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
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrar.php">Cadastrar Prospect</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar.php">Listar Prospects</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Editar Prospect<span class="sr-only">(Página atual)</span></a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Bem Vindo: <?php echo $usuario->nome; ?>
                </span>
            </div>
        </nav>
    </header>

    <div class="container-form">
        <h2> Editar Prospect</h2>
        
        <?php
        if(isset($_SESSION['erro'])){
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erro'] . '</div>';
            unset($_SESSION['erro']);
        }
        ?>

        <form action="processar_edicao.php" method="POST">
            <input type="hidden" name="codigo" value="<?php echo $prospectEditar->codigo; ?>">
            
            <div class="form-group">
                <label for="nome">Nome Completo *</label>
                <input type="text" class="form-control" id="nome" name="nome" 
                       value="<?php echo htmlspecialchars($prospectEditar->nome); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?php echo htmlspecialchars($prospectEditar->email); ?>" required>
            </div>

            <div class="form-group">
                <label for="celular">Celular</label>
                <input type="text" class="form-control" id="celular" name="celular" 
                       value="<?php echo htmlspecialchars($prospectEditar->celular); ?>"
                       placeholder="(00) 00000-0000">
            </div>

            <div class="form-group">
                <label for="facebook">Facebook</label>
                <input type="text" class="form-control" id="facebook" name="facebook" 
                       value="<?php echo htmlspecialchars($prospectEditar->facebook); ?>"
                       placeholder="URL do Facebook">
            </div>

            <div class="form-group">
                <label for="whatsapp">WhatsApp</label>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" 
                       value="<?php echo htmlspecialchars($prospectEditar->whatsapp); ?>"
                       placeholder="(00) 00000-0000">
            </div>

            <button type="submit" class="btn btn-success btn-block"> Salvar Alterações</button>
            <a href="listar.php" class="btn btn-secondary btn-block btn-voltar">Cancelar</a>
        </form>
    </div>

    <script src="../../libs/bootstrap/js/bootstrap.js"></script>
</body>
</html>