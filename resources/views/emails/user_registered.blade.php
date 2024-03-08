<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bem-Vindo ao BookHub</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 1em auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            color: #555;
        }

        .welcome-message {
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
        }

        .footer p {
            font-size: 12px;
            color: #888;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bem-Vindo ao BookHub</h1>
        <p>Olá, {{ $user->name }}!</p>
        <div class="welcome-message">
            <p>Agradecemos seu registro. Esperamos que goste do nosso site.</p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} BookHub. Todos os direitos reservados.</p>
    </div>
</body>

</html>
