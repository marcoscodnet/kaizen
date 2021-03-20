<?php 

/**
 * 
 * @author Lucrecia
 * @since 23-01-2011
 * 
 * Manager para remitos de ingreso de materiales.
 *
 */
class RemitoIngresoManager implements IListar{

	/**
	 * se agrega un remito de ingreso nuevo.
	 * @param $oRemito remito a agregar.
	 */
	public function agregarRemitoIngreso(RemitoIngreso $oRemito){

		//el remito debe tener: fecha / proveedor / algún producto.
		
		$error = FormatUtils::isEmpty( $oRemito->getDt_fecha() ) ;
		$error = $error || FormatUtils::isEmpty( $oRemito->getCd_proveedor() ) ;
		$error = $error || ( $oRemito->getProductos()->size()==0) ;
		
		if($error)
			throw new GenericException('Ingrese todos los campos requeridos',0); 
			
		
		//validar que no se repita el Nro de remito para un mismo tipo de comprobante.
		if(!FormatUtils::isEmpty($oRemito->getNu_numero())){
			$criterio = new CriterioBusqueda(); 
			$criterio->addFiltro('RI.nu_numero', $oRemito->getNu_numero(), '=');
			$criterio->addFiltro('TRI.cd_tiporemitoingreso', $oRemito->getCd_tipo(), '=');
			$oRemitoRepetido =  RemitoIngresoQuery::getRemitoIngreso( $criterio );

			if( !FormatUtils::isEmpty( $oRemitoRepetido->getCd_remito() ) ){
				$exception = new RemitoRepetidoException("Ya existe un remito con el  Tipo y Nº de comprobante ingresado: <br />" . $oRemitoRepetido->getDs_tipo()  . " - Nº " . $oRemitoRepetido->getNu_numero() );
				throw $exception;
			}

		}
		
			
		//persistir el remito en la bbdd.
		$oRemito = RemitoIngresoQuery::insertRemitoIngreso( $oRemito );
		
		//persistir los productos y asignarlos al remito.
		foreach ($oRemito->getProductos() as $key => $oProducto){
			
			$oProducto = ProductoQuery::insertProducto($oProducto);
			
			RemitoIngresoQuery::insertProductoEnRemito($oProducto, $oRemito);
		}
		
	}
	
	/**
	 * se modifica un remitoIngreso.
	 * @param $oRemito remito de ingreso a modificar.
	 */
	public function modificarRemitoIngreso(RemitoIngreso $oRemito){

		
		//validar que no se repita el Nro de remito
		if(!FormatUtils::isEmpty($oRemito->getNu_numero())){
			$criterio = new CriterioBusqueda(); 
			$criterio->addFiltro('RI.nu_numero', $oRemito->getNu_numero(), '=');
			$criterio->addFiltro('TRI.cd_tiporemitoingreso', $oRemito->getCd_tipo(), '=', new FormatValorString());
			$criterio->addFiltro('RI.cd_remito', $oRemito->getCd_remito(), '<>');
			$oRemitoRepetido =  RemitoIngresoQuery::getRemitoIngreso( $criterio );

			if( !FormatUtils::isEmpty( $oRemitoRepetido->getCd_remito() ) ){
				$exception = new RemitoRepetidoException("Ya existe un remito con el  Tipo y Nº de comprobante ingresado: <br />" . $oRemitoRepetido->getDs_tipo()  . " - Nº " . $oRemitoRepetido->getNu_numero() );
				throw $exception;
			}

		}
		
		//persistir los cambios del remito en la bbdd.
		RemitoIngresoQuery::modificarRemitoIngreso($oRemito);

		//buscamos los productos del remito.
		$productos = RemitoIngresoQuery::getProductosDeRemito( $oRemito );
		//se elimina la asocación productos-remito.
		RemitoIngresoQuery::eliminarProductosDeRemito($oRemito );
		//eliminamos los productos.
		foreach($productos as $key => $oProducto){
			ProductoQuery::eliminarProducto($oProducto);
		}
				
		//asignamos los nuevos productos al remito.
		foreach ($oRemito->getProductos() as $key => $oProducto){
			$oProducto = ProductoQuery::insertProducto($oProducto);
			RemitoIngresoQuery::insertProductoEnRemito($oProducto, $oRemito);
		}
	}
	
	
	/**
	 * eliminar un remitoIngreso.
	 * @param $cd_remito identificador del remito de ingreso a eliminar
	 */
	public function eliminarRemitoIngreso($cd_remito){

		$oRemito = new RemitoIngreso ();
		$oRemito = $this->getRemitoIngresoPorId ( $cd_remito );
		
		//TODO validaciones.
		
		//se elimina la asocación productos-remito.
		RemitoIngresoQuery::eliminarProductosDeRemito($oRemito );
		
		//se eliminan los productos.
		foreach($oRemito->getProductos() as $key => $oProducto){
			ProductoQuery::eliminarProducto($oProducto);
		}
		
		//se elimina el remito.
		RemitoIngresoQuery::eliminarRemitoIngreso($oRemito );
		
	}

	/**
	 * se listan remitos de ingreso
	 * @param $campoFiltro
	 * @return unknown_type
	 */
	public function getRemitosIngreso(CriterioBusqueda $criterio=null){
				
		$remitos = RemitoIngresoQuery::getRemitosIngreso($criterio);
				
		return $remitos;
	}
		
	/**
	 * obtiene un remitoIngreso especï¿½fico dado un identificador.
	 * @param $cd_grupo identificador del remitoIngreso a recuperar 
	 * @return unknown_type
	 */
	public function getRemitoIngresoPorId($cd_remito){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('RI.cd_remito', $cd_remito, '=');
		$oRemito =  RemitoIngresoQuery::getRemitoIngreso( $criterio );
		$oRemito->setProductos( RemitoIngresoQuery::getProductosDeRemito( $oRemito  ) );
		return $oRemito;
	}
	
	/**
	 * obtiene la cantidad de remitos de ingreso dado un filtro.
	 * @param $criterio criterio de bï¿½squeda. 
	 * @return cantidad de remitos de ingreso
	 */
	public function getCantidadRemitosIngreso(CriterioBusqueda $criterio){
		$cant =  RemitoIngresoQuery::getCantRemitosIngreso( $criterio );
		return $cant;
	}

	/**
	 * true si alguno de los productos del remito fue entregado a obra.
	 * @param RemitoIngreso $oRemito
	 */
	public function seEntregaronProductos( RemitoIngreso $oRemito ){
		
		$manager = new RemitoIngresoObraManager();
		return $manager->seEntregaronProductos( $oRemito->getProductos() );
		
	}
	
	/**
	 * se modifica un remitoIngreso de manera restringida, sólo comprobante y observaciones.
	 * @param $oRemito remito de ingreso a modificar.
	 */
	public function modificarRemitoIngresoRestringido(RemitoIngreso $oRemito){

		
		//validar que no se repita el Nro de remito
		if(!FormatUtils::isEmpty($oRemito->getNu_numero())){
			$criterio = new CriterioBusqueda(); 
			$criterio->addFiltro('RI.nu_numero', $oRemito->getNu_numero(), '=');
			$criterio->addFiltro('TRI.cd_tiporemitoingreso', $oRemito->getCd_tipo(), '=', new FormatValorString());
			$criterio->addFiltro('RI.cd_remito', $oRemito->getCd_remito(), '<>');
			$oRemitoRepetido =  RemitoIngresoQuery::getRemitoIngreso( $criterio );

			if( !FormatUtils::isEmpty( $oRemitoRepetido->getCd_remito() ) ){
				$exception = new RemitoRepetidoException("Ya existe un remito con el  Tipo y Nº de comprobante ingresado: <br />" . $oRemitoRepetido->getDs_tipo()  . " - Nº " . $oRemitoRepetido->getNu_numero() );
				throw $exception;
			}

		}
		
		//persistir los cambios del remito en la bbdd.
		RemitoIngresoQuery::modificarRemitoIngresoRestringido( $oRemito );

	}
		
	
	
	//INTERFACE IListar.
	
	function getEntidades ( CriterioBusqueda $criterio){
		
		return  $this->getRemitosIngreso( $criterio);
	}
	
	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadRemitosIngreso( $criterio);
	}
	
}