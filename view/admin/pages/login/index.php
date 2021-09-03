<!DOCTYPE html>
<html lang="${language}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="${baseUri}/files/default/logo.png" type="image/x-icon">
    <title>${app_name} | Login</title>

    @globalCss
</head>

<body>

    <div class="container mt-200">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img src="${baseUri}/files/default/logo.png" alt="Hiring Image" width="100px">
                <form action="${baseUri}/auth/admin" method="post">
                    @tokenService
                    <div class="row login-content">
                        <div class="col-sm-12">
                            <h3><b>Office Job</b></h3>
                            <h4>Área Administrativa</h4>
                        </div>
                        <div class="col-sm-12 pt-2">
                            <div class="form-group">
                                <input type="text" placeholder="Usuário" class="form-control" id="login" name="login">
                            </div>
                        </div>
                        <div class="col-sm-12 pt-2">
                            <div class="form-group">
                                <input type="password" placeholder="Senha" class="form-control" id="senha" name="senha">
                            </div>
                        </div>
                        <div class="col-sm-12 pt-2">
                            <button class="btn btn-primary btn-sm btn-block">Entrar</button>
                        </div>                      
                    </div>
                </form>
            </div>
        </div>
    </div>


    @globalJs
</body>

</html>