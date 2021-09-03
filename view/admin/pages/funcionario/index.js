var vm = new Vue({
    el: '#vm',
    data: {
        funcionarios: null,
        rm: null,
    },
    methods: {
        listar: function () {
            var url = baseUri + '/funcionario/lista/';
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

        show_remove: function (id) {
            vm.$data.rm = id;
            $('#modalRemove').modal('show');
        },
        remove: function () {
            if(vm.$data.rm != null) {
                var url_remove = baseUri + '/funcionario/remove/';
                $.post(url_remove, { id: vm.$data.rm }).then(function (res) {
                    res = JSON.parse(res);
                    if (res.status != undefined && res.status == 200) {
                        alert_custom('Funcionário removida com sucesso!');
                        vm.listar();
                    } else {
                        alert_error('Ação não pode ser realizada!');
                    }
                });
            } else {
                alert_error('Ação não permitida!');
            }
           
            $('#modalRemove').modal('hide');
        },
    },
    created: function () {        
        $(".menu-funcionario").addClass('active');
        this.listar();        
    }
});
