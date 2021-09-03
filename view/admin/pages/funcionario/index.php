<!DOCTYPE html>
<html lang="${language}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="${baseUri}/files/default/logo.png" type="image/x-icon">
    <title>${app_name} | Funcionários</title>

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
                        <i class="fa fa-list"></i> Gerencie seus funcionários

                        <?php if (!Browser::agent('mobile')) : ?>
                            <a href="${baseUri}/funcionario/novo" class="btn btn-custom btn-sm pull-right float-right"><i class="fa fa-plus"></i> Adicionar</a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if (!Browser::agent('mobile')) : ?>
                            <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Nível</th>
                                        <th>OS's Criadas</th>
                                        <th>OS's Finalizadas</th>
                                        <th class="d-print-none" width="100">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="funcionarios != null" v-for="func in funcionarios">
                                        <td><b>#{{ func.funcionario_id }}</b></td>
                                        <td>{{ func.funcionario_nome }}</td>
                                        <td>{{ func.funcionario_nivel }}</td>
                                        <td>{{ func.funcionario_qtd_os_criada }}</td>
                                        <td>{{ func.funcionario_qtd_os_executada }}</td>
                                        <td>
                                            <a :href="'${baseUri}/funcionario/editar/' + func.funcionario_id" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <a v-if="func.funcionario_id != <?= Session::node('uid') ?>" class="btn btn-sm btn-danger" v-on:click="show_remove(func.funcionario_id)"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="row pb-3 mb-3 border-bottom" v-if="funcionarios != null" v-for="func in funcionarios">
                                <div class="col-12 text-center">
                                    <b>#{{ func.funcionario_id }} - {{ func.funcionario_nome }} </b>
                                </div>
                                <div class="col-12 text-center">
                                    <b>Acesso: </b> {{ func.funcionario_nivel }}
                                </div>
                                <div class="col-12 text-center">
                                    {{ func.funcionario_qtd_os_criada }} OS's Criadas
                                </div>
                                <div class="col-12 text-center">
                                    {{ func.funcionario_qtd_os_executada }} OS's Finalizadas
                                </div>

                                <?php if (Session::node('uperms') == 1) : ?>
                                    <div class="col-12">
                                        <a :href="'${baseUri}/funcionario/editar/' + func.funcionario_id" class="btn btn-sm btn-block btn-primary"><i class="fa fa-edit"></i></a>
                                        <a v-if="func.funcionario_id != <?= Session::node('uid') ?>" class="btn btn-sm btn-block btn-danger" v-on:click="show_remove(func.funcionario_id)"><i class="fa fa-trash"></i></a>
                                    </div>

                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalRemove" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Remover Funcionário</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <i class="fa fa-exclamation-triangle fa-3x text-warning" aria-hidden="true"></i>
                                <br>
                                <h4 class="text-warning text-center">Atenção</h4>
                                <p>
                                    Você está prestes a remover um <b>Funcionário</b> e essa ação não poderá ser desfeita.
                                </p>
                                <button class="btn btn-danger btn-block" v-on:click="remove()">Remover</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php if (Browser::agent('mobile')) : ?>
        <a href="${baseUri}/funcionario/novo">
            <div class="floating-button show">
                <i class="fa fa-plus"></i>
            </div>
        </a>
    <?php endif; ?>

    @globalJs
    <script>
        const baseUri = "${baseUri}";
    </script>
    <script src="${baseUri}/view/admin/assets/plugins/datatable/jquery.datatable.js"></script>
    <script src="${baseUri}/view/admin/assets/plugins/datatable/datatable.js"></script>
    <script src="${baseUri}/view/admin/assets/js/datatable-init.js"></script>
    <script src="${baseUri}/view/admin/pages/funcionario/index.js"></script>
</body>

</html>