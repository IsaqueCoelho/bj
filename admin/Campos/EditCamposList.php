<?php
	if(isset($_POST['Delete_Campo']))
	{
		$BuscImagem = $conexao->prepare("SELECT `imagem` FROM `campos` WHERE `id` = ?");
		$BuscImagem->execute(array($_POST['Delete_Campo']));
		$BIma = $BuscImagem->fetch(PDO::FETCH_NUM);
		unlink("../image/campos/".$BIma[0]);
		
		$DeleteCampo = $conexao->prepare("DELETE FROM `campos` WHERE `id` = ?");
		$DeleteCampo->execute(array($_POST['Delete_Campo']));
		echo "<script> window.onload = function() {					  
					  Materialize.toast('Campo Deletado', 4000);
					};</script>";
	}
?>
<table class="responsive-table centered striped">
    <thead>
        <tr>
            <th>Imagem</th>
            <th width="50px">Título</th>
            <th>Tipo</th>
            <th>Telefone</th>
            <th width="150px">Endereço</th>
            <th>Opção</th>
        </tr>
    </thead>

    <tbody>
    	<form method="post">
        <?php
			require_once "BuscaListCampo.php";			
			$startCampo = 0;
			$limitCampo = 4;
			
			// Recebe quantidade total de páginas
			$totalPagCampo = qtdPagCampos($limitCampo);
			
			if(isset($_GET['pgCampo']))
			{
				$pgCampo = $_GET['pgCampo'];
				$startCampo = ($pgCampo - 1)*$limitCampo;
			}
			else
			{
				isset($_GET['pgCampo']);
				$pgCampo = 1;
			}
			
			//$conexao = new PDO('mysql:host=localhost;dbname=bj','root','');
			include("../class/conexao.php");
			$selectCampo = $conexao->prepare("SELECT * FROM `campos` ORDER BY id DESC LIMIT $startCampo, $limitCampo");
			$selectCampo->execute();
			$Campo = $selectCampo->fetch(PDO::FETCH_NUM);
			if($Campo > 0)
			{		
				do
				{
					if($Campo[3] == 0)
					{
						$TipoCampo = "green-text'>Normal";
					}
					else
					{
						$TipoCampo = "blue-text'>Society";
					}						
					echo "<tr>
							<td><img class='responsive-img' src='../image/campos/".$Campo[5]."' width='100px'></td>
							<td>".$Campo[1]."</td>
							<td class='".$TipoCampo."</td>            
							<td>".$Campo[2]."</td>
							<td>".$Campo[4]."</td>
							<td><button id='Edit_Campo' data-id='".$Campo[0]."' class='btn-floating green hide-on-med-and-down' data-remodal-target='modalCampo' ><i class='material-icons'>edit</i></button><button name='Delete_Campo' value='".$Campo[0]."' class='btn-floating red'><i class='material-icons'>delete</i></button></td>
						</tr>";						 
				}while($Campo = $selectCampo->fetch(PDO::FETCH_NUM));
			}
    ?>
    </form>
    </tbody>
</table>

<ul class='pagination right'>
	<?php
		if($totalPagCampo > 0 )
		{
			if($pgCampo>1)
			{
				echo "<li><a href='?pgCampo=".($pgCampo-1)."'><i class='material-icons'>chevron_left</i></a></li>";
			}
			else
			{
				echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
			}
			
				for($NumPGCampo=1;$NumPGCampo<=$totalPagCampo;$NumPGCampo++)
				{
					if($NumPGCampo==$pgCampo) { echo "<li class='waves-effect teal darken-4 white-text'>".$NumPGCampo."</li>"; }
				
					else { echo "<li><a href='?pgCampo=".$NumPGCampo."'>".$NumPGCampo."</a></li>"; }
				}
			
			if($pgCampo == $totalPagCampo)
			{
				echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
			}
			else
			{
				echo "<li><a href='?pgCampo=".($pgCampo+1)."'><i class='material-icons'>chevron_right</i></a></li>";
			}
		}
		else
		{}
	?>
</ul>