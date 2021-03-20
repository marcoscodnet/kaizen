<?php 

/**
 * Acción para editar un ipo de unidad.
 * 
 * @author Lucrecia
 * @since 22-04-2010
 * 
 */
abstract class EditarTipounidadAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oTipounidad = new Tipounidad();

		if (isset ( $_POST ['cd_tipounidad'] ))
			$oTipounidad->setCd_tipounidad (  $_POST ['cd_tipounidad']  );
		
		if (isset ( $_POST ['ds_tipounidad'] ))
			$oTipounidad->setDs_tipounidad (  $_POST ['ds_tipounidad']  );
				
		return $oTipounidad;
	}
}