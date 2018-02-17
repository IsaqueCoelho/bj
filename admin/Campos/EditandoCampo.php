<?php
	try
	{
		//Get image info from a valid image file
		$im_info = getimagesize($_FILES["EditCampImagem"]["tmp_name"]);
		if($im_info)
		{
			$im["image_width"]  = $im_info[0]; //image width
			$im["image_height"] = $im_info[1]; //image height
			$im["image_type"]   = $im_info['mime']; //image type
		}
		else
		{
			echo "Certifique que o arquivo <b>".$_FILES["EditCampImagem"]["name"]."</b> é um arquivo de imagem valido!";
		}
		
		date_default_timezone_set("Brazil/East"); //Definindo timezone padrão		
		$dir = '../../image/campos/';
		//create image resource using Image type and set the file extension
		switch(strtolower($im["image_type"])){
			case 'image/png':
				$newname = date("Y.m.d-H.i.s").'.png';
				move_uploaded_file($_FILES['EditCampImagem']['tmp_name'], $dir.$newname); //Fazer upload do arquivo
				break;
			case 'image/jpeg':
				$newname = date("Y.m.d-H.i.s").'.jpeg';
				move_uploaded_file($_FILES['EditCampImagem']['tmp_name'], $dir.$newname); //Fazer upload do arquivo
				break;
			 case 'image/jpg':
				$newname = date("Y.m.d-H.i.s").'.jpg';
				move_uploaded_file($_FILES['EditCampImagem']['tmp_name'], $dir.$newname); //Fazer upload do arquivo
				break;
		}
		session_start();
		include("../../class/conexao.php");
		$Buscaimagem = $conexao->prepare("SELECT `imagem` FROM `campos` WHERE `id` = ?");
		$Buscaimagem->execute(array($_SESSION['id_campo']));
		$BI = $Buscaimagem->fetch(PDO::FETCH_NUM);
		
		$UpdateImage = $conexao->prepare("UPDATE `campos` SET `nome` = ?, `celular` = ?, `tipo` = ?, `endereco` = ?, `imagem` = ? WHERE `id` = ?");
		$UpdateImage->execute(array($_POST['EditCampTit'], $_POST['EditCampTel'], $_POST['group2'], $_POST['EditCampEnd'], $newname, $_SESSION['id_campo']));
		unset($_SESSION['id_campo']);
		unlink('../../image/campos/'.$BI[0]);
		echo "<b> Imagem Atualizada</b>";
	}
	catch(Exception $error)
	{
		echo "Imagem muito grande, diminua a resolução!";
	}
	
?>