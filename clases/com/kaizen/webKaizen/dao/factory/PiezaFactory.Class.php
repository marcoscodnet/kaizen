<?php
/**
 *
 * @author Ma. Jesús
 * @since 18-06-2011
 *
 * Factory para pieza.
 *
 */
class PiezaFactory implements ObjectFactory{

	/**
	 * construye una pieza.
	 * @param $next
	 * @return pieza
	 */
	public function build($next){
		$oPieza = new Pieza();
		
		$oPieza->setCd_pieza($next ['cd_pieza']);
		$oPieza->setDs_codigo($next ['ds_codigo']);
		$oPieza->setDs_descripcion($next ['ds_descripcion']);
		$oPieza->setNu_stock_minimo($next ['nu_stock_minimo']);
		
		if($next ['nu_stock_actual'] == NULL){
			$stock_actual = 0;
		}else{
			$stock_actual = $next ['nu_stock_actual'];
		}

		$oPieza->setNu_stock_actual($stock_actual);
		$oPieza->setQt_costo($next ['qt_costo']);
		$oPieza->setQt_minimo($next ['qt_minimo']);
		$oPieza->setDs_observacion($next ['ds_observacion']);
		$oPieza->setNu_cantidadpedida($next ['nu_cantidadpedida']);
		$oPieza->setQt_montoacobrar($next ['qt_montoacobrar']);
		
 		return $oPieza;
	}
}
?>