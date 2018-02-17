<?php
	try
	{
		//Get image info from a valid image file
		$im_info = getimagesize($_FILES["image_patrocinio"]["tmp_name"]);
		if($im_info)
		{
			$im["image_width"]  = $im_info[0]; //image width
			$im["image_height"] = $im_info[1]; //image height
			$im["image_type"]   = $im_info['mime']; //image type
		}
		else
		{
			echo "Certifique que o arquivo <b>".$_FILES["image_patrocinio"]["name"]."</b> é um arquivo de imagem valido!";
		}
		
		date_default_timezone_set("Brazil/East"); //Definindo timezone padrão		
		$dir = '../../image/patrocinios/';
		//create image resource using Image type and set the file extension
		switch(strtolower($im["image_type"])){
			case 'image/png':
				$newname = date("Y.m.d-H.i.s").'.png';
				move_uploaded_file($_FILES['image_patrocinio']['tmp_name'], $dir.$newname); //Fazer upload do arquivo
				break;
			case 'image/jpeg':
				$newname = date("Y.m.d-H.i.s").'.jpeg';
				move_uploaded_file($_FILES['image_patrocinio']['tmp_name'], $dir.$newname); //Fazer upload do arquivo
				break;
			 case 'image/jpg':
				$newname = date("Y.m.d-H.i.s").'.jpg';
				move_uploaded_file($_FILES['image_patrocinio']['tmp_name'], $dir.$newname); //Fazer upload do arquivo
				break;
		}
		session_start();
		include("../../class/conexao.php");
		$Buscaimagem = $conexao->prepare("SELECT `imagem` FROM `patrocinadores` WHERE `id` = ?");
		$Buscaimagem->execute(array($_SESSION['id_patrocinio']));
		$BI = $Buscaimagem->fetch(PDO::FETCH_NUM);
		
		$UpdateImage = $conexao->prepare("UPDATE `patrocinadores` SET `nome` = ?, `link` = ?, `celular` = ?, `imagem` = ? WHERE `id` = ?");
		$UpdateImage->execute(array($_POST['EditPatTit'], $_POST['EditPatLink'], $_POST['EditPatTel'], $newname, $_SESSION['id_patrocinio']));
		unset($_SESSION['id_patrocinio']);
		if($BI[0] != "patrocinio.png"){unlink('../../image/patrocinios/'.$BI[0]);} // Caso a imagem seja diferente da padrão, exclui
		echo "<b> Imagem Atualizada</b>";
	}
	catch(Exception $error)
	{
		echo "Imagem muito grande, diminua a resolução!";
	}
	
?>