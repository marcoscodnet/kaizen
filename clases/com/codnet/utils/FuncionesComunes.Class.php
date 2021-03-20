<?php

class FuncionesComunes
{

	/********************************************************
	 *	Convierte una fecha con formato "20/06/2008
	 *   al formato con el que se almacena en la BD 20080620
	 *********************************************************/
	static function fechaPHPaMysql($fechaPHP)
	{
		$fechaPHP = str_replace("-", "/", $fechaPHP);
		$nuevaFecha = explode ( "/", $fechaPHP );
		//invierto los campos
		$fechaMySql [0] = $nuevaFecha [2];
		$fechaMySql [1] = $nuevaFecha [1];
		$fechaMySql [2] = $nuevaFecha [0];
		$fechaMySql = implode ( "", $fechaMySql );
		return ($fechaMySql);
	}

	static function fechaMysqlaPHP($fechaMysql)
	{
		//20080618
		$arrayFecha [0] = substr ( $fechaMysql, - 2 );
		$arrayFecha [1] = substr ( $fechaMysql, 4, 2 );
		$arrayFecha [2] = substr ( $fechaMysql, 0, 4 );
		$fechaPHP = implode ( "/", $arrayFecha );
		return $fechaPHP;
	}

	static function redondear($valor)
	{
		$float_redondeado = round ( $valor * 100 ) / 100;
		return $float_redondeado;
	}	static function fechaHoraMysqlaPHP($fecha) {		//20080618		$fechaMysql = explode(" ", $fecha);						$arrayFecha [0] = substr ( $fechaMysql[0], 8, 2 );		$arrayFecha [1] = substr ( $fechaMysql[0], 5, 2 );		$arrayFecha [2] = substr ( $fechaMysql[0], 0, 4 );		$fechaPHP = implode ( "/", $arrayFecha );		return $fechaPHP.' '.$fechaMysql[1];	    }

	static function _log($str, $_Log) {
		$dt = date('Y-m-d H:i:s');
		fputs($_Log, $dt." --> ".$str."\n");
	}

	static function existObjectComparator($array, $i, $comparator){
		foreach ($array as $item){
			if ($comparator->equals($item,$i)) {
				return true;
			}
		}
		return false;
	}

	static function getObjectComparator($array, $i, $comparator){
		foreach ($array as $item){
			if ($comparator->equals($item,$i)) {
				return $item;
			}
		}
		return false;
	}

	static function getMesDeNumero($numero){
		$meses = array('01'=>'Enero',
					  '02'=>'Febrero',
					  '03'=>'Marzo',
					  '04'=>'Abril',
					  '05'=>'Mayo',
					  '06'=>'Junio',
					  '07'=>'Julio',
					  '08'=>'Agosto',
					  '09'=>'Septiembre',
					  '1'=>'Enero',
					  '2'=>'Febrero',
					  '3'=>'Marzo',
					  '4'=>'Abril',
					  '5'=>'Mayo',
					  '6'=>'Junio',
					  '7'=>'Julio',
					  '8'=>'Agosto',
					  '9'=>'Septiembre',
					  '10'=>'Octubre',
					  '11'=>'Noviembre',
					  '12'=>'Diciembre');
		return $meses[$numero];
	}		public static function Format_toDecimal( $pNum ){		if ( is_null($pNum) ) {			return( '0,00' );		}else{			return( trim( number_format($pNum, 2, ',', '.') ) );		}	}
}
?>