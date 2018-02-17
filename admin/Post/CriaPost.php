<?php
	require_once "CriandoPost.php";
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(isset($_POST['CriaTituloCampo']) && isset($_POST['CriaDescricaoCampo']))
		{
			if($craindo = CriandoPost($_POST['CriaTituloCampo'], $_POST['CriaDescricaoCampo']))
			{
					echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
			}
			else
			{
				echo "<script> window.onload = function() {
					  //executado quando tudo na página está carregado					  
					  Materialize.toast('Erro na Criação do POST!', 4000, 'red white-text');
					};</script>";
			}
		}
	}
?>
<form action="" method="post">    
    <div class="input-field col s12">
      <i class="material-icons prefix">subtitles</i>
      <input id="Titulo_Post" type="text" class="validate" name="CriaTituloCampo">
      <label for="Titulo_Post">Título do Post</label>
    </div>
    
    <div class="input-field col s12">
      <i class="material-icons prefix">description</i>
      <textarea id="textarea1" class="materialize-textarea" name="CriaDescricaoCampo"></textarea>
      <label for="Descricao">Descrição</label>
    </div>
    
    <div class="col s12 m6">
        <button type="submit" class="btn blue" style="margin-left:25%;" formmethod="post">Criar</button>
    </div>        
</form>