<?php

/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Manager para clientes.
 *
 */
class ClienteManager implements IListar{

	/**
	 * se agrega un cliente nuevo.
	 * @param $oCliente a agregar.
	 */
	public function agregarCliente(Cliente $oCliente){

		//persistir cliente en la bbdd.
		ClienteQuery::insertCliente( $oCliente );
			
	}

	/**
	 * se modifica un cliente.
	 * @param Cliente $oCliente a modificar.
	 */
	public function modificarCliente(Cliente $oCliente){

		//persistir los cambios del cliente en la bbdd.
		ClienteQuery::modificarCliente($oCliente);
			
	}


	/**
	 * eliminar un cliente.
	 * @param $cd_cliente identificador del cliente a eliminar
	 */
	public function eliminarCliente($cd_cliente){

		$oCliente = new Cliente ();
		$oCliente->setCd_cliente ( $cd_cliente );

		//TODO validaciones.

		//persistir los cambios en la bbdd.
		ClienteQuery::eliminarCliente($oCliente );

	}

	/**
	 * se listan clientes.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getClientes(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());
		$clientes = ClienteQuery::getClientes($criterio);
		return $clientes;
	}



	/**
	 * obtiene un cliente específico dado un identificador.
	 * @param $cd_cliente identificador del cliente a recuperar
	 * @return unknown_type
	 */
	public function getClientePorId($cd_cliente){
		if( !empty( $cd_cliente )){
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('C.cd_cliente', $cd_cliente, '=');
			$oCliente =  ClienteQuery::getCliente ( $criterio );
		}else{
			$oCliente = new Cliente();
		}
		return $oCliente;
	}

	public function getCliente($criterio){
		$oCliente =  ClienteQuery::getCliente ( $criterio );
		return $oCliente;
	}

	/**
	 * obtiene la cantidad de clientes dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de clientes
	 */
	public function getCantidadClientes( CriterioBusqueda $criterio){
		$cant =  ClienteQuery::getCantClientes( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getClientes( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadClientes( $criterio );
	}
}