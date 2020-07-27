$(document).ready(function() {

    $("#preco-item").priceFormat({
        prefix: '',
        thousandsSeparator: '.',
        centsSeparator: ',',
        centsLimit: 2
    });

    carregarItens();

});

function editar(id)
{
    window.location.href = urlBase + 'venda/edit/' + id;
}

function excluir(id)
{
    swal({
        title: 'Excluir Venda',
        html: 'Deseja realmente excluir essa Venda?',
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
                url: urlBase + "venda/destroy",
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

$("#form-venda").on("click", "#adicionar-item", function() {

    let itemId = $("#item-select").val();
    let nomeItem = $("#item-select :selected").text();
    let qtd = $("#qtd-item").val();
    let preco = $("#preco-item").val();

    let precoFormated = preco.replace('.', '');
    precoFormated = precoFormated.replace(',', '.');

    let itens = obterItens();

    let adicionar = true;

    if(itemId > 0 && qtd != '' && qtd > 0 && precoFormated > 0) {
        itens.forEach(function (item) {
            if (item.item_id == itemId && item.deletar == false) {
                swal({
                    title: nomeItem + ' já está incluso(a) na venda!',
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                adicionar = false;
            }
        });

        if (adicionar == true)
            adicionarItem(itens, 0, itemId, nomeItem, qtd, precoFormated, false);

        $("#item-select").val(0).change();
        $("#preco-item").val(0).change();
        $("#qtd-item").val('').change();
    }
    else {
        if(itemId == 0)
            swal({title: 'Item não foi selecionado!', type: "warning", timer: 3000, showConfirmButton: false});

        else if(qtd == '')
            swal({title: 'Quantidade não foi informada!', type: "warning", timer: 3000, showConfirmButton: false});

        else if(preco == 0)
            swal({title: 'Preço não foi informado!', type: "warning", timer: 3000, showConfirmButton: false});
    }
});

function adicionarItem(itens, id, itemId, nomeItem, qtd, preco, deletar)
{
    itens.push({ id: id, item_id: itemId, qtd: qtd, preco: preco, deletar: deletar });

    inserirItem(itens);

    $("#table-body-itens").append("<tr>" +
        "                               <td>"+ nomeItem +"</td>" +
        "                               <td>"+ qtd +"</td>" +
        "                               <td>"+ number_format(preco, 2) +"</td>" +
        "                               <td>"+ number_format(qtd*preco, 2) +"</td>" +
        "                               <td align=\"center\" style=\"width: 45px;\">" +
        "                                   <button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"deletarItem(this, '"+itemId+"');\">" +
        "                                       <span class=\"fa fa-trash-o\" aria-hidden=\"true\"></span>" +
            "                               </button>" +
            "                           </td>" +
        "                           </tr>");

    atualizarValorTotal();
}

function obterItens()
{
    var itens = $("#itens-values").val();

    if(itens)
        return JSON.parse(itens);
    else
        return [];
}

function inserirItem(itens)
{
    $("#itens-values").val(JSON.stringify(itens));
}

function carregarItens()
{
    var vendaId = $("#id").val();

    if(vendaId != '')
    {
        CustomPreload.show();
        $.ajax({
            type: "GET",
            url: urlBase + "venda/obter-itens/" + vendaId,
            data: {},
            success: function(data){
                if(data)
                {
                    data.forEach(function(item, index) {
                        adicionarItem(obterItens(), item.id, item.item_id, item.descricao, item.qtd, item.preco, false);
                    });
                }
                CustomPreload.hide();
            }, error: function(){
                CustomPreload.hide();
                swal({
                    title: 'Erro ao carregar Tipo Serviços',
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                })
            }
        });
    }
}

function deletarItem(element, itemId)
{
    let itens = obterItens();

    itens.forEach(function(item, index, object) {
        if(item.item_id == itemId)
        {
            // Verifica se existe ID
            // Se existir, seta uma flag deletar true, para realizar a exclusão. Caso contrário, ele apenas
            // exclui o equipamento do array, pois ele não foi cadastrado logo não precisa ser deletado do banco.
            if(item.id != '')
                item.deletar = true;
            else
                object.splice(index, 1);

            $(element).closest("tr").remove();
        }
    });

    inserirItem(itens);
    atualizarValorTotal();
}

function calcularValorTotal() {
    let itens = obterItens();
    let desconto = $("#desconto").val();
    let total = 0;

    itens.forEach(function(item, index, object) {
        if(item.deletar == false)
        {
            total += (item.qtd * item.preco);
        }
    });

    return total - (total * (desconto / 100));
}

function atualizarValorTotal()
{
    let total = calcularValorTotal();
    $("#valor-total").html(number_format(total, 2));
}