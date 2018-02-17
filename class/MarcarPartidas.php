<?php
	function Marcarpartida($ID, $Campo, $DataPartida, $Horario, $Rua, $Numero, $Bairro, $Cidade, $Time)
	{
		try
		{
			$data = date('Y-m-d', strtotime(implode('-',array_reverse(explode('/',$DataPartida)))));
			
			if($data >= date("Y-m-d", strtotime(date("Y-m-d")." + 1 days")))
			{
				include("conexao.php");
				$selectTime = $conexao->prepare("SELECT `id_usuario` FROM `time` WHERE `nome_time` = ?");
				$selectTime->execute(array($Time));
				$SelectTimeID = $selectTime->fetch(PDO::FETCH_NUM);
				if($SelectTimeID[0] == true && $SelectTimeID[0] != $ID)
				{
					// Insere Partida
					$insertPartida = $conexao->prepare("INSERT INTO `partida`(id_desafiante, id_desafiado, tipo_campo, data, horario, rua, numero, bairro, cidade, usuario_pontuando_partida, pontuado) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
					$insertPartida->execute(array($ID, $SelectTimeID[0], $Campo, date('Y/m/d',strtotime(implode('-',array_reverse(explode('/',$DataPartida))))), $Horario, $Rua, $Numero, $Bairro, $Cidade, 0, 0));
					$id_partida = $conexao->lastInsertId();
					
					// Insere Notificação
					$insertNotificacao = $conexao->prepare("INSERT INTO `notificacao` (id_criaNotifi, id_recebeNotifi, id_partida, tipo, visualizado, data) VALUES (?,?,?,?,?,?)");
					$insertNotificacao->execute(array($ID, $SelectTimeID[0], $id_partida, 0, 0, date('Y/m/d',strtotime(implode('-',array_reverse(explode('/',$DataPartida)))))));
					
					
					//Busca email do usuario pra Enviar Email
					$BuscEmailDesafiado = $conexao->prepare("SELECT `email` FROM `usuario` WHERE `id` = ?");					
					$BuscEmailDesafiado->execute(array($SelectTimeID[0]));
					$BED = $BuscEmailDesafiado->fetch(PDO::FETCH_NUM);
					echo "<script>alert('email para desafiado: ".$BED[0]."');</script>";
					/*// Corpo E-mail
					$arquivo = "
						<style type='text/css'>
							body { margin:0px; }
							.tituloEmail { width:100%; font-family: GillSans, Calibri, Trebuchet, sans-serif; background-color:#004d40; color:#FFF;	padding:10px; text-align:center; font-size:24px; }
							.LinkGeral { color:#FFF; text-decoration:none; }
							.Card { width:350px; margin-top:20px; background-color:#42a5f5; color:#FFF; font-family: GillSans, Calibri, Trebuchet, sans-serif; border-radius:2px; margin-left:25px; }
							.CardTitulo { padding-top:10px; padding-bottom:10px; padding-left:20px; padding-right:20px; font-size:20px; text-align:center; background-color:#1976d2; }
							.CardInformacoes { padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px; font-size:18px; border-bottom:solid 2px #1976d2; }
							.CardBotao { padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px; }
							.BotaoAcessar {	margin-left:35%; padding:10px; background-color:#1976d2; font-size:17px; color:#FFF; text-decoration:none; }
						</style>
						<html>
							<div class='tituloEmail'> Bom Jogo </div>
							<div class='Card'>
								<a href='#' class='LinkGeral'>
									<div class='CardTitulo'> Desafio de Partida </div>
									<div class='CardInformacoes'> Você foi <b>DESAFIADO</b> para uma partida. <br> Não perca tempo, acesse agora!</div>
									<div class='CardBotao'> <b><font class='BotaoAcessar'>Acessar</font></b> </div>
								</a>
							</div>
						</html>
					";
					// emails para quem será enviado o formulário
					$destino = $BED[0];
					$assunto = "Você foi Desafiado a uma partida no Bom Jogo";
					
					// É necessário indicar que o formato do e-mail é html
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					$enviaremail = mail($destino, $assunto, $arquivo, $headers);
					if(!$enviaremail)
					{
						echo "<script> alert('ERRO AO ENVIAR E-MAIL!');</script>";
						echo "<script> alert('".$enviaremail."');</script>";
					}*/
					return TRUE;
				}
				else
				{
					echo "<script> window.onload = function() {		  
						  Materialize.toast('Time adversário inválido', 4000, 'yellow darken-1');
						};</script>";
					return FALSE;
				}
			}
			else
			{
				echo "<script> window.onload = function() {
						  Materialize.toast('Data de partida inválida', 4000, 'yellow darken-1');
						};</script>";
				return FALSE;
			}			
		}
		catch(exception $e)
		{
			echo "<script> window.onload = function() {
					  Materialize.toast('Marcar partida falhou, contacte Administrador', 4000, 'yellow darken-1');
					};</script>";
		}
	}
?>