<?php
	if(isset($_POST['pagamento_ativos']))
	{
		$UpdatePagamentoativos = $conexao->prepare("UPDATE `pagamento` SET `inicio` = ?, `fim` = ? WHERE `id` = ?");
		$UpdatePagamentoativos->execute(array(date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d').' + 30 days')), $_POST['pagamento_ativos']));
		echo "<script> window.onload = function() { Materialize.toast('Pagamento efetuado', 4000); }; </script>";
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
	}

	//Define onde começa a busca e quantos registros buscar
	$startPagamentoAtivos = 0;
	$limitPagamentoAtivos = 6;
	include("../class/conexao.php");
	$qtdPaginas = $conexao->prepare("SELECT COUNT(`id`) FROM `pagamento` WHERE (`fim` >= NOW())");
	$qtdPaginas->execute();
	$rows = $qtdPaginas->fetch(PDO::FETCH_NUM);
	//Define Quantas páginas existem
	$totalPagPagamentoAtivos = ceil($rows[0] / $limitPagamentoAtivos);
				
	if(isset($_GET['pgPagamentoAtivos']))
	{
		$pgPagamentoAtivos = $_GET['pgPagamentoAtivos'];
		$startPagamentoAtivos = ($pgPagamentoAtivos - 1) * $limitPagamentoAtivos;
	}
	else
	{
		isset($_GET['pgPagamentoAtivos']);
		$pgPagamentoAtivos = 1;
	}
?>
<table class="responsive-table striped bordered centered">
    <thead>
        <tr>
            <th>Usuário</th>
            <th>Time</th>
            <th>Email</th>
            <th>Ativo desde</th>
            <th>Expira em </th>
            <th>Controle </th>
        </tr>
    </thead>

    <tbody>
    	<form method="post">
        <?php
			// Busca os dados no banco e exibe conforme limite de registros e número de página
			$selectPagamento = $conexao->prepare("SELECT * FROM `pagamento` WHERE (`fim` >= NOW()) ORDER BY `fim` ASC LIMIT $startPagamentoAtivos, $limitPagamentoAtivos");
			$selectPagamento->execute();
			while($registroPag = $selectPagamento->fetch(PDO::FETCH_NUM))
			{
				$selectUsuario = $conexao->prepare("SELECT `email`, `nome` FROM `usuario` WHERE `id` = ?");
				$selectUsuario->execute(array($registroPag[1]));
				$registroUser = $selectUsuario->fetch(PDO::FETCH_NUM);
				
				$selectTime = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
				$selectTime->execute(array($registroPag[1]));
				$registroTime = $selectTime->fetch(PDO::FETCH_NUM);
				
				echo "
						<tr>
							<td>".$registroUser[1]."</td>
							<td>".$registroTime[0]."</td>
							<td>".$registroUser[0]."</td>
							<td>".implode('/', array_reverse(explode('-', $registroPag[2])))."</td>
							<td>".implode('/', array_reverse(explode('-', $registroPag[3])))."</td>
							<td><button name='pagamento_ativos' value='".$registroPag[0]."' class='btn-floating green'><i class='material-icons'>shopping_cart</i></button></td>
						</tr>
					 ";
			}
        ?>
        </form>
    </tbody>
</table>
<ul class="pagination">
    <?php
		if($totalPagPagamentoAtivos > 0)
		{
			// Se a página atual for maior que um, então habilita o botão "anterior"
			if($pgPagamentoAtivos > 1)
			{
				echo "<li><a href='?pag=Pagamentos&pgPagamentoAtivos=".($pgPagamentoAtivos-1)."'><i class='material-icons'>chevron_left</i></a></li>";
			}
			else
			{
				echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
			}
			
			// Cria o número das páginas uma a uma
			for($i = 1; $i <= $totalPagPagamentoAtivos; $i++)
			{
				if($i == $pgPagamentoAtivos)
				{
					echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>";
				}
				else
				{
					echo "<li><a href='?pag=Pagamentos&pgPagamentoAtivos=".$i."'>".$i."</a></li>";
				}
			}
			
			// 	Se página atual for a última, então não deixa ir a próxima, se não habilita o botão "próxima"
			if($pgPagamentoAtivos == $totalPagPagamentoAtivos)
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
			}
			else
			{
				echo "<li><a href='?pag=Pagamentos&pgPagamentoAtivos=".($pgPagamento + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
			}
		}
    ?>
</ul>