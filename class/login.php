<?php
	function Login($usuario, $senha)
	{
		include("class/conexao.php");
		$select = $conexao->prepare("SELECT * FROM `usuario` WHERE `email` = ? AND `senha` = ?");
		$select->execute(array($usuario, $senha));
		$login = $select->fetch(PDO::FETCH_ASSOC);

		if($login > 0)
		{
			if($login['privilegio'] == 1)
			{
				$_SESSION['ID'] = $login['id'];
				$_SESSION['PRIV'] = $login['privilegio'];
				$_SESSION['EMAIL'] = $login['email'];
				return 1;
			}
			else
			{
				$selectPagamento = $conexao->prepare("SELECT `fim` FROM `pagamento` WHERE `id_usuario` = ?");
				$selectPagamento->execute(array($login['id']));
				$UserAtivo = $selectPagamento->fetch(PDO::FETCH_NUM);
				
				$selectBloqueado = $conexao->prepare("SELECT `id` FROM `bloqueado` WHERE `id_usuario` = ?");
				$selectBloqueado->execute(array($login['id']));
				$UserBloqueado = $selectBloqueado->fetch(PDO::FETCH_NUM);
				
				if((date("Y-m-d") <= $UserAtivo[0]) && ($UserBloqueado[0] == false))
				{
					$_SESSION['ID'] = $login['id'];
					$_SESSION['PRIV'] = $login['privilegio'];
					$_SESSION['EMAIL'] = $login['email'];
					return 2;
				}
				else if(date("Y-m-d") >= $UserAtivo[0])
				{
					return 3;
				}
				else
				{
					return 4;
				}
			}
		}
		else
		{
			session_destroy();
			return 5;
		}
	}
?>