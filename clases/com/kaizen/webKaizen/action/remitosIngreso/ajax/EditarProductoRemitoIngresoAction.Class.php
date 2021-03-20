<?php
/**
 * Acción para editar de sesión un producto utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 29-01-2011
 *
 */
class EditarProductoRemitoIngresoAction extends SecureAjaxAction{

	private $errorProducto, $errorCantidad, $errorTipoProducto;

	/**
	 * se edita un producto y se muestra la nueva lista de productos.
	 */
	public function executeImpl(){

		$this->editarProducto();				
		
		return $this->getMostrarProductos();
	}
	
	public function editarProducto(){}
	
	public function getFuncion(){
		return "Alta Producto";
	}

	public function getMostrarProductos(){
		
		//parseamos el html con los productos.
		$xtpl = new XTemplate ( APP_PATH. 'remitosIngreso/nuevosproductos.html' );
		
		$count = count($_SESSION['productos_nuevos']);
		for($i=0;$i<$count;$i++) {
	    	$oProducto =   unserialize( $_SESSION['productos_nuevos'][$i] );

	    	//si no se ingresa una descripción del producto, se visualiza la misma que el tipo de producto.
	    	$ds_producto = $oProducto->getDs_producto();	   
	    	if(empty($ds_producto)) $ds_producto = $oProducto->getDs_tipoProducto();
	    	
	    	$xtpl->assign ( 'ds_producto', $ds_producto );
	    	$xtpl->assign ( 'ds_numero', $oProducto->getDs_numero() );
			$xtpl->assign ( 'ds_tipoProducto', htmlentities( $oProducto->getTipoProducto()->getDs_codigoSAP() . ' - ' . $oProducto->getDs_tipoProducto()) );
			$xtpl->assign ( 'ds_cantidad', htmlentities ( $oProducto->getDs_cantidad () ) );		
			$xtpl->assign ( 'indice', $i  );		
			
			$xtpl->parse ( 'main.option_producto' );	    	
		}

		//parsea los errores.
		if($this->tieneErrores()){
			$this->mostrarErrores($xtpl);		
			
		}
		/*
		$xtpl->assign ( 'errorProducto', $this->errorProducto );
		$xtpl->assign ( 'errorTipoProducto', $this->errorTipoProducto );
		$xtpl->assign ( 'errorCantidad', $this->errorCantidad );
		*/
		
		$xtpl->assign ( 'WEB_PATH', WEB_PATH );
		$xtpl->parse ( 'main' );
		$texto = $xtpl->text('main');			
		return $texto;		
	}	
	
	
	protected function setErrorProducto($value){
		$this->errorProducto = $value;
	}
	protected function setErrorTipoProducto($value){
		$this->errorTipoProducto = $value;
	}
	protected function setErrorCantidad($value){
		$this->errorCantidad = $value;
	}
	protected function tieneErrores(){
		return !empty($this->errorProducto) || !empty($this->errorTipoProducto) || !empty($this->errorCantidad);
	}
	protected function mostrarErrores(){
	}
}