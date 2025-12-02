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

$usuario = unserialize($_SESSION['usuario']);
$ctrlProspect = new ControllerProspect();
$prospects = $ctrlProspect->buscarProspects();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Prospects</title>
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
        .container-list {
            max-width: 1200px;
            margin: 30px auto;
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
        .table {
            background-color: white;
        }
        .btn-group-sm {
            display: flex;
            gap: 5px;
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
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Listar Prospects<span class="sr-only">(Página atual)</span></a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Bem Vindo: <?php echo $usuario->nome; ?>
                </span>
            </div>
        </nav>
    </header>

    <div class="container-list">
        <h2>📋 Lista de Prospects Cadastrados</h2>
        
        <?php
        if(isset($_SESSION['sucesso'])){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['sucesso'] . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            unset($_SESSION['sucesso']);
        }
        if(isset($_SESSION['erro'])){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['erro'] . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            unset($_SESSION['erro']);
        }
        ?>

        <div class="mb-3">
            <a href="cadastrar.php" class="btn btn-primary"> Novo Prospect</a>
            <a href="../main.php" class="btn btn-secondary"> Voltar</a>
        </div>

        <?php if(count($prospects) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Celular</th>
                        <th>WhatsApp</th>
                        <th>Facebook</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($prospects as $prospect): ?>
                    <tr>
                        <td><?php echo $prospect->codigo; ?></td>
                        <td><?php echo htmlspecialchars($prospect->nome); ?></td>
                        <td><?php echo htmlspecialchars($prospect->email); ?></td>
                        <td><?php echo htmlspecialchars($prospect->celular); ?></td>
                        <td><?php echo htmlspecialchars($prospect->whatsapp); ?></td>
                        <td><?php echo htmlspecialchars($prospect->facebook); ?></td>
                        <td class="text-center">
                            <div class="btn-group-sm">
                                <a href="editar.php?cod=<?php echo $prospect->codigo; ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                     Editar
                                </a>
                                <a href="excluir.php?cod=<?php echo $prospect->codigo; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Deseja realmente excluir este prospect?')"
                                   title="Excluir">
                                     Excluir
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p class="text-muted">Total de prospects cadastrados: <strong><?php echo count($prospects); ?></strong></p>
        <?php else: ?>
        <div class="alert alert-info">
            <strong>Nenhum prospect cadastrado ainda.</strong> Clique em "Novo Prospect" para começar.
        </div>
        <?php endif; ?>
    </div>

    <script src="../../libs/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>