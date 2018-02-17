<?
	include("../class/conexao.php");
	$buscando_usuario = $conexao->prepare("SELECT `nome_time` FROM `time`");
	$buscando_usuario->execute();
	echo json_encode($busc_user = $buscando_usuario->fetch(PDO::FETCH_NUM));
?>