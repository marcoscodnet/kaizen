<?php
/**
 * Acción para editar de sesión un producto consumido utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 26-01-2011
 *
 */
class EditarProductoConsumidoAction extends SecureAjaxAction{

	private $errorCantidad, $errorTipoProducto;

	/**
	 * se edita un producto y se muestra la nueva lista de productos.
	 */
	public function executeImpl(){

		$this->editarProductoConsumido();				
		
		return $this->getMostrarProductosConsumidos();
	}
	
	public function editarProductoConsumido(){}
	
	public function getFuncion(){
		return "Alta ConsumoEstimado";
	}

	public function getMostrarProductosConsumidos(){
		
		//parseamos el html con los productos.
		$xtpl = new XTemplate ( APP_PATH. 'consumosEstimados/consumos.html' );
		
		$count = count($_SESSION['consumos']);
		for($i=0;$i<$count;$i++) {
	    	$oProductoConsumido =   unserialize( $_SESSION['consumos'][$i] );

	    	$xtpl->assign ( 'ds_tipoProducto', htmlentities( $oProductoConsumido->getTipoProducto()->getDs_codigoSAP() . ' - ' . $oProductoConsumido->getDs_tipoProducto()) );
			$xtpl->assign ( 'ds_cantidad', htmlentities ( $oProductoConsumido->getDs_cantidad () ) );		
			$xtpl->assign ( 'indice', $i  );		
			
			$xtpl->parse ( 'main.option_consumo' );	    	
		}

		//parsea los errores.
		if($this->tieneErrores()){
			$this->mostrarErrores($xtpl);		
			
		}
		
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
		$xtpl->parse ( 'main' );
		$texto = $xtpl->text('main');			
		return $texto;		
	}	
	
	
	protected function setErrorTipoProducto($value){
		$this->errorTipoProducto = $value;
	}
	protected function setErrorCantidad($value){
		$this->errorCantidad = $value;
	}
	protected function tieneErrores(){
		return !empty($this->errorTipoProducto) || !empty($this->errorCantidad);
	}
	protected function mostrarErrores(){
	}
}