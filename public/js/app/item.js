$(document).ready(function() {

});

function editar(id)
{
    window.location.href = urlBase + 'item/edit/' + id;
}

function excluir(id, descricao)
{
    swal({
        title: 'Excluir Item',
        html: 'Deseja excluir o Item <b>' + decodeURIComponent(descricao) + '</b>?',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if(result.value) {
            CustomPreload.show();
            $.ajax({
                type: "POST",
                url: urlBase + "item/destroy",
                data: {_token: _token, id: id},
                success: function(data){
                    if (data.success == true) {
                        swal({
                            title: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            $("#" + id).remove();
                        });
                    }else{
                        swal(data.msg, '' , "error");
                    }
                    CustomPreload.hide();
                }, error: function(){
                    CustomPreload.hide();
                    swal("Erro", 'Erro ao excluir item.' , "error");
                }
            })
            CustomPreload.hide();
        }
    });
}