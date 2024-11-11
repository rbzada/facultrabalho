<?php
// auth.php

// Configuração do banco de dados
require_once 'config/db.php';  // Arquivo de conexão com o banco de dados

$response = ['success' => false, 'message' => 'Erro desconhecido'];

// Verifica se é um envio via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados enviados via POST
    $username = $_POST['username'];
    $password = $_POST['password'];
    $isLogin = isset($_POST['isLogin']) ? (bool)$_POST['isLogin'] : false;

    // Valida se os campos não estão vazios
    if (empty($username) || empty($password)) {
        $response['message'] = 'Por favor, preencha todos os campos.';
        echo json_encode($response);
        exit;
    }

    if ($isLogin) {
        // LOGIN
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Se o login for bem-sucedido
            $response['success'] = true;
        } else {
            // Se as credenciais estiverem erradas
            $response['message'] = 'Usuário ou senha incorretos.';
        }
    } else {
        // CADASTRO
        // Verifica se o usuário já existe
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $response['message'] = 'Usuário já existe.';
        } else {
            // Criptografa a senha antes de salvar no banco
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insere o novo usuário no banco de dados
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);

            // Resposta de sucesso no cadastro
            $response['success'] = true;
            $response['message'] = 'Cadastro realizado com sucesso!';
        }
    }

    // Retorna a resposta para o frontend
    echo json_encode($response);
    exit;
}
?>
