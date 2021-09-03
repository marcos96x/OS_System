var vm = new Vue({
    el: '#vm',
    data: {
        funcionarios: null,        
    },
    methods: {
        listar: function () {
            var url = baseUri + '/funcionario/lista_operadores/';
            var self = this;
            $.getJSON(url, {}, function (response) {

            }).then(function (response) {

                if (response != null && response.status != undefined && response.status == 200) {
                    self.funcionarios = response.data;
                }
                else {
                    self.funcionarios = null;
                }
                datatable_init();
            });
        },
    },
    created: function () {
        $(".menu-os").addClass('active');
        this.listar();


        let os_id = parseInt($("#os_id").val());
        if (os_id > 0) {
            get_os_info(os_id);
        }
    }
});

$(document).ready(function () {
    $(".menu-os").addClass('active');
    datatable_init();

})

function get_os_info(os_id) {
    const url = baseUri + "/os/find/" + os_id;
    $.ajax({
        url: url,
        method: 'GET',
    }).done((res) => {
        res = JSON.parse(res);
        if (res.status != undefined && res.status == 200) {
            $("#os_titulo").val(res.data.os_titulo);
            $("#os_prioridade").val(res.data.os_prioridade).trigger('change');
            $("#os_funcionario").val(res.data.os_funcionario).trigger('change');
        } else {
            window.location.href = baseUri + "/os/?error";
        }
    })
}