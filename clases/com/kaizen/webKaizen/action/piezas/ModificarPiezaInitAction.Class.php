<?php



/**

 * Acci�n para inicializar el contexto para modificar

 * una pieza.

 *

 * @author Ma. Jes�s

 * @since 18-06-2011

 *

 */

class ModificarPiezaInitAction extends EditarPiezaInitAction{





	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()

	 */

	public function getFuncion(){

		return "Modificar Pieza";

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureOutputAction#getTitulo()

	 */

	protected function getTitulo(){

		return "Modificar Pieza";

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarInitAction#getAccionSubmit()

	 */

	protected function getAccionSubmit(){

		return "modificar_pieza";

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/kaizen/webKaizen/action/almacenes/EditarAlmacenInitAction#getEntidad()

	 */

	protected function getEntidad(){

		$oPieza = null;

		if (isset ( $_GET ['id'] )) {

			//recuperamos la obra dado su identifidor.

			$cd_pieza = $_GET ['id'];



			$manager = new PiezaManager();

			$oPieza = $manager->getPiezaPorId($cd_pieza);

		}

		return $oPieza;

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarInitAction#getMostrarCodigo()

	 */

	protected function getMostrarCodigo(){

		return true;

	}

}