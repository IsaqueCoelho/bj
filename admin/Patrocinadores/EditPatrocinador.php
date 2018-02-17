<?php
	if($_REQUEST['id'])
	{
		include("../../class/conexao.php");
		$BuscDadosPatrocinador = $conexao->prepare("SELECT * FROM `patrocinadores` WHERE `id` = ?");
		$BuscDadosPatrocinador->execute(array($_REQUEST['id']));
		$BDP = $BuscDadosPatrocinador->fetch(PDO::FETCH_NUM);		
		session_start();
		$_SESSION['id_patrocinio'] = $BDP[0];
	}
?>
<form action="#" id='form_edita_patrocinio'>
    <div class="row">
    	<div class="file-field input-field col s12">
            <input type="file" class="btn" name="image_patrocinio" id="image_edit_patrocinio">
            <div class="file-path-wrapper">
                <i class="material-icons prefix">open_in_browser</i>
                <input class="file-path validate" placeholder="Aperte aqui e busque a imagem do Patrocinador" type="text" name="EditPatendImag">
            </div>
        </div>
        
        <div class="input-field col s12">
          <i class="material-icons prefix">subtitles</i>
          <input id="Titulo_patrocinio" type="text" class="validate" name="EditPatTit" value="<?php echo $BDP[1]?>">
          <label for="Titulo_patrocinio">Título do Patrocinador</label>
        </div>
        
        <div class="input-field col s12 m6">
          <i class="material-icons prefix">contact_phone</i>
          <input id="Telefone" type="text" class="validate Tel" name="EditPatTel" value="<?php echo $BDP[3]?>">
          <label for="Telefone">Celular</label>
        </div>
        
        <div class="input-field col s12">
          <i class="material-icons prefix">description</i>
          <input id="Endereco" type="text" class="validate" name="EditPatLink" value="<?php echo $BDP[2]?>">
          <label for="Endereco">Link</label>
        </div>
    </div>
     <div class="row">
        <button id="Editando_Patrocinio" name="ID_campo" type="submit" class="remodal-confirm green white-text">Editar</button>
    </div>
</form>

<script>
	$(document).ready(function() {
		
		Materialize.updateTextFields();
		var max_file_size = 7340032; //allowed file size. (1 MB = 1048576)
		var allowed_file_types = ['image/png', 'image/jpeg', 'image/jpg']; //allowed file types
		var total_files_allowed = 3; //Number files allowed to upload
		$("#form_edita_patrocinio").on('submit', function(event)
		{
			event.preventDefault();
			
			
			if($("#image_edit_patrocinio").val() != "" && $("#Titulo_patrocinio").val() != "" && $("#Telefone").val() != "" && $("#Endereco").val() != "")
			{
				var proceed = true; //set proceed flag
				var error = []; //errors
				var total_files_size = 0;
			
				 //Verifica o tipo do arquivo
				$(this.elements['image_edit_patrocinio'].files).each(function(i, ifile){
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
					Materialize.toast(" O tamanho do seu arquivo é: "+total_files_size+", O tamanho máximo de " + max_file_size +" foi excedido!", 4000, 'red white-text'); 
	
	//push error text
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
						url : "Patrocinadores/EditandoPatrocinador.php",
						type: "POST",
						data : form_data,
						contentType: false,
						cache: false,
						processData:false,
						mimeType:"multipart/form-data"
					}).done(function(res){
						Materialize.toast(res, 4000, 'blue white-text');						
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