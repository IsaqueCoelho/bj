<head>
	<?php header('Content-Type: text/html; charset=UTF-8;'); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Isaque D. Coelho" />
    <title>Bom Jogo - Administrador</title>
</head>

<div class="col s12 m6" style="margin-top:20px;">
	<div class="card-panel blue-grey darken-4 white-text"><center>Adicionar Notícia</center></div>
    <?php include("Post/CriaPost.php");?>
</div>

<div class="col s12 m6 hide-on-med-and-down" style="margin-top:20px;">
	<div class="card-panel blue-grey darken-4 white-text"><center>Adicionar Campos</center></div>
    <?php include("Campos/CriaCampos.php");?>    
</div>

<div class="col s12 m12" style="margin-top:20px;">
	<div class="card-panel blue-grey darken-4 white-text"><center>Editar Notícia</center></div>
    <?php include("Post/EditPostList.php");?>
    
    <div class="remodal" data-remodal-id="modalPost" style="padding:0px;">	
        <div class="card" style="margin:0px;">
            <div class="card-content" style="padding:0px;">
                <div class="row blue">
                    <a data-remodal-action="close" id="fechar_form_editCampos" class="remodal-close btn-floating red white-text" style="margin:5px;"></a>
                    <span class="card-title white-text">Edite Post</span>
                </div>
                <div class="row" id="progressBar-EditPost">
                    <div class="preloader-wrapper active">
                        <div class="spinner-layer spinner-red-only">
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
                <div class="row" id="conteudo-EditPostModal">
                    
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="col s12 m12" style="margin-top:20px;">
	<div class="card-panel blue-grey darken-4 white-text"><center>Campos</center></div>
	<?php include("Campos/EditCamposList.php"); ?>
    
    <div class="remodal" data-remodal-id="modalCampo" style="padding:0px;">        
        <div class="card" style="margin:0px;">
            <div class="card-content" style="padding:0px;">
                <div class="row blue">
                    <a data-remodal-action="close" id="fechar_form_editCampos" class="remodal-close btn-floating red white-text" style="margin:5px;"></a>
                    <span class="card-title white-text">Editar Campo</span>
                </div>
                
                <div class="row" id="progressBar-EditCampo">
                    <div class="preloader-wrapper active">
                        <div class="spinner-layer spinner-red-only">
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
                <div class="row" id="conteudo-EditCampoModal">
                    
                </div>
                                
            </div>
        </div>
    </div>
    
</div>

<div class="col s12 m12" style="margin-top:20px;">
	<div class="card-panel blue-grey darken-4 white-text"><center>Patrocinadores</center></div>
    <?php include("Patrocinadores/EditPatrocinadorList.php");?>
    
	<div class="remodal" data-remodal-id="modalPatrocinadores" style="padding:0px;">	
        <div class="card" style="margin:0px;">
            <div class="card-content" style="padding:0px;">
                <div class="row blue">
                    <a data-remodal-action="close" id="fechar_form_editCampos" class="remodal-close btn-floating red white-text" style="margin:5px;"></a>
                    <span class="card-title white-text">Edite Patrocinador </span>
                </div>
				
                <div class="row" id="progressBar-EditPatrocinador">
                    <div class="preloader-wrapper active">
                        <div class="spinner-layer spinner-red-only">
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
                
                <div class="row" id="conteudo-EditPatrocinadorModal">
                    
                </div>
                                
            </div>
        </div>
    </div>
    
</div>