<?php
	require_once "class/login.php";
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(isset($_POST['email']) && isset($_POST['senha']))
		{			
			if(($ReturnLogin = Login($_POST['email'], $_POST['senha'])) != null)
			{
				if($ReturnLogin == 5)
				{
					echo "<script> window.onload = function() {					  
					  Materialize.toast('Usuário e/ou senha incorreto', 4000);
					};</script>";
				}												
				else if($ReturnLogin == 4)
				{
					echo "<script> window.onload = function() {					  
					  Materialize.toast('Usuário bloqueado por reporte em partidas, aguarde a liberação pelo ADM do site', 10000, 'red white-text');
					};</script>";
				}
				else if($ReturnLogin == 3)
				{
					echo "<script> window.onload = function() {					  
					  Materialize.toast('Usuário expirou, acesse o pagSeguro e realize o pagamento e/ou aguarde a liberação pelo ADM do site ', 10000, 'red white-text');
					};</script>";
				}
				else if($ReturnLogin == 2)
				{
					header("Location:index.php");
				}
				else if($ReturnLogin == 1)
				{
					header("Location:admin/index.php");
				}
				else
				{
					
				}				
			}
		}		
	}	
?>

<div class="remodal" data-remodal-id="modalLogin" style="padding:0px;">
    <div class="card" style="margin:0px;">
    	<form method="post">
            <div class="card-content" style="padding:0px;">
                <div class="row blue">
                    <a data-remodal-action="close" class="remodal-close btn-floating red white-text" style="margin:5px;"></a>
                    <span class="card-title white-text">Login</span>
                </div>
                <div class="row">                    
                        <div class="input-field col s12">
                          <i class="material-icons prefix">account_circle</i>
                          <input id="icon_prefix" type="text" class="validate" name="email">
                          <label for="icon_prefix">email</label>
                        </div>
                        <div class="input-field col s12">
                          <i class="material-icons prefix">lock</i>
                          <input id="icon_prefix" type="password" class="validate" name="senha">
                          <label for="icon_prefix">Senha</label>
                        </div>                    
                </div>
                <div class="row" style="text-align:left; margin-left:15px;">
                	<label><a href="Home.php?pag=Senha" <?php if(@$_GET['pag'] == "Senha"){}?>>Esqueci minha senha</a></label>
                </div>
            </div>
            <div class="card-action">
                <button type="submit" class="btn blue white-text"><i class="material-icons left">input</i> Entrar</button>
                <a class="btn red white-text" href="Cadastrar.php"><i class="material-icons left">assignment</i>Cadastrar</a>
            </div>
		</form>        
	</div>
</div>