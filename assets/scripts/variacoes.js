const id_produto = $('#codigo').prop('value');
function variacao(id, estoque, id_produto, id_pai){
    $.ajax({
        type: 'POST',
        url: '../includes/variacoes.php',
        data: {
            id: id,
            estoque: estoque,
            id_produto: id_produto,
            id_pai: id_pai
        },
        dataType: 'json',
        beforeSend: function () {
            $('#loader_detalhes').show();
        },
        success: function (data) {
            $('#variacao_'+id_produto).html(data.conteudo);
            $('#qtd_real').html(data.qtd);
            $('#qtd').attr('max', data.qtd);
            $('#qtd').prop('value', 1);
            $('#preco_exibe').html(data.preco);
            $('#preco').prop('value', data.valor);
            $('#botao_adicionar').html(data.botao_adicionar);
            if (data.qtd===0){
                $('#div_qtd').hide();
            }else{
                $('#div_qtd').show();
            }
            $('#tamanho_final').prop('value', data.tamanho);
            $('#cor_final').prop('value', data.cor);
            $('#estoque').prop('value', data.estoque_real);
            $('#economize_porcentagem').html(data.economize_porcentagem);
            if (data.economize_porcentagem!==''){
                $('#economize_porcentagem').show();
            }else{
                $('#economize_porcentagem').hide();
            }
            $('#economize').html(data.economize);
            if (data.economize!==''){
                $('#economize').show();
            }else{
                $('#economize').hide();
            }
            if (data.img_ancora!==''){
                imagemAncora(data.img_ancora);
            }
            $('#loader_detalhes').hide();
        }
    });
    $('#div_estoque').show();
}