function excluir_imagem(arquivo, id){
	$.ajax({
		type: "POST",
		url: "componentes/acoes.php",
		data: {
			excluir_imagem: 'excluir_imagem',
			arquivo: arquivo,
			id: id
		},
		dataType: "json",
		success: function (dataOK) {
		    if (dataOK.dados){
		        $('#'+id).attr('src', '../assets/img/'+pagina+'/sem_imagem.jpg');
		        $('#modal_excluir_imagem').hide();
		    }
		    
		},
		error: function(xhr, textStatus, errorThrown){
		var erro = JSON.parse(xhr.responseText);
		console.log(erro.Message);
		}
	});
}
$("#excluir_imagem").on("click", function() {
    let img = $(this).next().next();
    let src = img.attr('src');
    let id = img.attr('id');
    $("#botao_excluir_imagem").attr("onclick", "excluir_imagem('"+src+"', '"+id+"')");
});