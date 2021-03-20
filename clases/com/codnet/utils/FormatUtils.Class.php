<?php



/**

 * Utilidades para el tratamiento de formatos.

 *

 * @author bernardo

 * @since 10-03-2010

 */

class FormatUtils{





	public static function isEmpty($value){

		return $value==null || $value=='' || $value==0;

	}



	public static function ifEmpty($value,$show){

		return (FormatUtils::isEmpty($value))?$show:$value; //TODO parse number.

	}

    public static function formatString( $value ){
        $res = addslashes($value);
        return "'$res'";
    }

	public static function formatEmpty($value){

		return (FormatUtils::isEmpty($value))?'':$value;

	}



	public static function quitarEnters($value){

		$value = str_replace("\n", "", $value);

		return str_replace("\r", "", $value);

	}



	/**

	 * si cd1=cd2, formatea la salida :

	 *     'cd1' selected='selected'

	 *

	 * @param unknown_type $cd1

	 * @param unknown_type $cd2

	 * @return unknown_type

	 */

	public static function selected($cd1, $cd2){

		$value='';

		if($cd1==$cd2){

				$value = "'". $cd1. "'" . " selected='selected'" ;

		}else{

				$value = $cd1;

		}

		return $value;

	}



	public static function getParam($name, $default=''){

		if (isset ( $_GET [$name] ))

			$value = $_GET [$name];



		if(empty($value))

			$value = $default;

		return $value;

	}

    public static function formatDate( $value, $format = "Y-m-d H:i:s"){

        if(empty($value))
            return "null";
        if(($value=='0000-00-00'))
            return "null";


        $value = str_replace('/', '-', $value);
        $time = strtotime( $value );
        $res = FormatUtils::formatString( date( $format, $time) );



        return $res;
    }



	/*

	 * retorna la acci�n que se est� ejecutando.

	 */

	public static function getCurrentAction(){

		if (isset ( $_GET ['action'] )) {

			$action = $_GET ['action'];



		}else{



			if (isset ( $_GET ['accion'] ))

				$action = $_GET ['accion'];

			else

 				$action = 'page_not_found' ;



		}



		return $action;

	}

}

