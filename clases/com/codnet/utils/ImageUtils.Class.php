<?php

/**
 * Utilidades para el tratamiento de im�genes.
 * 
 * @author bernardo
 * @since 10-03-2010
 */
class ImageUtils{
	
		
	public static function uploadImage($nombre_archivo_origen, $nombre_archivo_destino, $path_img_servidor,  $max_width=null){
			
		$destino = $path_img_servidor.$nombre_archivo_destino;
		
		$result=@move_uploaded_file($nombre_archivo_origen, $destino);
					
		//si se define un ancho m�ximo, se redefine el tama�o de la imagen.
		if($result && $max_width!=null)
			ImageUtils::resizeImage($destino);
			
		return $result;
	
	}
	
	public static function resizeImage($url_img){
		$image = imagecreatefromjpeg($url_img);
			
		// Obtengo ancho y alto orginal
		$width = imagesx($image);
		$height = imagesy($image);

		if($width > $max_width){
		   	$new_width = 110;
		    $new_height = $height * ($new_width/$width);
		
		    // Redimensiono
		    $image_resized = imagecreatetruecolor($new_width, $new_height);
		    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		    imageJPEG($image_resized,"$url_img");
		}			
		
	}
}
