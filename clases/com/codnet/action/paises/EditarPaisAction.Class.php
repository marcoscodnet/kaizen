<?php 

/**
 * Acción para editar un pais.
 * 
 * @author bernardo
 * @since 22-04-2010
 * 
 */
abstract class EditarPaisAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oPais = new Pais();

		if (isset ( $_POST ['cd_pais'] ))
			$oPais->setCd_pais (  $_POST ['cd_pais']  );
		
		if (isset ( $_POST ['ds_pais'] ))
			$oPais->setDs_pais (  $_POST ['ds_pais']  );
				
		return $oPais;
	}
}