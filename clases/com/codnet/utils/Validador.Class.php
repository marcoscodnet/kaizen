<?php
class Validador {
	
	function validar_email($email) {
		$mail_correcto = 0;
		/*************************************************************************
		 * compruebo que el email tiene por lo menos 6 caracteres (el mínimo),
		 * que tiene un solo arroba y que no está colocada ni al principio
		 * ni al final. 
		 *************************************************************************/
		if ((strlen ( $email ) >= 6) && (substr_count ( $email, "@" ) == 1) && (substr ( $email, 0, 1 ) != "@") && (substr ( $email, strlen ( $email ) - 1, 1 ) != "@")) {
			//comprueba que no tiene algunos caracteres no permitidoss
			if ((! strstr ( $email, "'" )) && (! strstr ( $email, "\"" )) && (! strstr ( $email, "\\" )) && (! strstr ( $email, "\$" )) && (! strstr ( $email, " " )) && (! strstr ( $email, "/" ))) {
				//miro si tiene caracter .
				if (substr_count ( $email, "." ) >= 1) {
					//obtengo la terminacion del dominio
					$term_dom = substr ( strrchr ( $email, '.' ), 1 );
					//compruebo que la terminación del dominio sea correcta
					if (strlen ( $term_dom ) > 1 && strlen ( $term_dom ) < 5 && (! strstr ( $term_dom, "@" ))) {
						//compruebo que lo de antes del dominio sea correcto
						$antes_dom = substr ( $email, 0, strlen ( $email ) - strlen ( $term_dom ) - 1 );
						$caracter_ult = substr ( $antes_dom, strlen ( $antes_dom ) - 1, 1 );
						if ($caracter_ult != "@" && $caracter_ult != ".") {
							$mail_correcto = 1;
						}
					}
				}
			}
		}
		if ($mail_correcto)
			return 1; else
			return 0;
	}
	
	function validar_Fecha($fecha) {
		//valida formato dd/mm/yyyy
		$chars = strlen ( $fecha );
		if ($chars == 10) {
			$tmp = explode ( "/", $fecha );
			// La función Checkdate chequea si una fecha es valida.
			// solo hay que pasarle los parametros correctos, MM / DD / YYYY
			if (checkdate ( $tmp [1], $tmp [0], $tmp [2] )) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
?>