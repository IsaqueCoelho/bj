<?php
	function CadUsuario($email, $senha, $nome, $rg, $cpf, $telefone, $celular, $rua, $num_casa, $bairro, $cidade)
	{		
		try
		{
			include("conexao.php");
			$SelectUser = $conexao->prepare("SELECT `email` FROM `usuario` WHERE `email` = ?");
			$SelectUser->execute(array($email));
			$VerificaEmail = $SelectUser->fetch(PDO::FETCH_NUM);
			
			if($VerificaEmail == FALSE)
			{
				$insert = $conexao->prepare("INSERT INTO `usuario`(email, senha, nome, rg, cpf, telefone, celular, rua, ncasa, bairro, cidade, privilegio) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
				$insert->execute(array($email, $senha, $nome, $rg, $cpf, $telefone, $celular, $rua, $num_casa, $bairro, $cidade, "0"));
				
				if($insert)
				{
					return TRUE;
				}
				else
				{
					echo "<script> window.onload = function() {					  
						  Materialize.toast('Email já cadastrado', 4000, 'red white-text');
						};</script>";
				}	
			}
			else
			{
				return FALSE;
			}
		}
		catch(exception $e)
		{
			echo "<script> window.onload = function() {				  
					  //Materialize.toast('Cadastro de usuário falhou, contacte Administrador', 4000);
						alert('Erro: ".$e."');
					};</script>";
		}			
	}
	
	function CadTime($email, $nome_time, $campo)
	{
		try
		{			
			include("conexao.php");
			
			$select = $conexao->prepare("SELECT `id` FROM `usuario` WHERE `email` = ?");
			$select->execute(array($email));
			$cadsel = $select->fetch(PDO::FETCH_NUM);
			
			$selectTime = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `nome_time` = ?");
			$selectTime->execute(array($nome_time));
			$Veritime = $selectTime->fetch(PDO::FETCH_NUM);
			
			if(!$Veritime[0] == true)
			{				
				$insert = $conexao->prepare("INSERT INTO `time`(id_usuario, nome_time, cor_uniforme, campo_endereco, campo, foto) VALUES(?,?,'Cor de uniforme não definida!','Não possui campo',?,'logo.png');");
				$insert->execute(array($cadsel[0], $nome_time, $campo));
				
				$insertpagamento = $conexao->prepare("INSERT INTO `pagamento`(id_usuario, inicio, fim) VALUES(?,?,?)");
				$Datafinal = date('Y-m-d', strtotime(date('Y-m-d').' + 15 days'));
				$insertpagamento->execute(array($cadsel[0], date('Y-m-d'), $Datafinal));
				
				$insert_ranking = $conexao->prepare("INSERT INTO `ranking`(`id_usuario`, `pontos`, `tipo_campo`) VALUES(?,?,?)");
				$insert_ranking->execute(array($cadsel[0], 0, $campo));
				
				return TRUE;	
			}
			else
			{
				$deletaUser = $conexao->prepare("DELETE FROM `usuario` WHERE `id` = ?");
				$deletaUser->execute(array($cadsel[0]));
				return FALSE;
			}			
		}
		catch(exception $e)
		{
			echo "<script> window.onload = function() {					  
					  Materialize.toast('Cadastro de usuário falhou, contacte Administrador', 4000);
					};</script>";
		}
	}
?>