<?php
header("Content-type: text/javascript; charset=iso-8859-1");
/**
 * Acción para inicializar el contexto para modificar
 * un cliente.
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 */
class ModificarClienteMinInitAction extends EditarClienteInitAction{


	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
	 */
	public function getFuncion(){
		return "Alta Venta";
	}

	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/clientes/editarcliente_min.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()
	 */
	protected function getTitulo(){
		return "Modificar Cliente";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()
	 */
	protected function getAccionSubmit(){
		return "modificar_cliente";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/almacenes/EditarAlmacenInitAction#getEntidad()
	 */
	protected function getEntidad(){
		$oCliente = null;
		if (isset ( $_GET ['id'] )) {
			//recuperamos la obra dado su identifidor.
			$cd_cliente = $_GET ['id'];

			$manager = new ClienteManager();
			$oCliente = $manager->getClientePorId( $cd_cliente );
		}

		return $oCliente;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()
	 */
	protected function getMostrarCodigo(){
		return true;
	}

	protected function getSecureLayout() {
		$oClass = new ReflectionClass(DEFAULT_POPUP_LAYOUT);
		$oLayout = $oClass->newInstance();

		return $oLayout;
	}
}