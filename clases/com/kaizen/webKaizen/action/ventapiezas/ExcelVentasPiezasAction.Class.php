<?php



/**

 * Acci�n para exportar a excel una colecci�n de unidades.

 *

 * @author Lucrecia

 * @since 03-01-2011

 *

 */

class ExcelVentasPiezasAction extends ExportExcelCollectionAction{





	protected function getIListar(){

		return new VentaPiezaManager();

	}



	protected function getTableModel(ItemCollection $items){

		return new VentaPiezaTableModel($items);

	}



	protected function getCampoOrdenDefault(){

		return 'dt_ventapieza';

	}



	public function getFuncion(){

		return "Listar Venta Pieza";

	}



	protected function getTitulo(){

		return "Listado de Ventas de Piezas";

	}



	protected function getNombreArchivo(){

		return "ventaspiezas";

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
