<?php

/**
 * Acción para inicializar el contexto para modificar
 * un pedido.
 *
 * @author María Jesús
 * @since 09-09-2011
 *
 */
class ModificarPedidoInitAction extends EditarPedidoInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Modificar Pedido";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Pedido";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_pedido";
	}

	protected function getEntidad(){
		$oPedido = null;
		if (isset ( $_GET ['id'] )) {
			$cd_pedido = $_GET ['id'];
			$manager = new PedidoManager();
			$oPedido = $manager->getPedidoPorId( $cd_pedido );
		}
		return $oPedido;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}
}