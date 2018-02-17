<?php
	if(isset($_POST['Confirmar_email']) && isset($_POST['email_email']))
	{
		include("class/conexao.php");
		$BuscDados = $conexao->prepare("SELECT `email`, `senha` FROM `usuario` WHERE `email` = ?");
		$BuscDados->execute(array($_POST['email_email']));
		$BS = $BuscDados->fetch(PDO::FETCH_NUM);
		echo "<script>alert('Email: ".$BS[0]." Senha: ".$BS[1]."');</script>";
		/*
		// Compo E-mail
		$arquivo = "
			<style type='text/css'>
				body { margin:0px; }
				.tituloEmail { width:100%; font-family: GillSans, Calibri, Trebuchet, sans-serif; background-color:#004d40; color:#FFF;	padding:10px; text-align:center; font-size:24px; }
				.LinkGeral { color:#FFF; text-decoration:none; }
				.Card { width:350px; margin-top:20px; background-color:#66bb6a; color:#FFF; font-family: GillSans, Calibri, Trebuchet, sans-serif; border-radius:2px; border:solid 2px #388e3c; margin-left:25px; }
				.CardTitulo { padding-top:10px; padding-bottom:10px; padding-left:20px; padding-right:20px; font-size:20px; text-align:center; background-color:#388e3c; }
				.CardInformacoes { padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px; font-size:18px; border-bottom:solid 2px #388e3c; }
				.CardBotao { padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px; }
				.BotaoAcessar {	margin-left:35%; padding:10px; background-color:#388e3c; font-size:17px; color:#FFF; text-decoration:none; }
			</style>
			<html>
				<div class='tituloEmail'> Bom Jogo </div>
				<div class='Card'>
					<a href='#' class='LinkGeral'>
						<div class='CardTitulo'> Relembre seus dados de acesso </div>
						<div class='CardInformacoes'> Seu Email: <b>$BS[0]</b> <br> Sua senha: $BS[1]</div>
						<div class='CardBotao'> <b><font class='BotaoAcessar'>Acessar</font></b> </div>
					</a>
				</div>
			</html>
		";
		//enviar
		// emails para quem será enviado o formulário
		$destino = $BS[0];
		$assunto = "Contato pelo Site";
		
		// É necessário indicar que o formato do e-mail é html
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		$enviaremail = mail($destino, $assunto, $arquivo, $headers);
		if($enviaremail)
		{
			echo "<script> alert('E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário');</script>";
			echo "<meta http-equiv='refresh' content='10;URL=contato.php'>";
		}
		else
		{
			echo "<script> alert('ERRO AO ENVIAR E-MAIL!');</script>";
			echo "<script> alert('".$enviaremail."');</script>";
		}*/
	}
?>
<div class="row">
    <div class="col s12 m6">
        <div class="card-panel teal darken-4">
            <H5 class="white-text">Após confirmar, aguarde nosso email</H5>
			<form method="post">
                <div class="row">
                    <div class="input-field inline">
                        <input id="email_email" type="email" name="email_email" class="validate" style="color:#FFF;">
                        <label for="email_email" data-error="wrong" data-success="right">Email</label>
                    </div>
                </div>
                <div class="row">
                    <button class="btn light-blue darken-4" type="submit" style="margin-left:35%" name="Confirmar_email">Confirmar</button>
                </div>
			</form>
        </div>
    </div>
</div>