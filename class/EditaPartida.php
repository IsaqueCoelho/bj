<?php 

	if(isset($_REQUEST['idPartida']))
	{
		require_once("conexao.php");
		session_start();
		
		if(date('Y-m-d', strtotime(implode('-',array_reverse(explode('/',$_POST['data_Parti']))))) >= date("Y-m-d", strtotime(date("Y-m-d")." + 1 days")))
		{
			//Atualiza os dados da partida
			$ep = $conexao->prepare('UPDATE `partida` SET `tipo_campo` = ?, `data` = ?, `horario` = ?, `rua` = ?, `numero` = ?, `bairro` = ?, `cidade` = ? WHERE `id` = ?');
			$ep->execute(array($_POST['campo'], date('Y/m/d',strtotime(implode('-',array_reverse(explode('/',$_POST['data_Parti']))))), $_POST['hora'], $_POST['rua'], $_POST['num'], $_POST['bairro'], $_POST['cidade'], $_POST['idPartida'],));
			//Cria a notificação de partida editada
			$ProcuraUserEditado = $conexao->prepare("SELECT `id_desafiante`, `id_desafiado` FROM `partida` WHERE `id` = ?");
			$ProcuraUserEditado->execute(array($_POST['idPartida']));
			$UserEditado = $ProcuraUserEditado->fetch(PDO::FETCH_NUM);
			
			if($UserEditado[1] == $_SESSION['ID'])
			{
				$RecebeNotifiEditado = $UserEditado[0];
				$CriandoNotifiEditado = $UserEditado[1];
			}
			else
			{
				$RecebeNotifiEditado = $UserEditado[1];
				$CriandoNotifiEditado = $UserEditado[0];
			}
			
			$CriaNotifiEditado = $conexao->prepare("INSERT INTO `notificacao`(id_criaNotifi, id_recebeNotifi, id_partida, tipo, visualizado) VALUES(?,?,?,?,?)");
			$CriaNotifiEditado->execute(array($CriandoNotifiEditado, $RecebeNotifiEditado, $_POST['idPartida'], 2, 0));
			
			echo "0";
		}
		else
		{
			echo "1";
		}
	}
?>