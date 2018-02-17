<?php
	if(isset($_POST['btnRejeitaPartidaEdit']))
	{
		//Busca o id do desafiante para criar a notificação de partida rejeitada
		$RejeitaPartidaEdit = $conexao->prepare("SELECT `id_criaNotifi`, `id_recebeNotifi`,`id_partida` FROM `notificacao` WHERE `id` = ?");
		$RejeitaPartidaEdit->execute(array($_POST['btnRejeitaPartidaEdit']));
		$dadosRejeitaPartidaEdit = $RejeitaPartidaEdit->fetch(PDO::FETCH_NUM);
		//Cria uma notificação de partida rejeitada
		
		if($dadosRejeitaPartidaEdit[0] == $_SESSION['ID'])
		{
			$idCriaNotifi = $dadosRejeitaPartidaEdit[1];
		}
		else
		{
			$idCriaNotifi = $dadosRejeitaPartidaEdit[0];
		}		
		
		$CriaNotRejeitaPartidaEdit = $conexao->prepare("INSERT INTO `notificacao`(id_criaNotifi, id_recebeNotifi, id_partida, tipo, visualizado) VALUES(?,?,?,?,?)");
		$CriaNotRejeitaPartidaEdit->execute(array($_SESSION['ID'], $idCriaNotifi, $dadosRejeitaPartidaEdit[2], 3, 0));
		
		//Exclui a notificação de partida do banco de dados
		$RejeitaVistoNotifiRecebe = $conexao->prepare("DELETE FROM `notificacao` WHERE `id` = ?");
		$RejeitaVistoNotifiRecebe->execute(array($_POST['btnRejeitaPartidaEdit']));	
		
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0'";
	}
?>
<div class="row">
<form method="post">
	<?php
        include("class/conexao.php");
        $startEditarPartida = 0;
        $limitEditarPartida = 8;
        
        $qtdPaginaEditarPartida = $conexao->prepare("SELECT COUNT(*) FROM `notificacao` WHERE (`tipo` = 0) AND (`id_recebeNotifi` = ? OR `id_criaNotifi` = ?) AND (`visualizado` = 1) AND (`data` >= NOW())");
        $qtdPaginaEditarPartida->execute(array($_SESSION['ID'], $_SESSION['ID']));		
        $LinhasEditPartida = $qtdPaginaEditarPartida->fetch(PDO::FETCH_NUM);
        
        //Numero de páginas
        $totalPagRecebeNotificacaoEditar = ceil($LinhasEditPartida[0]/$limitEditarPartida);		
		
        if(isset($_GET['pgEdit']))
        {
            $pgEdit = $_GET['pgEdit'];
            $startEditarPartida = ($pgEdit - 1) * $limitEditarPartida;
        }
        else
        {
            isset($_GET['pgEdit']);
            $pgEdit = 1;
        }
        
        $BuscaNotifiPartidaEdit = $conexao->prepare("SELECT `id`, `id_partida` FROM `notificacao` WHERE (`tipo` = 0) AND (`id_recebeNotifi` = ? OR `id_criaNotifi` = ?) AND (`visualizado` = 1) AND (`data` >= NOW()) LIMIT $startEditarPartida, $limitEditarPartida");
        $BuscaNotifiPartidaEdit->execute(array($_SESSION['ID'], $_SESSION['ID']));
        $DadosNotifiPartidaEditar = $BuscaNotifiPartidaEdit->fetch(PDO::FETCH_NUM);
        
        if($DadosNotifiPartidaEditar)
        {
            do
            {
                $BuscaPartidaEdit = $conexao->prepare("SELECT id, id_desafiante, id_desafiado, tipo_campo, data, horario, rua, numero, bairro, cidade FROM `partida` WHERE `id` = ?");
                $BuscaPartidaEdit->execute(array($DadosNotifiPartidaEditar[1]));
                $BuscaDadosPartidasEdit = $BuscaPartidaEdit->fetch(PDO::FETCH_NUM);
				
                if($BuscaDadosPartidasEdit[1] == $_SESSION['ID'])
                {
                    $BuscaDadosTime = $conexao->prepare("SELECT nome_time, foto FROM `time` WHERE `id_usuario` = ?");
                    $BuscaDadosTime->execute(array($BuscaDadosPartidasEdit[2]));
                    $BuscaDadosTimePartida = $BuscaDadosTime->fetch(PDO::FETCH_NUM); 
                    
                    if($BuscaDadosPartidasEdit[3] == 0)
                    {
                        $tipo_campo = "Normal";
                    }
                    else
                    {
                        $tipo_campo = "Society";
                    }
                    
                    echo "	<div class='col s12 m6'>
                                <div class='card lighten-1' style='background-color:#4527a0; margin-top:10px;'>
                                    <div class='card-content white-text' style='min-height:130px;'>
                                        <div class='col s12 m4'>
                                            <img src='image/times/".$BuscaDadosTimePartida[1]."' alt='' class='responsive-img' width='100px;' style='border-radius:7px;'>
                                        </div>
                                        <p> 
                                            DESAFIO com <b>".$BuscaDadosTimePartida[0]."</b> para o dia: <b>".implode("/",array_reverse(explode("-",$BuscaDadosPartidasEdit[4])))."</b>, horário: <b>".$BuscaDadosPartidasEdit[5]."</b>, em campo: <b>".$tipo_campo."</b>. <br>Endereço: Rua <b>".$BuscaDadosPartidasEdit[6]."</b>, Nº <b>".$BuscaDadosPartidasEdit[7]."</b>, <b>".$BuscaDadosPartidasEdit[8]."</b>, <b>".$BuscaDadosPartidasEdit[9]."</b>.
                                        </p>
                                    </div>
                                    <div class='card-action' style='border-top:solid #311b92;'>
                                        <button type='submit' class='btn-floating green' value='".$DadosNotifiPartidaEditar[0]."'  data-remodal-target='modal2' id='btnEditarPartida' data-id=".$DadosNotifiPartidaEditar[0]."><i class='material-icons'>edit</i></button><button type='submit' class='btn-floating red' name='btnRejeitaPartidaEdit' value='".$DadosNotifiPartidaEditar[0]."'><i class='material-icons'>delete</i></button>
                                    </div>
                                </div>
                            </div> ";			
                }
                else
                {
                    $BuscaDadosTime = $conexao->prepare("SELECT nome_time, foto FROM `time` WHERE `id_usuario` = ? ");
                    $BuscaDadosTime->execute(array($BuscaDadosPartidasEdit[1]));
                    $BuscaDadosTimePartida = $BuscaDadosTime->fetch(PDO::FETCH_NUM);
                    if($BuscaDadosPartidasEdit[3] == 0)
                    {
                        $tipo_campo = "Normal";
                    }
                    else
                    {
                        $tipo_campo = "Society";
                    }
                    
                    echo "	<div class='col s12 m6'>
                                <div class='card lighten-1' style='background-color:#4527a0; margin-top:10px;'>
                                    <div class='card-content white-text' style='min-height:130px;'>
                                        <div class='col s12 m4'>
                                            <img src='image/times/".$BuscaDadosTimePartida[1]."' alt='' class='responsive-img' width='100px;' style='border-radius:7px;'>
                                        </div>
                                        <p> 
                                            DESAFIO com <b>".$BuscaDadosTimePartida[0]."</b> para o dia: <b>".implode("/",array_reverse(explode("-",$BuscaDadosPartidasEdit[4])))."</b>, horário: <b>".$BuscaDadosPartidasEdit[5]."</b>, em campo: <b>".$tipo_campo."</b>. <br>Endereço: Rua <b>".$BuscaDadosPartidasEdit[6]."</b>, Nº <b>".$BuscaDadosPartidasEdit[7]."</b>, <b>".$BuscaDadosPartidasEdit[8]."</b>, <b>".$BuscaDadosPartidasEdit[9]."</b>.
                                        </p>
                                    </div>
                                    <div class='card-action' style='border-top:solid #311b92;'>
                                        <button type='submit' class='btn-floating green' value='".$DadosNotifiPartidaEditar[0]."'  data-remodal-target='modal2' id='btnEditarPartida' data-id=".$DadosNotifiPartidaEditar[0]."><i class='material-icons'>edit</i></button><button type='submit' class='btn-floating red' name='btnRejeitaPartidaEdit' value='".$DadosNotifiPartidaEditar[0]."'><i class='material-icons'>delete</i></button>
                                    </div>
                                </div>
                            </div> ";
                }
                
            }while($DadosNotifiPartidaEditar = $BuscaNotifiPartidaEdit->fetch(PDO::FETCH_NUM));
        }
		else
		{
			echo "	<div class='col s12 m6'>
						<div class='card-panel brown darken-1 white-text' style='margin-left:25px; margin-right:25px; text-align:center;'>Você não tem partidas!</div>
					</div>";
		}
    ?>
</form>
</div>
<div class="row">
    <ul class="pagination">
    	<?php
			if($totalPagRecebeNotificacaoEditar > 0)
			{
				if($pgEdit > 1)
				{
					echo "<li><a href='index.php?pag=Partidas&pgEdit=".($pgEdit - 1)."'><i class='material-icons'>chevron_left</i></a></li>";	
				}
				else
				{
					echo "<li class='disabled'><i class='material-icons'>chevron_left</i></li>";
				}
				
				for($i = 1; $i <= $totalPagRecebeNotificacaoEditar; $i++)
				{
					if($i == $pgEdit)
					{
						echo "<li class='waves-effect teal darken-4 white-text'>".$i."</li>";
					}
					else
					{
						echo "<li><a href='index.php?pag=Partidas&pgEdit=".$i."'>".$i."</a></li>";
					}
				}
				
				if($pgEdit == $totalPagRecebeNotificacaoEditar)
				{
					echo "<li class='desabled'><i class='material-icons'>chevron_right</i></li>";
				}
				else
				{
					echo "<li><a href='index.php?pag=Partidas&pgEdit=".($pgEdit + 1)."'><i class='material-icons'>chevron_right</i></a></li>";
				}
			}
		?>
    </ul>
</div>