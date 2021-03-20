<?php

/**
 *
 * @author Ma. Jesús
 * @since 21-07-2011
 *
 * Manager para Proveedores.
 *
 */
class ProveedorManager implements IListar{

	/**
	 * se agrega un proveedor nuevo.
	 * @param $oProveedor a agregar.
	 */
	public function agregarProveedor(Proveedor $oProveedor){
		//persistir proveedor en la bbdd.
		ProveedorQuery::insertProveedor( $oProveedor );
			
	}

	/**
	 * se modifica un proveedor.
	 * @param Proveedor $oProveedor a modificar.
	 */
	public function modificarProveedor(Proveedor $oProveedor){
		//persistir los cambios del producto en la bbdd.
		ProveedorQuery::modificarProveedor($oProveedor);
			
	}


	/**
	 * eliminar un proveedor.
	 * @param $cd_proveedor identificador del proveedor a eliminar
	 */
	public function eliminarProveedor($cd_proveedor){

		$oProveedor = new Proveedor ();
		$oProveedor->setCd_proveedor ( $cd_proveedor );

		//TODO validaciones.

		//persistir los cambios en la bbdd.
		ProveedorQuery::eliminarProveedor($oProveedor );

	}

	/**
	 * se listan proveedores.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getProveedores(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());
		$proveedores = ProveedorQuery::getProveedores($criterio);
		return $proveedores;
	}

	/**
	 * obtiene un proveedor específico dado un identificador.
	 * @param $cd_proveedor identificador del proveedor a recuperar
	 * @return unknown_type
	 */
	public function getProveedorPorId($cd_proveedor){
		if( !empty( $cd_proveedor )){
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('P.cd_proveedor', $cd_proveedor, '=');
			$oProveedor =  ProveedorQuery::getProveedor ( $criterio );
		}else{
			$oProveedor = new Proveedor();
		}
		return $oProveedor;
	}

	/**
	 * obtiene la cantidad de proveedores dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de proveedores
	 */
	public function getCantidadProveedores( CriterioBusqueda $criterio){
		$cant = ProveedorQuery::getCantProveedores( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getProveedores( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadProveedores( $criterio );
	}
}