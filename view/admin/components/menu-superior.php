<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand"><img src="${baseUri}/files/default/logo.png" alt="Logo ${app_name}" width="30"> <strong>${app_name}</strong></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="${baseUri}/os" class="pointer menu-os menu-link nav-link ml-2">
                            Ordens de Serviço
                        </a>
                    </li>
                    <?php if (Session::node('uperms') == 1) : ?>
                        <li class="nav-item">
                            <a href="${baseUri}/funcionario" class="pointer menu-funcionario menu-link nav-link ml-2">
                                Funcionários
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a class="pointer nav-link">
                            &nbsp;&nbsp;
                            <i class="fa fa-check"></i>
                            Bem vindo, <?= Session::node('unome') ?>!
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="pointer nav-link text-danger" href="${baseUri}/auth/logout_admin">
                            <i class="fa fa-sign-out"></i> Sair
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>