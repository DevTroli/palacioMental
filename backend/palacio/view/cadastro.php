<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palácio Mental - Cadastro</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="main-wrapper">
        <div class="login-container">
            <div class="logo-area">
                <img src="../img/logo-mindpalace2.png" alt="Logo Palácio Mental" class="main-logo">
                <h1>PALÁCIO MENTAL</h1>
            </div>

            <div class="login-card">
                <h2>CRIE SUA CONTA</h2>
                <p class="subtitle">Comece a construir sua fortaleza mental hoje</p>

<form action="../view/verificacao.php" method="GET">

<div class="input-group">
<i class="fa-regular fa-user input-icon"></i>
 <input type="text" placeholder="Nome Completo" required>
                    </div>

                    <div class="input-group">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input type="email" placeholder="Endereço de E-mail" required>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" placeholder="Senha" required>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-shield-halved input-icon"></i>
                        <input type="password" placeholder="Confirme sua Senha" required>
                    </div>

                    <div class="terms-container">
                        <input type="checkbox" id="terms" required>
                        <label for="terms">Eu aceito os <a href="#">Termos e Condições</a></label>
                    </div>

                    <button type="submit" class="btn-login">CADASTRAR</button>
                </form>

                <div class="divider">Ou cadastre-se com:</div>

                <div class="social-login">
                    <button class="btn-social"><i class="fa-brands fa-google"></i> Google</button>
                    <button class="btn-social"><i class="fa-brands fa-apple"></i> Apple</button>
                </div>

                <div class="signup-text">
                    Já tem uma conta? <a href="/view/index.php">Faça Login</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
