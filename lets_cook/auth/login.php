<?php
session_start();
include "../config/database.php";

if (isset($_SESSION['login'])) {
    header("Location: ../dashboard/index.php");
    exit;
}

$error = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user  = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login']    = true;
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        header("Location: ../dashboard/index.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | Let's Cook</title>
<style>
* {
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}
body {
    margin: 0;
    background: #1c1c1c;
}
.container {
    display: flex;
    height: 100vh;
}
.left {
    flex: 1;
    background: url("../uploads/login-food.jpeg") center/cover no-repeat;
}
.right {
    flex: 1;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card {
    width: 380px;
}
h1 {
    color: #4e342e;
    margin-bottom: 5px;
}
p {
    color: #777;
    margin-bottom: 30px;
}
input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
button {
    width: 100%;
    padding: 12px;
    background: #ff9800;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
}
button:hover {
    background: #fb8c00;
}
.error {
    background: #ffe0e0;
    color: #b71c1c;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
}
.brand {
    font-size: 22px;
    font-weight: bold;
    color: #ff9800;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="container">
    <div class="left"></div>

    <div class="right">
        <div class="card">
            <div class="brand">🍳 Let's Cook</div>
            <h1>Welcome Back</h1>
            <p>created by Alfarizki Aprilia Putri</p>

            <?php if ($error): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
