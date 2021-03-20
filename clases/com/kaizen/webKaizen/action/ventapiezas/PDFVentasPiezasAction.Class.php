<?php



/**

 * Acci�n para exportar a pdf una colecci�n de movimientos.

 *

 * @author Lucrecia

 * @since 03-01-2011

 *

 */

class PDFVentasPiezasAction extends ExportPDFCollectionAction{



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getIListar()

	 */

	protected function getIListar(){

		return new VentaPiezaManager();

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getTableModel($items)

	 */

	protected function getTableModel(ItemCollection $items){

		return new VentaPiezaTableModel($items);

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()

	 */

	protected function getCampoOrdenDefault(){

		return 'dt_ventapieza';

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/SecureAction#getFuncion()

	 */

	public function getFuncion(){

		return "Listar Venta Pieza";

	}



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/pdf/ExportPDFCollectionAction#getOrientacion()

	 */

	protected function getOrientacion(){

		return "L";

	}


protected function getCriterioBusqueda(){

		//recuperamos los par�metros.

		$filtro = FormatUtils::getParam('filtro');

		$campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault() );


		 $cd_cliente = FormatUtils::getParam('cd_cliente');

        $cd_usuario = FormatUtils::getParam('cd_usuario');



        $dt_desde = FormatUtils::getParam('dt_desde');

        $dt_hasta = FormatUtils::getParam('dt_hasta');



		$orden = FormatUtils::getParam('orden','DESC');

		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );





		$criterio = new CriterioBusqueda();

		 if ($cd_usuario != "") {

            $criterio->addFiltro('VP.cd_usuario', $cd_usuario, "=");

        }





        if ($dt_desde != "") {

            $dt_desde = str_replace("/", "-", $dt_desde);

            $dt_desde = implode("/", array_reverse(explode("-", $dt_desde)));

            $criterio->addFiltro('VP.dt_ventapieza', "'$dt_desde'", ">=");

        }

        if ($dt_hasta != "") {

            $dt_hasta = str_replace("/", "-", $dt_hasta);

            $dt_hasta = implode("/", array_reverse(explode("-", $dt_hasta)));

            $criterio->addFiltro('VP.dt_ventapieza', "'$dt_hasta'", "<=");

        }



		//$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);



		$criterio->addOrden($campoOrden, $orden);
    $criterio->addGroupBy('VP.cd_ventapieza,S.ds_nombre,S.ds_domicilio,S.ds_telefono,S.ds_email,S.ds_comentario,S.cd_localidad');


		return $criterio;



	}
}
