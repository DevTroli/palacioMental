<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palácio Mental - Login</title>
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
                <h2>BEM-VINDO AO SEU PALÁCIO MENTAL</h2>
                <p class="subtitle">Faça login para acessar sua fortaleza mental</p>

                <form action="../view/index.php">
                    <div class="input-group">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input type="email" placeholder="Endereço de E-mail" required>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" placeholder="Senha" required>
                        <i class="fa-regular fa-eye-slash toggle-password"></i>
                    </div>

                    <div class="forgot-password">
                        <a href="#">Esqueceu a Senha?</a>
                    </div>

                    <button type="submit" class="btn-login">ENTRAR</button>
                </form>

                <div class="divider">Ou entre com:</div>

                <div class="social-login">
                    <button class="btn-social"><i class="fa-brands fa-google"></i> Google</button>
                    <button class="btn-social"><i class="fa-brands fa-apple"></i> Apple</button>
                </div>

                <div class="signup-text">
                    Novo no Palácio Mental? <a href="../view/cadastro.php">Criar uma Conta</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>