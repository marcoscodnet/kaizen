<?php 

/**
 * Acción para inicializar el contexto para editar
 * un remito de ingreso de productos.
 * 
 * @author Lucrecia
 * @since 29-01-2011
 * 
 */
abstract class EditarRemitoIngresoInitAction extends EditarInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/remitosIngreso/editarremitoingreso.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new RemitoIngreso();
	}
		
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oRemito = FormatUtils::ifEmpty($entidad, new RemitoIngreso());
		//se muestra el remito.
		$this->parseRemito( $oRemito, $xtpl);
		
		//recupera y parsea proveedores.
		$this->parseProveedores($oRemito->getCd_proveedor() , $xtpl);
		$this->parseTipos($oRemito->getCd_tipo() , $xtpl);
		
		//inicializamos los productos
		unset ( $_SESSION ['productos_nuevos'] );
		$this->parseProductos( $oRemito->getProductos() , $xtpl );
	}	
	
	
	protected function parseRemito(Remito $oRemito, XTemplate $xtpl){
		$xtpl->assign ( 'cd_remito', $oRemito->getCd_remito());
		
		$xtpl->assign ( 'ds_observaciones',  $oRemito->getDs_observaciones ()  );
		$xtpl->assign ( 'nu_numero',  FormatUtils::ifEmpty( $oRemito->getNu_numero () , '' ) );

		if(FormatUtils::isEmpty( $oRemito->getDt_fecha() ) )
			//seteamos la fecha actual.
			$xtpl->assign('dt_fecha', FuncionesComunes::fechaMysqlaPHP( date("Ymd") ) );
		else
			$xtpl->assign ( 'dt_fecha',   FuncionesComunes::fechaMysqlaPHP( $oRemito->getDt_fecha() )  );
				
	}
	
	protected function parseProductos(ItemCollection $productos, XTemplate $xtpl){
		//mostramos los productos del remito y los vamos dejando en sesión para ser editados con ajax.
		$i=0;
		foreach($productos as $key => $oProducto) {
	    	$xtpl->assign ( 'ds_producto', $oProducto->getDs_producto() );
	    	$xtpl->assign ( 'ds_numero', $oProducto->getDs_numero() );
			$xtpl->assign ( 'ds_tipoProducto',  $oProducto->getTipoProducto()->getDs_codigoSAP() . ' - ' . $oProducto->getDs_tipoProducto()) ;
			$xtpl->assign ( 'ds_cantidad',  $oProducto->getDs_cantidad () ) ;		
			$xtpl->assign ( 'indice',  $i  );
			$xtpl->parse ( 'main.option_producto' );
			$_SESSION['productos_nuevos'][] = serialize( $oProducto );
			$i++;
		}
	}	
		
	protected function parseTipos($cd_selected='', XTemplate $xtpl){
		//recupera y parsea distritos.
		$manager = new TipoRemitoIngresoManager();
		$tipos = $manager->getReferencias();		
		foreach($tipos as $key => $tipo) {
			$xtpl->assign ( 'ds_tipo', $tipo->getDs_referencia() );
			$xtpl->assign ( 'cd_tipo', FormatUtils::selected($tipo->getCd_referencia(), $cd_selected) );
			$xtpl->parse ( 'main.option_tipo' );
		}
			
	}
	
	protected function parseProveedores($cd_selected='', XTemplate $xtpl){
		//recupera y parsea distritos.
		$proveedoresManager = new ProveedorManager();
		$proveedores = $proveedoresManager->getProveedores();
		foreach($proveedores as $key => $proveedor) {
			$xtpl->assign ( 'ds_proveedor', $proveedor->getDs_razonSocial() . ' (' .$proveedor->getDs_cuit() .')' );
			$xtpl->assign ( 'cd_proveedor', FormatUtils::selected($proveedor->getCd_proveedor(), $cd_selected)  );				
			$xtpl->parse ( 'main.option_proveedor' );
		}
	
			
	}
	
	
}