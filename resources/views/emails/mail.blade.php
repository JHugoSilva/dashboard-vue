<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <!-- Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }

        .card {
            margin: auto;
            border: 1px solid #24BCCC;
            border-radius: 12px;
            text-align: center;
            box-shadow: 4px 5px 5px #97D8C0;
            padding: 20px;
            max-width: 400px;
            background-color: white;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #24BCCC;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }

        .reset-link {
            background-color: #24BCCC;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        .reset-link:hover {
            background-color: #1a90a6;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="title">Atualize sua Senha</div>
        <div class="subtitle">Ola, {{ $name }}</div>
        <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Suscipit vero reiciendis, quas esse officiis, dolorum distinctio quasi assumenda veniam error nesciunt rerum dignissimos itaque, sequi quis autem optio? Aperiam, nostrum?
        </p>
        <a class="reset-link" href="{{url('reset-password-form?token='.$token)}}">Clique aqui!</a>
    </div>
</body>
</html>
