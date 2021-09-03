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
                        <i class="fa fa-list"></i> Gerencie suas Ordens de Serviço

                        <?php if (!Browser::agent('mobile') && Session::node('uperms') == 1) : ?>
                            <a href="${baseUri}/os/nova" class="btn btn-custom btn-sm pull-right float-right"><i class="fa fa-plus"></i> Adicionar</a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if (!Browser::agent('mobile')) : ?>
                            <table id="datatable" class="datatable display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nº OS</th>
                                        <th>Título</th>
                                        <th>Status</th>
                                        <th>Prioridade</th>
                                        <th>Aberto por</th>
                                        <th>Executada por</th>
                                        <th>Data de abertura</th>
                                        <th class="d-print-none" width="100">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="os != null" v-for="ordem in os">
                                        <td><b>#{{ ordem.os_id }}</b></td>
                                        <td>{{ ordem.os_titulo }}</td>
                                        <td>
                                            <span :class="ordem.os_badge">
                                                {{ ordem.os_prioridade_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <span v-if="ordem.os_status == 0">
                                                <span class="badge badge-warning">Aberta</span>
                                            </span>
                                            <span v-if="ordem.os_status == 1">
                                                <span class="badge badge-success">Concluída</span>
                                            </span>
                                        </td>
                                        <td>{{ ordem.funcionario_nome }}</td>
                                        <td>
                                            <span v-if="ordem.funcionario_executor != null">
                                                {{ ordem.funcionario_executor }}
                                            </span>
                                            <span v-if="ordem.funcionario_executor == null">
                                                Não Atrelado
                                            </span>
                                        </td>
                                        <td>{{ ordem.os_created }}</td>
                                        <td>
                                            <?php if (Session::node('uperms') == 2) : ?>
                                                <a class="btn btn-sm btn-success" v-if="ordem.os_status == 0 && ordem.os_funcionario == <?= Session::node('uid') ?>" v-on:click="show_conclui(ordem.os_id)"><i class="fa fa-check"></i> Concluir</a>
                                            <?php else : ?>
                                                <a :href="'${baseUri}/os/editar/' + ordem.os_id" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-sm btn-danger" v-on:click="show_remove(ordem.os_id)"><i class="fa fa-trash"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="row pb-3 mb-3 border-bottom" v-if="os != null" v-for="ordem in os">
                                <div class="col-12 text-center">
                                    <b>#{{ ordem.os_id }} - {{ ordem.os_titulo }} </b> <br>
                                    Criada em: {{ ordem.os_created }}
                                </div>
                                <div class="col-12 text-center">
                                    <b>Aberta por:</b> {{ ordem.funcionario_nome }}
                                </div>
                                <div class="col-12 text-center">
                                    <b>Executor:</b>
                                    <span v-if="ordem.funcionario_executor != null">
                                        {{ ordem.funcionario_executor }}
                                    </span>
                                    <span v-if="ordem.funcionario_executor == null">
                                        Não Atrelado
                                    </span>
                                </div>
                                <div class="col-12 text-center">
                                    <b>Status: </b>
                                    <span v-if="ordem.os_status == 0">
                                        <span class="badge badge-warning">Aberta</span>
                                    </span>
                                    <span v-if="ordem.os_status == 1">
                                        <span class="badge badge-success">Concluída</span>
                                    </span>
                                </div>

                                <div class="col-12 text-center mb-2">
                                    <b>Prioridade: </b>
                                    <span :class="ordem.os_badge">
                                        {{ ordem.os_prioridade_label }}
                                    </span>
                                </div>

                                <?php if (Session::node('uperms') == 2) : ?>
                                    <div class="col-12">
                                        <a class="btn btn-sm btn-block btn-success" v-if="ordem.os_status == 0 && ordem.os_funcionario == <?= Session::node('uid') ?>" v-on:click="show_conclui(ordem.os_id)"><i class="fa fa-check"></i> Concluir</a>
                                    </div>
                                <?php else : ?>
                                    <div class="col-6">
                                        <a :href="'${baseUri}/os/editar/' + ordem.os_id" class="btn btn-sm btn-block btn-primary"><i class="fa fa-edit"></i></a>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-sm btn-block btn-danger" v-on:click="show_remove(ordem.os_id)"><i class="fa fa-trash"></i></a>
                                    </div>

                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalConclui" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Concluir Ordem de Serviço</h5>
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
                                    Você está prestes a concluir um <b>Ordem de Serviço</b> e essa ação não poderá ser desfeita.
                                </p>
                                <button class="btn btn-success btn-block" v-on:click="conclui()">Concluir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalRemove" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Remover Ordem de Serviço</h5>
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
                                    Você está prestes a remover um <b>Ordem de Serviço</b> e essa ação não poderá ser desfeita.
                                </p>
                                <button class="btn btn-danger btn-block" v-on:click="remove()">Remover</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php if (Browser::agent('mobile')  && Session::node('uperms') == 1) : ?>
        <div class="floating-button show">
            <a href="${baseUri}/os/nova">
                <i class="fa fa-plus"></i>
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
    <script src="${baseUri}/view/admin/pages/os/index.js"></script>
</body>

</html>