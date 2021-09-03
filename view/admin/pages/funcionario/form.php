<!DOCTYPE html>
<html lang="${language}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="${baseUri}/files/default/logo.png" type="image/x-icon">
    <title>${app_name} | Funcionário</title>

    @globalCss
    <link href="${baseUri}/view/admin/assets/plugins/datatable/datatable.css" rel="stylesheet">
</head>

<body>
    @(admin.components.menu-superior)

    <div class="container-fluid mt-100">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-list"></i> <?= $data['action'] ?> Funcionário

                        <?php if (!Browser::agent('mobile')) : ?>
                            <a href="${baseUri}/funcionario" class="btn btn-custom btn-sm pull-right float-right"><i class="fa fa-arrow-left"></i> Voltar</a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <form action="${baseUri}/funcionario/gravar" method="post" onsubmit="return validaForm()">
                            @tokenService

                            <input type="hidden" name="funcionario_id" id="funcionario_id" value="<?= $data['funcionario_id'] ?>">

                            <div class="row">
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="funcionario_nome">Nome <span class="text-danger">*</span> </label>
                                        <input type="text" required class="form-control" id="funcionario_nome" name="funcionario_nome" placeholder="Nome do Funcionário">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="funcionario_permissao">Nível de Acesso <span class="text-danger">*</span></label>
                                        <select name="funcionario_permissao" id="funcionario_permissao" class="form-control">
                                            <option value="1">Administrador</option>
                                            <option value="2">Operacional</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="funcionario_login">Login <span class="text-danger">*</span></label>
                                        <input type="text" name="funcionario_login" class="form-control" id="funcionario_login">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="funcionario_senha">Senha <?php if ($data['senha_required']) : ?> <span class="text-danger">*</span> <?php endif; ?></label>
                                        <input type="password" name="funcionario_senha" class="form-control senha" id="funcionario_senha" <?php if ($data['senha_required']) : ?> required <?php endif; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="funcionario_confirma_senha">Confirmar Senha <?php if ($data['senha_required']) : ?> <span class="text-danger">*</span> <?php endif; ?></label>
                                        <input type="password" class="form-control senha" id="funcionario_confirma_senha">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 align-self-end">
                                    <div class="form-group">
                                        <a class="btn btn-custom <?php if (Browser::agent('mobile')) : ?> btn-block <?php endif; ?>" onclick="view_senha()"><i id="icon_senha" class="fa fa-eye"></i> Ver Senhas</a>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-custom <?php if (Browser::agent('mobile')) : ?> btn-block <?php endif; ?>"><i class="fa fa-save"></i> Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (Browser::agent('mobile')) : ?>
        <a href="${baseUri}/funcionario">
            <div class="floating-button show">
                <i class="fa fa-arrow-left"></i>
            </div>
        </a>

    <?php endif; ?>

    @globalJs
    <script src="${baseUri}/view/admin/assets/plugins/datatable/jquery.datatable.js"></script>
    <script src="${baseUri}/view/admin/assets/plugins/datatable/datatable.js"></script>
    <script src="${baseUri}/view/admin/assets/js/datatable-init.js"></script>
    <script>
        let senha_visivel = false;
        $(document).ready(function() {
            $(".menu-funcionario").addClass('active');

            let funcionario_id = parseInt($("#funcionario_id").val());
            if (funcionario_id > 0) {
                get_funcionario_info(funcionario_id);
            }
            setTimeout(() => $("#funcionario_senha").val(""), 500);
        })

        function get_funcionario_info(funcionario_id) {
            const url = "${baseUri}/funcionario/find/" + funcionario_id;
            $.ajax({
                url: url,
                method: 'GET',
            }).done((res) => {
                res = JSON.parse(res);
                if (res.status != undefined && res.status == 200) {
                    $("#funcionario_nome").val(res.data.funcionario_nome);
                    $("#funcionario_permissao").val(res.data.funcionario_permissao).trigger('change');
                    $("#funcionario_login").val(res.data.funcionario_login);

                } else {
                    window.location.href = "${baseUri}/os/?error";
                }
            })
        }

        function view_senha() {
            if (senha_visivel) {
                $(".senha").attr('type', 'password');
                $("#icon_senha").removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $(".senha").attr('type', 'text');
                $("#icon_senha").removeClass('fa-eye-slash').addClass('fa-eye');
            }
            senha_visivel = !senha_visivel;
        }

        function validaForm() {
            if ($("#funcionario_senha").val() != $("#funcionario_confirma_senha").val()) {
                alert_custom("As senhas devem ser iguais!");
                $("#funcionario_senha").focus();
                return false;
            }
        }
    </script>
</body>

</html>