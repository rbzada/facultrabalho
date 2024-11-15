<?php
if(isset($_POST['submit']))
{
    include_once('config.php');
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $result = mysqli_query(conexao, "INSERT INTO usuarios(nome,email,senha
    VALUES('&nome','&email','&senha')");
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastro</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Formulário de Cadastro</h2>
    
    <form id="meuFormulario" onsubmit="return validarFormulario()">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <span id="erroNome" class="error"></span><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email">
        <span id="erroEmail" class="error"></span><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha">
        <span id="erroSenha" class="error"></span><br><br>

        <label for="confirmarSenha">Confirmar Senha:</label>
        <input type="password" id="confirmarSenha" name="confirmarSenha">
        <span id="erroConfirmarSenha" class="error"></span><br><br>

        <input type="submit" value="Cadastrar">
    </form>

    <script>
        function validarFormulario() {
            let valido = true;

            // Limpar mensagens de erro anteriores
            document.getElementById("erroNome").textContent = "";
            document.getElementById("erroEmail").textContent = "";
            document.getElementById("erroSenha").textContent = "";
            document.getElementById("erroConfirmarSenha").textContent = "";

            // Validação do campo Nome
            const nome = document.getElementById("nome").value;
            if (nome.trim() === "") {
                document.getElementById("erroNome").textContent = "O nome é obrigatório.";
                valido = false;
            }

            // Validação do campo E-mail
            const email = document.getElementById("email").value;
            if (email.trim() === "") {
                document.getElementById("erroEmail").textContent = "O e-mail é obrigatório.";
                valido = false;
            }

            // Validação do campo Senha
            const senha = document.getElementById("senha").value;
            if (senha.trim() === "") {
                document.getElementById("erroSenha").textContent = "A senha é obrigatória.";
                valido = false;
            }

            // Validação do campo Confirmar Senha
            const confirmarSenha = document.getElementById("confirmarSenha").value;
            if (confirmarSenha !== senha) {
                document.getElementById("erroConfirmarSenha").textContent = "As senhas não coincidem.";
                valido = false;
            }

            if (valido) {
                // Salvar dados no localStorage
                const usuario = {
                    nome: nome,
                    email: email,
                    senha: senha
                };
                localStorage.setItem("usuario", JSON.stringify(usuario));  // Salvar o usuário como JSON
                alert("Cadastro realizado com sucesso!");
                window.location.href = "login.html";  // Redireciona para a página de login
            }

            return false;  // Impede o envio do formulário padrão
        }
    </script>
</body>
</html>
