<?php

class MyMethods extends CApplicationComponent
{
	/**
	 * Retorna una url mas comprensible para el visitante del sitio.
	 * @param string $url url rara y poco comprensible por el visitante.
	 * @return Nueva url recodificada y comprensible por el visitante.
	 */
	public static function normalizarUrl($url){
		$originales = 'ÀÁÈÉÌÍÑÒÓÙÚÜàáèéìíñòóùúü&.,¿?!¡-';
	    $modificadas = 'aaeeiinoouuuaaeeiinoouuuy_______';
	    $cadena = utf8_decode($url);
	    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	    $cadena = strtolower($cadena);
	    $cadena = str_replace(' ', '_', $cadena);
	    $cadena = str_replace('__', '_', $cadena);
	    $cadena = str_replace('___', '_', $cadena);
	    return utf8_encode(MyMethods::clearSpecial($cadena));
	}

	/**
	 * Pasar todo a mayusculas (incluido acentos y Ñs)
	 */
	public static function myStrtoupper($cadena){
		return strtr(strtoupper($cadena),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
	}

	/**
	 * Codificar password de usuario
	 */
	public static function crypt_blowfish($password, $digito = 7){  
		$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$salt = sprintf('$2a$%02d$', $digito);
		
		for($i = 0; $i < 22; $i++){
			$salt .= $set_salt[mt_rand(0, 63)];
		}
		return crypt($password, $salt);
	}

	/**
	 * Generar cadenas de seguridad (codigos de verificacion)
	 */
	public static function generarCadenaSeguridad($longitudPass = 60){
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitudCadena=strlen($cadena);
		$pass = "";
		//$longitudPass=60;
		
		for($i=1 ; $i<=$longitudPass ; $i++){
			$pos=rand(0,$longitudCadena-1);
			$pass .= substr($cadena,$pos,1);
		}
		
		return $pass;
	}

	/**
	 * Quitar caracteres especiales de una cadena
	 */
	public static function clearSpecial($cadena){
		$cadena = htmlentities($cadena);
		$cadena = preg_replace('/\&(.)[^;]*;/', '\\1', $cadena);
		$cadena = preg_replace("([^A-Za-z0-9_])","", $cadena);

		return $cadena;
	}

	public static function isValidDate($value, $format='d/m/Y h:i A'){
		date_default_timezone_set('America/Bogota');
		
	    $isValid = false;
	    $value = trim($value);
		$date = @date_create(str_replace("/","-",$value), new DateTimeZone('Europe/London'));

		if(@date_format($date, $format) == $value)
			$isValid = true;

		return $isValid;
	}

	public static function censorEmail($email){
		return preg_replace('/[^~,][^~,][^~,]@/', '***', $email);
	}

	public static function sentMail($subject, $from, $to, $content, $options=array()){
		$fromName = (isset($options['fromName']))?$options['fromName']:'CoopeVogue';

		$subject='=?UTF-8?B?'.base64_encode($subject).'?=';
		$headers="From: ".$fromName." <".$from.">\r\n".
			"Reply-To: ".$from." \r\n".
			"MIME-Version: 1.0\r\n".
			"Content-type: text/html; charset=UTF-8";
		$body = '<table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;background:#9096a5;min-width:620px;table-layout:fixed;">'.
			'<tbody><tr>'.
			'<td align="center" style="padding-right:10px;padding-top:10px;padding-bottom:10px;padding-left:10px;">'.
			'<div style="width:auto;margin-right:auto;margin-left:auto;margin-top:0;margin-bottom:0;color:#000;font-family:Arial;font-size:12px;line-height:150%;">'.
			'<table style="width:100%;border-collapse:separate;table-layout:fixed;" cellspacing="0" cellpadding="0">'.
			'<tbody><tr><td align="center">'.
			'<table width="600" cellspacing="0" cellpadding="0" style="border-collapse:separate;border-spacing:0px;table-layout:fixed;width:600px;background:#2f3546;">'.
			'<tbody><tr><td>'.
			'<img style="border:0;width:600px;height:130px;display:block;" width="600" height="130" src="'.Yii::app()->createAbsoluteUrl("images/email/header.jpg").'">'.
			'</td></tr><tr>'.
			'<td style="background:#FFFFFF;padding-top:10px;padding-right:35px;padding-bottom:10px;padding-left:35px;" >'.
			'<div style="word-wrap:break-word;line-height:19.600000381469727px;color:#444444;">'.
			$content.'<br>'.
			'Enviado desde sitio web CoopeVogue<br><br>'.
			'</div></td></tr>'.
			'<tr><td align="center" style="background-color:#eeeeee; color:#444444; font-size:10px; padding-top:5px; padding-bottom:5px;">Derechos reservados CoopeVogue</td></tr>'.
			'</tbody></table></td></tr></tbody></table></div></td></tr></tbody></table>';

		return mail($to,$subject,$body,$headers);
	}


	public static function uploadImage($image, $maxSize, $destiny, $options=array()){
		$status = array(
			'status'=>false,
			'message'=>'Debe seleccionar una imagen!!!',
			'imageName'=>null
		);

		$formatAllowed = array("image/jpg", "image/jpeg", "image/png");

		if($image['size'] > 0){
			$errors = false;

			if(!(in_array($image['type'], $formatAllowed))){
				$errors = true;
				$status['message'] = 'El archivo seleccionado no corresponde a una imagen!!!';
			}
			else if($image['size'] > ($maxSize*1024)){
				$errors = true;
				$status['message'] = 'La imagen seleccionada excede el peso permitido!!!';
			}

			if(!$errors){
				$nameFile = explode(".", $image['name']);
                $nameImage = (isset($options['name']))?$options['name']:(md5(microtime()).".".$nameFile[count($nameFile)-1]);

                $tempFile = $image['tmp_name'];
                $targetPath = $_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl."/images/".$destiny;
                $targetFile =  $targetPath.$nameImage;

                if(move_uploaded_file($tempFile, $targetFile)){
                	$status['status'] = true;
                	$status['message'] = 'La imagen se cargo correctamente!!!';
                	$status['imageName'] = $nameImage;
                }
                else
                	$status['message'] = 'Se presento un error cargando la imagen!!!';
			}
		}

		return $status;
	}

	//public static function resizeImage($image, $nameImagen, $width, $height){
	public static function resizeImage($galery, $name, $minWidth, $minHeight, $scalar=true, $options=array()){
		list($currentWidth, $currentHeight) = getimagesize($galery.$name);

		$scale = $minWidth / $currentWidth;
		if(($currentHeight * $scale) < $minHeight)
			$scale = $minHeight / $currentHeight;

		$newWidth = ($scalar)?($currentWidth * $scale):$minWidth;
		$newHeight = ($scalar)?($currentHeight * $scale):$minHeight;

		$canvas = imagecreatetruecolor($newWidth, $newHeight);
		$mime = getimagesize($galery.$name);

		switch ($mime['mime']){
			case "image/jpg":
			case "image/jpeg":
				$image = imagecreatefromjpeg($galery.$name);
				break;
			case "image/png":
				$image = imagecreatefrompng($galery.$name);
				$background = imagecolorallocatealpha($src,0,0,0,127);
				imagecolortransparent($image, $background);
				imagealphablending($image, false);
				imagesavealpha($image, true);
				
				break;
			case "image/gif":
				$image = imagecreatefromgif($galery.$name);
				break;
		}

		imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $currentWidth, $currentHeight);

		imagedestroy($image);

		switch ($mime['mime']){
			case "image/jpg":
			case "image/jpeg":
				imagejpeg($canvas, $galery.$minWidth."x".$minHeight."/".$name, 99);
				break;
			case "image/png":
				imagepng($canvas, $galery.$minWidth."x".$minHeight."/".$name, 9);
				break;
			case "image/gif":
				imagegif($canvas, $galery.$minWidth."x".$minHeight."/".$name);
				break;
		}
	}

	public static function uploadFile($file,$path){
		$returnName = '';
		
		$nameImage = $file['name'];
        $tempFile = $file['tmp_name'];
        $targetPath = $_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/'.$path;
        $targetFile =  $targetPath.$nameImage;
        if(move_uploaded_file($tempFile, $targetFile)){
            $returnName = $nameImage;
        }

        return $returnName;
	}

	/**
	 * Obtener Listas Para Select
	 */
	public static function getListSelect($inModel, $key, $value, $options=array()){
		$filter = "";
		if(isset($options['filter']))
			if(trim($options['filter']) != "")
				$filter = $options['filter'];

		$addForce = "";
		if(isset($options['addForce']))
			if(trim($options['addForce']) != "")
				$addForce = (($filter != '')?" OR ":'').$options['addForce'];

		$models = $inModel::model()->findAll(array(
			'condition'=>$filter.$addForce,
			'params'=>array(':key'=>1),
			'order'=>$value.' ASC',
		));
		
		$_items=array();
		
		if(count($models) > 0 && !(isset($options['type']) && $options['type'] == 'json'))
			$_items[null] = '--- Seleccione una opción ---';
		else if(count($models) == 0)
			$_items[null] = 'No hay disponibles';

		foreach($models as $model){
			if(isset($options['type']) && $options['type'] == 'json'){
				$aux = array(
					$key => $model->$key,
					$value => $model->$value
				);
				if(isset($options['add']))
					$aux[$options['add']] = $model->$options['add'];

				$_items[] = $aux;
			}
			else
				$_items[$model->$key] = $model->$value;
		}
		
		return $_items;
	}

	public static function hasPermission($permission){
		$user = Usuarios::model()->findByAttributes(array('id_usuario'=>Yii::app()->user->getState('_idUser'), 'estatus_usuario'=>1));

		if($user != null){
			if($user->rol_usuario == 1)
				return true;
			else{
				$permissions = CJSON::decode($user->permisos_usuario);
				if(in_array($permission, $permissions, false))
					return true;
				return false;
			}
		}
		else
			return false;
	}
	public static function isAdmin(){
		if(!Yii::app()->user->isGuest && Yii::app()->user->getState('_userRol') == 1)
			return true;
		return false;
	}

	public static function getModelErrors($errors){
		$error = '';
    	foreach ($errors as $key => $item) {
    		$error .= $item[0].'<br>';
    	}
    	return $error;
	}

	public static function querySql($sql){
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$dataReader = $command->query();

		return $dataReader->readAll();
	}
}