<?php

/**
 * Acciï¿½n listar Pedidos.
 *
 * @author María Jesús
 * @since 5-09-2011
 *
 */
class PedidoManager implements IListar {

	/**
	 * se agrega un pedido nuevo.
	 * @param $oPedido a agregar.
	 */
	public function agregarPedido(Pedido $oPedido) {
		//persistir pedido en la bbdd.
		PedidoQuery::insertPedido( $oPedido );
	}

	/**
	 * se modifica un pedido.
	 * @param Pedido $oPedido a modificar.
	 */
	public function modificarPedido(Pedido $oPedido){
		//persistir los cambios del pedido en la bbdd.
		PedidoQuery::modificarPedido($oPedido);
	}


	/**
	 * eliminar un pedido.
	 * @param $cd_pedido identificador del pedido a eliminar
	 */
	public function eliminarPedido($cd_pedido){

		$oPedido = new Pedido ();
		$oPedido->setCd_pedido ( $cd_pedido );
		
		//persistir los cambios en la bbdd.
		PedidoQuery::eliminarPedido($oPedido );
	}

	/**
	 * se listan pedidos.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getPedidos(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());
		$pedidos = PedidoQuery::getPedidos($criterio);
		return $pedidos;
	}

	/**
	 * obtiene un pedido específico dado un identificador.
	 * @param $cd_pedido identificador del pedido a recuperar
	 * @return unknown_type
	 */
	public function getPedidoPorId($cd_pedido){
		if( !empty( $cd_pedido )){
			$criterio = new CriterioBusqueda();
			$criterio->addFiltro('P.cd_pedido', $cd_pedido, '=');
			$oPedido =  PedidoQuery::getPedido ( $criterio );
		}else{
			$oPedido = new Pedido();
		}
		return $oPedido;
	}

	/**
	 * obtiene la cantidad de pedidos dado un filtro.
	 * @param $filtro filtro de búsqueda.
	 * @return cantidad de pedidos
	 */
	public function getCantidadPedidos( CriterioBusqueda $criterio){
		$cant = PedidoQuery::getCantPedidos( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getPedidos( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadPedidos( $criterio );
	}
	
	public function getCantPedidosAPedir($criterio) {
		$tmp_criterio = clone $criterio;
		$tmp_criterio->addFiltro('P.cd_estado', 0, '=');
		$cant_pedidos_apedir = $this->getCantidadPedidos($tmp_criterio);
		return $cant_pedidos_apedir;
	}
	
	public function getCantPedidosPedidos($criterio) {
		$tmp_criterio = clone $criterio;
		$tmp_criterio->addFiltro('P.cd_estado', 1, '=');
		$cant_pedidos_pedidos = $this->getCantidadPedidos($tmp_criterio);
		return $cant_pedidos_pedidos;
	}
}