<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Prospects</title>
    <link rel="stylesheet" type="text/css" href="libs/bootstrap/css/bootstrap.css">
    <link rel="shortcut icon" href="assets/customer.jpg" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://media1.tenor.com/m/E8LKvzsigeUAAAAd/mcqueen-lightning.gif') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .login-form {
            width: 600px;
            margin: 100px auto;
        }

        .login-form form {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.4);
            padding: 30px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        img {
            display: block;
            margin: 0 auto 20px auto;
        }

        h2 {
            text-align: center;
            color: black;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <form class="form-signin" action="controllers/validar_login.php" method="POST">
            <div class="container">
                <div class="row">
                    <img src="assets/customer.jpg" width="80" alt="Logo">
                </div>
            </div>
            <h2>Login</h2>
            <div class="form-group">
                <input name="login" type="text" placeholder="Digite o seu login" required>
            </div>
            <div class="form-group">
                <input name="senha" type="password" placeholder="Digite a sua senha" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </div>
        </form>
        <p class="text-center"><a href="views/Usuario/v_incluir_usuario.php">Cadastre-se</a></p>
        <p class="text-center text-danger">
            <?php 
                if(isset($_SESSION["erroLogin"])){
                    echo $_SESSION["erroLogin"];
                    unset($_SESSION["erroLogin"]);
                }
            ?>
        </p>
    </div>
</body>
</html>
