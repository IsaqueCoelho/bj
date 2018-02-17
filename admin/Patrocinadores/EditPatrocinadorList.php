<?php
	require_once "BuscaPatrocinadores.php";	
	if(isset($_POST['Delete_Patrocinador']))
	{
		$BuscImagem = $conexao->prepare("SELECT `imagem` FROM `patrocinadores` WHERE `id` = ?");
		$BuscImagem->execute(array($_POST['Delete_Patrocinador']));
		$BIma = $BuscImagem->fetch(PDO::FETCH_NUM);
		if($BIma[0] != "patrocinio.png"){unlink("../image/patrocinios/".$BIma[0]);}
		
		$UpdatePatroc = $conexao->prepare("UPDATE `patrocinadores` SET `nome` = ?, `link` = ?, `celular` = ?, `imagem` = ? WHERE `id` = ?");
		$UpdatePatroc->execute(array('Patrocine aqui', '#', '(000)00000-0000', 'patrocinio.png',$_POST['Delete_Patrocinador']));
		echo "<script> window.onload = function() {	Materialize.toast('Patrocinador deletado, Dados resetados', 4000, 'white-text');}; </script>";
	}
?>

<table class="responsive-table centered highlight">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Título</th>
            <th>Link</th>
            <th>Telefone</th>
            <th>Opção</th>
        </tr>
    </thead>

    <tbody>
    	<form method="post">
        <?php
			include("../class/conexao.php");
			$selectPatrocinador = $conexao->prepare("SELECT * FROM `patrocinadores`");
			$selectPatrocinador->execute();
			$Patrocinador = $selectPatrocinador->fetch(PDO::FETCH_ASSOC);
			if($Patrocinador > 0)
			{		
				do
				{
					
					echo "<tr>
                            <td><img class='responsive-img' src='../image/patrocinios/".$Patrocinador['imagem']."' width='100px'></td>
                            <td>".$Patrocinador['nome']."</td>
                            <td>".$Patrocinador['link']."</td>
                            <td>".$Patrocinador['celular']."</td>
                            <td><button id='Edit_Patrocinador' data-id='".$Patrocinador['id']."' class='btn-floating green hide-on-med-and-down' data-remodal-target='modalPatrocinadores'><i class='material-icons'>edit</i></button><button name='Delete_Patrocinador' value='".$Patrocinador['id']."' class='btn-floating red'><i class='material-icons'>delete</i></button></td>
                         </tr>";
						 
				}while($Patrocinador = $selectPatrocinador->fetch(PDO::FETCH_ASSOC));			
			}			
        ?>
        </form>
    </tbody>
</table>