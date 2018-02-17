<?php
	require_once "CriandoCampo.php";
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		// Conferir se Post foi executado
		if((isset($_POST['CriaCampTit']) && $_POST['CriaCampTit'] != "") && isset($_POST['CriaCampCel']) && isset($_POST['CriaTipoCampo']) && isset($_POST['CriaCampEnd']) && isset($_POST['CriaCampEndImag']))
		{
			if($_FILES['CriaImagemCampo']['error'])
			{
				echo "<script> window.onload = function() {
						  Materialize.toast('Falha no carregamento da imagem, contacte administrador', 4000, 'red white-text');
						};</script>";
			}
			else
			{
				//Set up valid image extension
				$tipo_arquivo = array('jpg', 'jpeg', 'png', 'gif');
				date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
				$ext = strtolower(substr(strrchr($_FILES['CriaImagemCampo']['name'],'.'), 1)); //Pegando extensão do arquivo
				$new_name = date("Y.m.d-H.i.s").'.'. $ext; //Definindo um novo nome para o arquivo
				//Check if the file is allowed
				if(in_array($ext, $tipo_arquivo))
				{
					$dir = '../image/campos/'; //Diretório para uploads
					move_uploaded_file($_FILES['CriaImagemCampo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo
					
					//Envia dados	
					if(CriandoCampo($_POST['CriaCampTit'], $_POST['CriaCampCel'], $_POST['CriaTipoCampo'], $_POST['CriaCampEnd'], $new_name))
					{
						echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
						
					}
					else
					{
						echo "<script> window.onload = function() {					  
							  Materialize.toast('Erro na inserção de Campo', 4000, 'red white-text');
							};</script>";
					}					
				}
				else
				{
					echo "<script> window.onload = function() {					  
						  Materialize.toast('Tipo de arquivo invalido', 4000, 'red white-text');
						};</script>";
				}
			}
		}
	}
?>

<form method="post" enctype="multipart/form-data">
    <div class="file-field input-field col s12 m12">
        <input type="file" name="CriaImagemCampo" class="btn">
        <div class="file-path-wrapper">
            <i class="material-icons prefix">open_in_browser</i>
            <input class="file-path validate" placeholder="Aperte aqui e busque a imagem do Campo" type="text" name="CriaCampEndImag">
        </div>
    </div>
    
    <div class="input-field col s12 m12">
      <i class="material-icons prefix">subtitles</i>
      <input id="CriaCampTit" type="text" class="validate" name="CriaCampTit">
      <label for="CriaCampTit">Título do campo</label>
    </div>
    
    <div class="input-field col s12 m6">
      <i class="material-icons prefix">contact_phone</i>
      <input id="CriaCampCel" type="text" class="validate TelCel" name="CriaCampCel">
      <label for="CriaCampCel">Celular</label>
    </div>
    
    <div class="input-field col s12 m6">
        <p>
            <input class="with-gap" name="CriaTipoCampo" value="0" type="radio" id="Campo_Normal" checked/>
            <label for="Campo_Normal">Campo Normal</label>
            <input class="with-gap" name="CriaTipoCampo" value="1" type="radio" id="Socyte"/>
            <label for="Socyte">Socyte</label>
        </p>
    </div>
    
    <div class="input-field col s12 m12">
      <i class="material-icons prefix">description</i>
      <input id="CriaCampEnd" type="text" class="validate" name="CriaCampEnd">
      <label for="CriaCampEnd">Endereço</label>
    </div>
    
    <div class="col s12 m6">
        <button type="submit" class="btn blue" style="margin-left:25%;" formmethod="post">Criar</button>
    </div>        
</form>