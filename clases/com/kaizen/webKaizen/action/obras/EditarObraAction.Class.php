<?php 

/**
 * Acción para editar una obra.
 * 
 * @author Lucrecia
 * @since 31-01-2011
 * 
 */
abstract class EditarObraAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oObra = new Obra();
		
		if (isset ( $_POST ['cd_obra'] ))
			$oObra->setCd_obra ( ( $_POST ['cd_obra'] ) );
		
		if (isset ( $_POST ['distrito'] ))
			$oObra->setCd_distrito ( $_POST ['distrito'] ) ;
		
		if (isset ( $_POST ['central'] ))
			$oObra->setCd_central  ( $_POST ['central'] )  ;
		
		if (isset ( $_POST ['motivo'] ))
			$oObra->setCd_motivo (  $_POST ['motivo'] ) ;

		if (isset ( $_POST ['tipoObra'] ))
			$oObra->setCd_tipoObra (  $_POST ['tipoObra'] ) ;
		
		if (isset ( $_POST ['subtipoObra'] ))
			$oObra->setCd_subtipoObra (  $_POST ['subtipoObra'] ) ;
		
		if (isset ( $_POST ['ds_domicilio'] ))
			$oObra->setDs_domicilio  ( $_POST ['ds_domicilio'] );
		
		if (isset ( $_POST ['ds_titulo'] ))
			$oObra->setDs_titulo ( $_POST ['ds_titulo'] );
		
		if (isset ( $_POST ['nu_siniestro'] ))
			$oObra->setNu_siniestro ( $_POST ['nu_siniestro'] );
		
		if (isset ( $_POST ['nu_tipoObra'] ))
			$oObra->setNu_tipoObra ( $_POST ['nu_tipoObra'] );
		
		if (isset ( $_POST ['nu_subtipoObra'] ))
			$oObra->setNu_subtipoObra ( $_POST ['nu_subtipoObra'] );
		
		if (isset ( $_POST ['dt_fecha'] ))
			$oObra->setDt_fecha ( FuncionesComunes::fechaPHPaMysql ( $_POST ['dt_fecha'] ) );
		
		return $oObra;
	}
	
	public function getIdEntidad(){
		return $_POST['cd_obra'];
	}
	
}