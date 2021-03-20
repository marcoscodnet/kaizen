<?php

/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Manager para Productos.
 *
 */
class ProductoManager implements IListar{

	/**
	 * se agrega un producto nuevo.
	 * @param $oProducto a agregar.
	 */
	public function agregarProducto(Producto $oProducto){
		//persistir producto en la bbdd.
		ProductoQuery::insertProducto( $oProducto );
			
	}

	/**
	 * se modifica un producto.
	 * @param Producto $oProducto a modificar.
	 */
	public function modificarProducto(Producto $oProducto){
		//persistir los cambios del producto en la bbdd.
		ProductoQuery::modificarProducto($oProducto);
			
	}


	/**
	 * eliminar un producto.
	 * @param $cd_producto identificador del producto a eliminar
	 */
	public function eliminarProducto($cd_producto){

		$oProducto = new Producto ();
		$oProducto->setCd_producto ( $cd_producto );

		//TODO validaciones.

		//persistir los cambios en la bbdd.
		ProductoQuery::eliminarProducto($oProducto );

	}		

	/**
	 * se listan productos.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getProductos(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());
		$productos = ProductoQuery::getProductos($criterio);
		return $productos;
	}

	public function getProductoEnSucursal($cd_sucursal){
		if( !empty( $cd_sucursal )){
			$oProducto =  ProductoQuery::getProductoEnSucursal ( $cd_sucursal );
		}else{
			$oProducto = new Producto();
		}
		return $oProducto;
	}

	/**
	 * obtiene un producto específico dado un identificador.
	 * @param $cd_producto identificador del producto a recuperar
	 * @return unknown_type
	 */
	public function getProductoPorId($cd_producto){
		if( !empty( $cd_producto )){
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('P.cd_producto', $cd_producto, '=');
			$oProducto =  ProductoQuery::getProducto ( $criterio );
		}else{
			$oProducto = new Producto();
		}
		return $oProducto;
	}

	/**
	 * obtiene la cantidad de productos dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de productos
	 */
	public function getCantidadProductos( CriterioBusqueda $criterio){
		$cant = ProductoQuery::getCantProductos( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getProductos( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadProductos( $criterio );
	}
}