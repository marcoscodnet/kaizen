<?php

/**
 * Acción para editar una pieza.
 *
 * @author Ma. Jesús
 * @since 18-06-2011
 *
 */
abstract class EditarPiezaAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oPieza = new Pieza();

		if (isset ( $_POST ['cd_pieza'] ))
		$oPieza->setCd_pieza (  $_POST ['cd_pieza']  );
			
		if (isset ( $_POST ['ds_codigo'] ))
		$oPieza->setDs_codigo($_POST ['ds_codigo']  );

		if (isset ( $_POST ['ds_descripcion'] ))
		$oPieza->setDs_descripcion( $_POST ['ds_descripcion'] );
			
		if (isset ( $_POST ['nu_stock_minimo'] ))
		$oPieza->setNu_stock_minimo (  $_POST ['nu_stock_minimo'] ) ;

		if (isset ( $_POST ['qt_costo'] ))
		$oPieza->setQt_costo($_POST ['qt_costo'] ) ;

		if (isset ( $_POST ['qt_minimo'] ))
		$oPieza->setQt_minimo ( $_POST ['qt_minimo'] ) ;

		if (isset ( $_POST ['ds_observacion'] ))
		$oPieza->setDs_observacion( $_POST ['ds_observacion'] ) ;

		if (isset ( $_POST ['nu_stock_actual'] ))
		$oPieza->setNu_stock_actual( $_POST ['nu_stock_actual'] ) ;

		return $oPieza;
	}
}