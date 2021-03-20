<?php 

/**
 * Acción para editar un color.
 * 
 * @author Lucrecia
 * @since 22-04-2010
 * 
 */
abstract class EditarColorAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oColor = new Color();

		if (isset ( $_POST ['cd_color'] ))
			$oColor->setCd_color (  $_POST ['cd_color']  );
		
		if (isset ( $_POST ['ds_color'] ))
			$oColor->setDs_color (  $_POST ['ds_color']  );
				
		return $oColor;
	}
}