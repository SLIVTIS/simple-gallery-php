<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <style>
        body {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #1c2833;
        }

        form {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: #2c3e50;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #fff;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            display: inline-block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-block: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin: 15px 0;
            padding: 10px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }

        a{
            text-decoration: none;
            color: #fff;
            margin-top: 10px;

        }
    </style>
</head>
<body>
<form action="<?= base_url('login') ?>" method="post">
    <h2>Inicio de sesión</h2>
    <input type="email" name="email" id="email" placeholder="Correo" required>
    <input type="password" name="pass" id="pass" placeholder="Contraseña" required>
    <?php if (isset(session()->login_error)) { ?>
        <div class="alert" role="alert">
            <?= session()->login_error ?>
        </div>
    <?php } ?>
    <button type="submit">Enviar</button>
    <a href="<?= base_url('register') ?>">Registrate</a>
</form>
</body>
</html>
