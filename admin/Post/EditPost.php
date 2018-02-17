<?php
	if($_REQUEST['id'])
	{
		include("../../class/conexao.php");
		$BuscDadosPost = $conexao->prepare("SELECT `id`, `titulo`, `descricao` FROM `noticias` WHERE `id` = ?");
		$BuscDadosPost->execute(array($_REQUEST['id']));
		$BDP = $BuscDadosPost->fetch(PDO::FETCH_NUM);
	}
?>
<form action="#" method="post">
    <div class="input-field col s12">
      <i class="material-icons prefix">subtitles</i>
      <input id="Titulo_Edit_Post" type="text" class="validate" name="EditPostTit" value="<?php echo $BDP[1];?>">
      <label for="Titulo_Edit_Post">Título do Post</label>
    </div>
    
    <div class="input-field col s12">
      <i class="material-icons prefix">description</i>
      <textarea id="Descricao_Post" class="materialize-textarea"><?php echo $BDP[2];?></textarea>
      <label for="Descricao_Post">Descrição</label>
    </div>
    
    <div class="row">
        <button id="Editando_Post" data-id="<?php echo $BDP[0];?>" class="remodal-confirm green white-text">Editar</button>
    </div>
</form>

<script>
$(document).ready(function() {
	
	Materialize.updateTextFields();
		
	$(document).on('click', '#Editando_Post', function(e){
		e.preventDefault();
		
		if(($("#Titulo_Edit_Post").val() == "") || ($("#Descricao_Post").val() == ""))
		{
			alert('Preencha todos os campos');
		}
		else
		{
			var id_EditandoPost = $(this).data('id');
		
			$.ajax({
				url: 'Post/EditandoPost.php',
				type: 'POST',
				data: 'id='+id_EditandoPost+'&titulo='+$("#Titulo_Edit_Post").val()+'&descricao='+$("#Descricao_Post").val(),
				dataType: 'html'
			})
			.done(function(data){
				Materialize.toast(data, 4000, 'blue white-text');
				
			})
			.fail(function(){
				alert('Falha na edição');
			})
		}
	})
});
</script>