<?php
	if($_REQUEST['id'])
	{
		include("../../class/conexao.php");
		$BuscaDadosCampos = $conexao->prepare("SELECT `nome`, `celular`, `tipo`, `endereco` FROM `campos` WHERE `id` = ? ");
		$BuscaDadosCampos->execute(array($_REQUEST['id']));
		$BDC = $BuscaDadosCampos->fetch(PDO::FETCH_NUM);
		session_start();
		$_SESSION['id_campo'] = $_REQUEST['id'];
		if($BDC[2] == 0)
		{
			$normal = "checked";
			$society = "";
		}
		else
		{
			$normal = "";
			$society = "checked";
		}
	}
?>
<form action="#" enctype="multipart/form-data" id="Update_Campos">
	<div class="row">
        <div class="file-field input-field col s12">
            <input type="file" class="btn" name="EditCampImagem" id="Image_Campo">
            <div class="file-path-wrapper">
                <i class="material-icons prefix">open_in_browser</i>
                <input class="file-path validate" placeholder="Aperte aqui e busque a imagem do Patrocinador" type="text" name="EditCampEndImag">
            </div>
        </div>
        <div class="input-field col s12">
          <i class="material-icons prefix">subtitles</i>
          <input id="Titulo_campo" type="text" class="validate" name="EditCampTit" value="<?php echo $BDC[0];?>">
          <label for="Titulo_campo">Título do Patrocinador</label>
        </div>
        
        <div class="input-field col s12 m6">
          <i class="material-icons prefix">contact_phone</i>
          <input id="Celular" type="text" class="validate TelCel" name="EditCampTel" value="<?php echo $BDC[1];?>">
          <label for="Celular">Celular</label>
        </div>
        
        <div class="input-field col s12 m6">
            <p>
                <input name="group2" class="with-gap" type="radio" id="normal" value="0" <?php echo $normal; ?>/>
                <label for="normal">Campo</label>
                <input name="group2" class="with-gap" type="radio" id="society" value="1" <?php echo $society; ?>/>
                <label for="society">Society</label>
            </p>
        </div>
        
        <div class="input-field col s12">
          <i class="material-icons prefix">description</i>
          <input id="Endereco" type="text" class="validate" name="EditCampEnd" value="<?php echo $BDC[3];?>">
          <label for="Endereco">Endereço</label>
        </div>
    </div>
    <div class="row">
        <button id="Editando_Campo" name="ID_campo" type="submit" class="remodal-confirm green white-text">Editar</button>
    </div>
    
</form>

<script>
$(document).ready(function() {

	Materialize.updateTextFields();

	var max_file_size = 7340032; //allowed file size. (1 MB = 1048576)
	var allowed_file_types = ['image/png', 'image/jpeg', 'image/jpg']; //allowed file types
	var total_files_allowed = 3; //Number files allowed to upload

	$("#Update_Campos").on("submit", function(event){
		event.preventDefault();
		if($("#Image_Campo").val() != "" && $("#Titulo_campo").val() != "" && $("#Celular").val() != "" && $("#Endereco").val() != "")
		{
			var proceed = true; //set proceed flag
    		var error = []; //errors
			var total_files_size = 0;
			
			 //Verifica o tipo do arquivo
			$(this.elements['EditCampImagem'].files).each(function(i, ifile){
				if(ifile.value !== ""){ //continue only if file(s) are selected
					if(allowed_file_types.indexOf(ifile.type) === -1){ //check unsupported file
						Materialize.toast( "<b>"+ ifile.name + "</b> Tipo de arquivo Invalido!", 4000, 'red white-text'); //push error text
						proceed = false; //set proceed flag to false
					}
					total_files_size = total_files_size + ifile.size; //add file size to total size
				}
			});
			
			//Verifica o tamanho do arquivo
			if(total_files_size > max_file_size){ 
				Materialize.toast(" O tamanho do seu arquivo é: "+total_files_size+", O tamanho máximo de " + max_file_size +" foi excedido!", 4000, 'red white-text'); //push error text
				proceed = false; //set proceed flag to false
			}
			
			var submit_btn  = $(this).find("button[type=submit]");
			
			//if everything looks good, proceed with jQuery Ajax
			if(proceed){
				submit_btn.val("Please Wait...").prop( "disabled", true); //disable submit button
				var form_data = new FormData(this); //Creates new FormData object
				var post_url = $(this).attr("action"); //get action URL of form
				
				//jQuery Ajax to Post form data
				$.ajax({
					url : "Campos/EditandoCampo.php",
					type: "POST",
					data : form_data,
					contentType: false,
					cache: false,
					processData:false,
					mimeType:"multipart/form-data"
				}).done(function(res){
					Materialize.toast(res, 4000, 'blue white-text');
		//alert(res);
				}).fail(function(res)
				{
					alert('erro: '+res+'\n\n informe o administrador');
				});
			}
		}
		else
		{
			Materialize.toast('Preencha todos os campos', 4000, 'red white-text');
		}
	})
});
</script>