<!DOCTYPE html>
<html lang="${language}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="${baseUri}/files/default/logo.png" type="image/x-icon">
    <title>${app_name} | Ordens de Serviço</title>

    @globalCss
    <link href="${baseUri}/view/admin/assets/plugins/datatable/datatable.css" rel="stylesheet">
</head>

<body>
    @(admin.components.menu-superior)

    <div class="container-fluid mt-100" id="vm">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-list"></i> <?= $data['action'] ?> Ordem de Serviço

                        <?php if (!Browser::agent('mobile')) : ?>
                            <a href="${baseUri}/os" class="btn btn-custom btn-sm pull-right float-right"><i class="fa fa-arrow-left"></i> Voltar</a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <form action="${baseUri}/os/gravar" method="post">
                            @tokenService

                            <input type="hidden" name="os_id" id="os_id" value="<?= $data['os_id'] ?>">

                            <div class="row">
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="os_titulo">Título <span class="text-danger">*</span> </label>
                                        <input type="text" required class="form-control" id="os_titulo" name="os_titulo" placeholder="Título da OS">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="os_prioridade">Prioridade <span class="text-danger">*</span></label>
                                        <select name="os_prioridade" id="os_prioridade" class="form-control">
                                            <option value="1">Baixa</option>
                                            <option value="2">Normal</option>
                                            <option value="3">Alta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="os_funcionario">Executada Por</label>
                                        <select name="os_funcionario" id="os_funcionario" class="form-control">
                                            <option value="0">Selecione uma opção</option>

                                            <option v-if="funcionarios != null" v-for="func in funcionarios" :value="func.funcionario_id">{{ func.funcionario_nome }}</option>
                                        </select>
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
        <div class="floating-button show">
            <a href="${baseUri}/os">
                <i class="fa fa-arrow-left"></i>
            </a>
        </div>

    <?php endif; ?>

    @globalJs
    <script>
        const baseUri = "${baseUri}";
    </script>
    <script src="${baseUri}/view/admin/assets/plugins/datatable/jquery.datatable.js"></script>
    <script src="${baseUri}/view/admin/assets/plugins/datatable/datatable.js"></script>
    <script src="${baseUri}/view/admin/assets/js/datatable-init.js"></script>
    <script src="${baseUri}/view/admin/pages/os/form.js"></script>
</body>

</html>