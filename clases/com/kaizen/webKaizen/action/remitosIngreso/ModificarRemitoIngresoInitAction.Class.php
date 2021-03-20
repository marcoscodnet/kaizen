<?php 

/**
 * Acción para inicializar el contexto para modificar
 * un remito de ingreso de productos.
 * 
 * @author Lucrecia
 * @since 28-04-2010
 * 
 */
class ModificarRemitoIngresoInitAction extends EditarRemitoIngresoInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		//vemos si alguno de los elementos del remito fue dado a obra.
		$manager = new RemitoIngresoManager();
		if( $manager->seEntregaronProductos( $this->oEntidad ) ){
			$xtpl = new XTemplate ( APP_PATH. '/remitosIngreso/editarremitoingreso_restringido.html' );
		}
			else $xtpl = parent::getXTemplate();
		return $xtpl;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/remitosIngreso/EditarRemitoIngresoInitAction#getEntidad()
	 */
	protected function getEntidad(){
		//recuperar el remito junto con sus productos.
		$cd_remito = $_GET ['id'];
		$manager = new RemitoIngresoManager();
		$oRemito = $manager->getRemitoIngresoPorId ( $cd_remito );
		return $oRemito;
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar RemitoIngreso";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	public function getTitulo(){
		return "Modificar Remito de Ingreso";
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_remitoIngreso";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
	
}