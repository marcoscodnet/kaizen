<?php

/**
 * Acción para modificar un pedidos.
 *
 * @author María Jesús
 * @since 9-9-2011
 *
 */
class ModificarPedidoAction extends EditarPedidoAction{
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
	 */
	protected function editar($oEntidad){
		$manager = new PedidoManager();
		$manager->modificarPedido($oEntidad);
	}

	protected function getForwardSuccess(){
		return 'modificar_pedido_success';
	}

	protected function getForwardError(){
		return 'modificar_pedido_error';
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Pedido";
	}

}