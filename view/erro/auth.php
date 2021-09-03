<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Descrição do site">

    <title>Oops - Você não tem permissão</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="alert alert-danger">
            Você não tem permissão para realizar esta ação!
        </h1>
        <p class="text-center">
            <a href="<?= Http::base() ?>/admin" class="btn btn-block btn-default"><i class="fa fa-chevron-left"></i> Voltar</a>
        </p>
    </div>
</body>

</html>