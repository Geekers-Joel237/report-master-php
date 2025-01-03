    <!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
    </style>
    <title></title>
</head>
<body>
<div class="container">
    <h1>Petit rappel : {{$dto->object}} 📝</h1>

    <p>Bonjour {{ $dto->recipientName }},</p>

    <p>Un petit rappel amical concernant votre rapport journalier qui n'a pas encore été soumis aujourd'hui.</p>

    <p>Bonne journée,<br>
        {{ config('app.name') }}</p>
</div>
</body>
</html>
