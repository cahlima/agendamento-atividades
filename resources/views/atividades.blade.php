<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Atividades</title>
    @vite('resources/js/app.js') <!-- Isso também incluirá o CSS -->
</head>
<body>
    <h1>Atividades</h1>

    <ul>
        @foreach ($atividades as $atividade)
            <li>{{ $atividade }}</li>
        @endforeach
    </ul>
</body>
</html>
