$(document).ready(function() {
    var $modal = $('#nova_imagem_modal');
    var image = document.getElementById('sample_image');
    var cropper;
    
    $(".upload_image").on("click", function() {
        var id = $(this).attr("id");
        $(this).data("height");
        $('#imagem').prop('value', id);
        $('#imagem').data('width', $(this).data("width"));
        $('#imagem').data('height', $(this).data("height"));
    });
    
    $('.upload_image').change(function(event){
    	var files = event.target.files;
    	var done = function(url){
    		image.src = url;
    		$modal.modal('show');
    	};
    
    	if(files && files.length > 0){
    		reader = new FileReader();
    		reader.onload = function(event)
    		{
    			done(reader.result);
    		};
    		reader.readAsDataURL(files[0]);
    	}
    });
    
    $modal.on('shown.bs.modal', function() {
        var aspect = $("#imagem").data("width")/$("#imagem").data("height");
        var view = $("#imagem").data("width")/$("#imagem").data("height");
        
    	cropper = new Cropper(image, {
    		aspectRatio: aspect,
    		viewMode: view,
    		preview:'.preview'
    	});
    }).on('hidden.bs.modal', function(){
    	cropper.destroy();
       	cropper = null;
    });
    
    $('#crop').click(function(){
    	canvas = cropper.getCroppedCanvas({
    		width: $("#imagem").data("width"),
    		height: $("#imagem").data("height")
    	});
    
    	canvas.toBlob(function(blob){
    		url = URL.createObjectURL(blob);
    		var reader = new FileReader();
    		reader.readAsDataURL(blob);
    		reader.onloadend = function(){
    			var base64data = reader.result;
    			$.ajax({
    				url: 'componentes/cropper.php',
    				method:'POST',
    				data:{
    				    image:base64data,
    				    pagina: $('#pagina_referencia').prop('value')
    				},
    				beforeSend:function(){
    				    $('#crop').hide();
    				    $('#enviando').show();
    				},
    				success:function(data){
    					$modal.modal('hide');
    					$('#enviando').hide();
    					$('#excluir_imagem').show();
    				    $('#crop').show();
    				    let id = $('#imagem').prop('value');
						$('#'+id).attr('src', data);
						let input = $('#'+id).next();
						input.prop('value', data);
						let img = $('#'+id).prev();
						img.attr('src', data);
    				}
    			});
    		};
    	});
    });
});