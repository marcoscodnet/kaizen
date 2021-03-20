<?php

/**
 * Acción para editar un color.
 *
 * @author Lucrecia
 * @since 22-04-2010
 *
 */
abstract class EditarBoletoAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oParametro = new Parametro();

		if (isset ( $_POST ['cd_parametro'] ))
		$oParametro->setCd_parametro (  $_POST ['cd_parametro']  );

		if (isset ( $_POST ['ds_nombre'] ))
		$oParametro->setDs_nombre (  $_POST ['ds_nombre']  );

		if (isset ( $_POST ['ds_contenido'] ))
		$oParametro->setDs_contenido (  $_POST ['ds_contenido']  );

		return $oParametro;
	}
}