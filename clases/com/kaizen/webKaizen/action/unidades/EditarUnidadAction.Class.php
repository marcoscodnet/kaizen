<?php

/**
 * Acción para editar una unidad.
 *
 * @author Lucrecia
 * @since 22-04-2010
 *
 */
abstract class EditarUnidadAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		$oUnidad = new Unidad();

		if (isset ( $_POST ['cd_unidad'] ))
		$oUnidad->setCd_unidad (  $_POST ['cd_unidad']  );
			
		if (isset ( $_POST ['cd_producto'] ))
		$oUnidad->setCd_producto($_POST ['cd_producto']  );

		if (isset ( $_POST ['nu_motor'] ))
		$oUnidad->setNu_motor( $_POST ['nu_motor'] );
			
		if (isset ( $_POST ['nu_cuadro'] ))
		$oUnidad->setNu_cuadro(  $_POST ['nu_cuadro'] ) ;

		if (isset ( $_POST ['dt_ingreso'] ))
		$oUnidad->setDt_ingreso(str_replace("/", "-",$_POST ['dt_ingreso'])) ;
		

		if (isset ( $_POST ['nu_patente'] ))
		$oUnidad->setNu_patente ( $_POST ['nu_patente'] ) ;

		if (isset ( $_POST ['nu_remitoingreso'] ))
		$oUnidad->setNu_remitoingreso($_POST ['nu_remitoingreso']) ;

		if (isset ( $_POST ['nu_aniomodelo'] ))
		$oUnidad->setNu_aniomodelo($_POST ['nu_aniomodelo'] ) ;

		if (isset ( $_POST ['cd_sucursal_actual'] ))
		$oUnidad->setCd_sucursalactual($_POST ['cd_sucursal_actual'] ) ;

		if (isset ( $_POST ['ds_observacion'] ))
		$oUnidad->setDs_observacion( $_POST ['ds_observacion'] ) ;

		if (isset ( $_POST ['nu_envio'] ))
		$oUnidad->setNu_envio( $_POST ['nu_envio'] ) ;

		return $oUnidad;
	}
}