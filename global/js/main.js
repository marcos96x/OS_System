// start geral do main
$(document).ready(() => {
    show_alerts();
})

function show_alerts() {
    if (window.location.href.indexOf('success') != -1) {
        alert_success();
    }
    if (window.location.href.indexOf('error') != -1) {
        alert_error();
    }
    if (window.location.href.indexOf('campos-obrigatorios') != -1) {
        alert_custom('Campos obrigatórios não preenchidos!');
    }
    if (window.location.href.indexOf('login-incorreto') != -1) {
        alert_custom('Dados de login não encontrados!');
    }

    if (window.location.href.indexOf('acesso-negado') != -1) {
        alert_custom('Você não tem autorização para realizar essa ação!');
    }


    if (window.location.href.indexOf('senha-obrigatoria') != -1) {
        alert_custom('O campo de Senha é obrigatório');
    }

    
}

function alert_success() {
    $.toast("Ação realizada com sucesso!");
}

function alert_error() {
    $.toast("Não foi possível realizar essa ação!");
}

function alert_custom($msg = '') {
    $.toast($msg);
}
