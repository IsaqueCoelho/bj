<head>
<?php header('Content-Type: text/html; charset=UTF-8;');?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Bom Jogo</title>
</head>

<div class="row">
    <div class="col s12 m6" style="margin-top:21px;">           
        <div class="card-panel blue darken-4 white-text"><center>Marque uma partida</center></div>
        <?php include("partidas/MarcarPartidas.php");?>        
    </div>
    
    <div class="col s12 m6" style="margin-top:20px;">
        <div class="card-panel blue darken-4 white-text"><center>Pontue jogos(realizados até 15 dias atrás)</center></div>
        <?php include("partidas/PontuePartidas.php");?>       
    </div>
</div>

<div class="row">
	<div class="card-panel blue darken-4 white-text" style="margin-bottom:0px;"><center>Edite partidas marcadas!</center></div>     
    <?php include("partidas/EditPartidasLista.php");?>
    <div class="remodal" data-remodal-id="modal2" style="padding:0px;">
	
    <!-- Editar Partidas-->
    <div class="card" style="margin:0px;">
    	<div class="card-content" style="padding:0px;">
        	<div class="row blue">
        		<a data-remodal-action="close" id="close_EditPartidas" class="remodal-close btn-floating red white-text" style="margin:5px;"></a>
            	<span class="card-title white-text">Edite Partida</span>
            </div>
            <!-- Barra de carregamento -->
        	<div class="row" id="progressBar-EditPartida">
                <div class="preloader-wrapper active">
                    <div class="spinner-layer spinner-green-only">
                      <div class="circle-clipper left">
                        <div class="circle"></div>
                      </div><div class="gap-patch">
                        <div class="circle"></div>
                      </div><div class="circle-clipper right">
                        <div class="circle"></div>
                      </div>
                    </div>
                </div>
            </div>
			<!-- fim da barra de carregamento -->
            <!-- Campos para editar -->
            <div class="row" id="content-editPartida">                            
            </div>
            <!--Fim dos campos-->
		</div>
	</div>
</div>    
    
</div>

<div class="row">
	<div class="card-panel blue darken-4 white-text"><center>Notificações</center></div>     
    <?php include("partidas/RecebePartidas.php");?> 
</div>