<?php
	if(isset($_POST['pagamento_inativos']))
	{
		$UpdatePagamentoInativos = $conexao->prepare("UPDATE `pagamento` SET `inicio` = ?, `fim` = ? WHERE `id` = ?");
		$UpdatePagamentoInativos->execute(array(date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d').' + 30 days')), $_POST['pagamento_inativos']));
		echo "<script> window.onload = function() { Materialize.toast('Pagamento efetuado', 4000); };</script>";
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
	}
	
	//Define onde começa a busca e quantos registros buscar
	$startPagamentoInativos = 0;
	$limitPagamentoInativos = 10;
	include("../class/conexao.php");
	$qtdPaginas = $conexao->prepare("SELECT COUNT(`id`) FROM `pagamento` WHERE (`fim` < NOW())");
	$qtdPaginas->execute();
	$rows = $qtdPaginas->fetch(PDO::FETCH_NUM);
	//Define Quantas páginas existem
	$totalPagPagamentoInativos = ceil($rows[0] / $limitPagamentoInativos);
	if(isset($_GET['pgPagamentoInativos']))
	{
		$pgPagamentoInativos = $_GET['pgPagamentoInativos'];
		$startPagamentoInativos = ($pgPagamentoInativos - 1) * $limitPagamentoInativos;
	}
	else
	{
		isset($_GET['pgPagamentoInativos']);
		$pgPagamentoInativos = 1;
	}
?>
<table class="responsive-table striped bordered centered">
    <thead>
        <tr>
            <th>Usuário</th>
            <th>Time</th>
            <th>Email</th>
            <th>Bloqueado desde</th>
            <th>Controle </th>
        </tr>
    </thead>

    <tbody>
    	<form method="post">
        <?php
			// Busca os dados no banco e exibe conforme limite de registros e número de página
			$selectPagamento = $conexao->prepare("SELECT `id`, `id_usuario`, `fim` FROM `pagamento` WHERE (`fim` < NOW()) ORDER BY `fim` ASC LIMIT $startPagamentoInativos, $limitPagamentoInativos");
			$selectPagamento->execute();
			while($RP = $selectPagamento->fetch(PDO::FETCH_NUM))
			{
				$selectUsuario = $conexao->prepare("SELECT `email`, `nome` FROM `usuario` WHERE `id` = ?");
				$selectUsuario->execute(array($RP[1]));
				$SU = $selectUsuario->fetch(PDO::FETCH_NUM);
				
				$selectTime = $conexao->prepare("SELECT `nome_time` FROM `time` WHERE `id_usuario` = ?");
				$selectTime->execute(array($RP[1]));
				$ST = $selectTime->fetch(PDO::FETCH_NUM);
				
				echo "
						<tr>
							<td>".$SU[1]."</td>
							<td>".$ST[0]."</td>
							<td>".$SU[0]."</td>
							<td>".implode('/', array_reverse(explode('-', $RP[2])))."</td>
							<td><button name='pagamento_inativos' value='".$RP[0]."' class='btn-floating green'><i class='material-icons'>shopping_cart</i></button></td>
						</tr>
					 ";
			}
        ?>
        </form>
    </tbody>
</table>
<ul class="pagination">
    <?php
		if($totalPagPagamentoInativos > 0)
		{
			// Se a página atual for maior que um, então habilita o botão "anterior"
			if($totalPagPagamentoInativos > 1)
			{
				echo "<li><a href='?pag=Pagamentos&pgPagamentoInativos=".($pgPagamentoInativos-1)."'><i class='material-icons'>chevron_left</i></a></li>";
			}
			else
			{
				echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
			}
			
			// Cria o número das páginas uma a uma
			for($i = 1; $i <= $totalPagPagamentoInativos; $i++)
			{
				if($i == $pgPagamentoInativos)
				{
					echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>";
				}
				else
				{
					echo "<li><a href='?pag=Pagamentos&pgPagamentoInativos=".$i."'>".$i."</a></li>";
				}
			}
			
			// 	Se página atual for a última, então não deixa ir a próxima, se não habilita o botão "próxima"
			if($pgPagamentoInativos == $totalPagPagamentoInativos)
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
			}
			else
			{
				echo "<li><a href='?pag=Pagamentos&pgPagamentoInativos=".($pgPagamentoInativos + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
			}
		}
    ?>
</ul>