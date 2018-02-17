<?PHP 
	require_once "class/conta.php";	
	
	if(isset($_POST['AlterarDadosUsuario']))
	{
		if(isset($_POST['Nome']) && isset($_POST['Email']) && isset($_POST['RG']) && isset($_POST['CPF']) && isset($_POST['Telefone']) && isset($_POST['Celular']) && isset($_POST['Rua']) && isset($_POST['Bairro']) && isset($_POST['NumCasa']) && isset($_POST['Cidade']))
		{
			/*echo "<script> alert(' Usuario: ".$_SESSION['ID']." chamado de: ".$_POST['Nome']."');</script>";*/
			if($Usuario = AtualizandoDadosUsuario($_SESSION['ID'], $_POST['Nome'], $_POST['Email'], $_POST['RG'], $_POST['CPF'], $_POST['Telefone'], $_POST['Celular'], $_POST['Rua'], $_POST['Bairro'], $_POST['NumCasa'], $_POST['Cidade']))
			{
				echo "<script> window.onload = function() {
					  //executado quando tudo na página está carregado					  
					  Materialize.toast('Dados de Usuário atualizados', 4000, 'blue white-text');
					};</script>";
			}
			else
			{
				echo "<script> window.onload = function() {
					  //executado quando tudo na página está carregado					  
					  Materialize.toast('Falha, contacte administrador', 4000, 'red white-text');
					};</script>";
			}
		}
	}
	
	if(isset($_POST['AlterarDadosTime']))
	{
		if(isset($_POST['nome_time']) && isset($_POST['RBCampo']))
		{
			
			if(empty($_POST['cor_uniforme']))
			{
				isset($_POST['cor_uniforme']);
				$_POST['cor_uniforme'] = "Cor de uniforme não definida!";
			}
			if(empty($_POST['campo_endereco']))
			{
				isset($_POST['campo_endereco']);
				$_POST['campo_endereco'] = "Não possui campo!";
			}
			
			if($Usuario = AtualizandoDadosTime($_SESSION['ID'], $_POST['nome_time'], $_POST['cor_uniforme'], $_POST['campo_endereco'], $_POST['RBCampo']))
			{
				echo "<script> window.onload = function() {
					  //executado quando tudo na página está carregado					  
					  Materialize.toast('Dados de Time atualizados', 4000, 'blue white-text');
					};</script>";
			}
			else
			{
				echo "<script> window.onload = function() {
					  //executado quando tudo na página está carregado					  
					  Materialize.toast('Falha, contacte administrador', 4000, 'red white-text');
					};</script>";
			}
		}
	}
	
	//Quando enviar formulário de foto
	if(isset($_POST['AltImage']))
	{
		if($_FILES['CriaImagemCampo']['error'])
		{
			echo "<script> window.onload = function() {
					  //executado quando tudo na página está carregado					  
					  Materialize.toast('Falha no carregamento da imagem, contacte administrador', 4000, 'red white-text');
					};</script>";
		}
		else
		{
			//Set up valid image extensions
			$extsAllowed = array( 'jpg', 'jpeg', 'png', 'gif' );			
			//Extract extention from uploaded file
			$extUpload = strtolower( substr( strrchr($_FILES['CriaImagemCampo']['name'], '.') ,1) );			
			//Check if the uploaded file extension is allowed
			if(in_array($extUpload, $extsAllowed))
			{
				//Create name for image
				date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
				$new_name = date("Y.m.d-H.i.s").'.'.$extUpload; // Definindo o nome do arquivo
				$dir = 'image/times/'; //Diretorio para upload
				move_uploaded_file($_FILES['CriaImagemCampo']['tmp_name'], $dir.$new_name); // Upload do arquivo
				//Busca foto antiga
				$busca_antiga_foto = $conexao->prepare("SELECT `foto` FROM `time` WHERE `id_usuario` = ?");
				$busca_antiga_foto->execute(array($_SESSION['ID']));
				$BAF = $busca_antiga_foto->fetch(PDO::FETCH_NUM);
				//Insere no banco de dados
				$InsertImagemperfil = $conexao->prepare("UPDATE `time` SET `foto` = ? WHERE `id_usuario` = ?");
				$InsertImagemperfil->execute(array($new_name, $_SESSION['ID']));
				if($BAF[0] != "logo.png"){unlink('image/times/'.$BAF[0]);}// Exclui imagem caso não seja a logo
				
			}		
		}
	}
	
	if($DadosUsuario = SelectDadosUsuario($_SESSION['ID']))
	{
		if($DadosTime = SelectDadosTime($_SESSION['ID']))
		{
			
			// Preenchendo Radiobutton
				if($DadosTime['campo'] == 0)
				{
					$Normal = "checked";
					$Society = "";
				}
				else
				{
					$Normal = "";
					$Society = "checked";
				}
			
			// Carrega dados		
			echo "<div class='row'>
			<div class='col s12' style='margin-top:15px;'>
				<div class='card-panel blue darken-4 white-text'><center>Dados da Conta</center></div>
					<div class='row'>					    
						    
						<div class='col s12 m3'>
							<div class='card' style='max-width:400px; min-height:380px;'>
								<div class='card-image' style='max-width:370px; min-height:300px;'>
								  <img class='activator' src='image/times/".$DadosTime['foto']."'>
								</div>
								<div class='card-content' style='padding-top:0px;'>
									<div class='col s12 m10'>
										<span class='activator grey-text text-darken-4'>Alterar</span>
									</div>
									<div class='col s12 m2'>
										<i class='card-title activator material-icons right'>more_vert</i>
									</div>
								</div>
								<div class='card-reveal green lighten-5'>
									<div class='row'>											
										<div class='col s12 m10'>
											<span class='activator grey-text text-darken-4'><b>Alterar Imagem</b></span>
										</div>
										<div class='col s12 m2'>
											<i class='card-title activator material-icons right'>close</i>
										</div>
									</div>
									<div class='row'>
										<form method='post' enctype='multipart/form-data'>
											<div class='file-field input-field col s12 m12'>
												<input type='file' name='CriaImagemCampo' class='btn'>
												<div class='file-path-wrapper'>
													<i class='material-icons prefix'>open_in_browser</i>
													<input class='file-path validate' placeholder='Busque a imagem' type='text' name='CriaCampEndImag'>
												</div>
												<button name='AltImage' type='submit' class='btn blue white-text'>ALTERAR</button>
											</div>
										</form>
									</div>
								</div>
							</div>           
						</div>
						
						<div class='col s12 m4 teal lighten-5' style='border:2px solid #2e7d32; margin-top:7px;'>
							<div class='card-panel teal darken-4 white-text'><center>Dados Usuário</center></div>
							<form onsubmit='return Valida(this)' method='post' action=''>
								<div class='input-field col s12' style='margin:10px;'>
									<input placeholder='Placeholder' id='usuario' type='text' class='validate' name='Nome' value='".$DadosUsuario['nome']."'>
									<label for='usuario'>Nome do Usuário</label>
								</div>
								<div class='input-field col s12' style='margin:10px;'>
									<input id='usuario' type='text' class='validate' name='Email' value='".$DadosUsuario['email']."'>
									<label for='usuario'>Email</label>
								</div>
								<div class='input-field col s12 m6' style='margin-top:10px;'>
									<input id='RG' type='text' class='validate' name='RG' value='".$DadosUsuario['rg']."'>
									<label for='RG'>RG (apenas números)</label>
								</div>
								<div class='input-field col s12 m6' style='margin-top:10px;'>
									<input id='CPF' type='text' class='validate' name='CPF' value='".$DadosUsuario['cpf']."'>
									<label for='CPF'>CPF (apenas números)</label>
								</div>
								<div class='input-field col s12 m6' style='margin-top:10px;'>
									<input id='Telefone' type='text' class='validate' name='Telefone' value='".$DadosUsuario['telefone']."' maxlength='11' length='11'>
									<label for='Telefone'>Telefone (apenas números)</label>
								</div>
								<div class='input-field col s12 m6' style='margin-top:10px;'>
									<input id='TelCel' type='text' class='validate'  name='Celular' value='".$DadosUsuario['celular']."' maxlength='14' length='14'>
									<label for='TelCel'>Celular (apenas números)</label>
								</div>
								<div class='input-field col s12' style='margin:10px;'>
									<input id='usuario' type='text' class='validate' name='Rua' value='".$DadosUsuario['rua']."'>
									<label for='usuario'>Rua</label>
								</div>
								<div class='input-field col s12 m8' style='margin:10px;'>
									<input id='usuario' type='text' class='validate' name='Bairro' value='".$DadosUsuario['bairro']."'>
									<label for='usuario'>Bairro</label>
								</div>
								<div class='input-field col s12 m2' style='margin:10px;'>
									<input id='usuario' type='text' class='validate' name='NumCasa' value='".$DadosUsuario['ncasa']."' maxlength='4'>
									<label for='usuario'>Nº Casa</label>
								</div>
								<div class='input-field col s12' style='margin:10px;'>
									<input id='usuario' type='text' class='validate' name='Cidade' value='".$DadosUsuario['cidade']."'>
									<label for='usuario'>Cidade</label>
								</div>
								<div class='input-field col s12' style='margin-top:5px; margin-bottom:15px; margin-left:8%; border-radius:3px;'>
									<input type='submit' class='btn blue white-text' value='Alterar dados de Usuario' name='AlterarDadosUsuario' />
								</div>
							</form>
						</div>
						
						<form onsubmit='return Valida(this)' method='post'>
							<div class='col s12 m4 teal lighten-5' style='border:2px solid #2e7d32; margin-left:5px; margin-top:7px;'>                
								<div class='card-panel teal darken-4 white-text'><center>Dados do Time</center></div>                
								<div class='input-field col s12'>
									<input id='Time' type='text' class='validate' name='nome_time' value='".$DadosTime['nome_time']."'>
									<label for='Time'>Nome do Time</label>
								</div>
								<div class='input-field col s12'>
									<input id='Uniforme' type='text' class='validate' name='cor_uniforme' value='".$DadosTime['cor_uniforme']."' maxlength='80' length='80'>
									<label for='Uniforme'>Cor do uniforme</label>
								</div>
								<div class='input-field col s12'>
									<input id='EndCampoUser' type='text' class='validate' name='campo_endereco' value='".$DadosTime['campo_endereco']."' maxlength='255' length='255'>
									<label for='EndCampoUser'>Endereço caso possua Campo fixo</label>
								</div>
								<div class='input-field col s12'>
									<input class='with-gap' name='RBCampo' type='radio' value='0' id='Campo' ".$Normal."/>
									<label for='Campo'>Campo Normal</label>
									<input class='with-gap' name='RBCampo' type='radio' value='1' id='Socyte' ".$Society."/>
									<label for='Socyte'>Campo Socyte</label>
								</div>
								<div class='input-field col s12' style='margin-top:35px; margin-bottom:15px; margin-left:12%;'>
									<input type='submit' class='btn blue white-text' value='Alterar dados de Time' name='AlterarDadosTime' />
								</div>
							</div>
						</form>				
					</div>
			</div>
		</div>";
		}
	}
	else
	{
		echo "";
	}
?>