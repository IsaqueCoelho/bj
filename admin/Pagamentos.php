<head>
    <meta name="author" content="Isaque D. Coelho"/>
    <title>Bom Jogo - Administrador</title>
</head>
<div class="col s12">
    <div class="card-panel blue darken-4 white-text"><center>Times Ativos</center></div>
	<?php include("Pagamentos/PagamentosList.php");?>
</div>

<div class="col s12">
    <div class="card-panel blue darken-4 white-text"><center>Times Inativos</center></div>
    <?php include("Pagamentos/BloqueadosList.php");?>
</div>