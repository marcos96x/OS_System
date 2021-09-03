var vm = new Vue({
    el: '#vm',
    data: {
        os: null,
        rm: null,
        id_conclui: null,
    },
    methods: {
        listar: function () {
            var url = baseUri + '/os/lista/';
            var self = this;
            $.getJSON(url, {}, function (response) {

            }).then(function (response) {
                
                if (response != null && response.status != undefined && response.status == 200) {
                    self.os = response.data;
                }
                else {
                    self.os = null;
                }
                datatable_init();
            });
        },
        show_conclui: function(id) {
            vm.$data.id_conclui = id;
            $('#modalConclui').modal('show');
        },
        conclui: function () {
            if(vm.$data.id_conclui != null) {
                var url = baseUri + '/os/conclui/';
                $.post(url, { id: vm.$data.id_conclui }).then(function (res) {
                    res = JSON.parse(res);
                    if (res.status != undefined && res.status == 200) {
                        alert_custom('OS concluída com sucesso!');
                        vm.listar();
                    } else {
                        alert_error('Ação não pode ser realizada!');
                    }
                });
            } else {
                alert_error('Ação não permitida!');
            }
           
            $('#modalConclui').modal('hide');
        },

        show_remove: function (id) {
            vm.$data.rm = id;
            $('#modalRemove').modal('show');
        },
        remove: function () {
            if(vm.$data.rm != null) {
                var url_remove = baseUri + '/os/remove/';
                $.post(url_remove, { id: vm.$data.rm }).then(function (res) {
                    res = JSON.parse(res);
                    if (res.status != undefined && res.status == 200) {
                        alert_custom('OS removida com sucesso!');
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
        $(".menu-os").addClass('active');
        this.listar();        
    }
});
