<?php

/**
 *
 * @author Mar�a Jes�s
 * @since 11-11-2011
 *
 * Table model para venta de piezas.
 *
 */
class VentaPiezaTableModel extends ListarTableModel {

	private $columnNames = array('Fecha','Cliente', 'N� pedido', 'Destino', 'Monto','Sucursal','Vendedor', 'Piezas');
	private $columnWidths = array(15,45,20,25,25,15,45,45);

	public function VentaPiezaTableModel(ItemCollection $items) {
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle() {
		return "Ventas de Piezas";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount() {
		return 8;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnName($columnIndex)
	 */
	function getColumnName($columnIndex) {
		return $this->columnNames[$columnIndex];
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnWidth($columnIndex)
	 */
	function getColumnWidth($columnIndex) {
		return $this->columnWidths[$columnIndex];
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getRowCount()
	 */
	function getRowCount() {
		$this->items->size();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getValueAt($rowIndex, $columnIndex)
	 */
	function getValueAt($rowIndex, $columnIndex) {
		$oVentaPieza = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oVentaPieza, $columnIndex);
	}

	public function getValue($anObject, $columnIndex) {
		$oVentaPieza = $anObject;
		$value = 0;
		switch ($columnIndex) {
			case 0: $value = $oVentaPieza->getDt_ventapieza();
			break;
			case 1: $value = $oVentaPieza->getDs_apynomCliente();
			break;
			case 2: $value = $oVentaPieza->getNu_pedidoreparacion();
			break;
			case 3: $value = $oVentaPieza->getDs_Destino();
			break;
			case 4: $value = '$ '.FuncionesComunes::Format_toDecimal($oVentaPieza->getNu_precioCobrado());
			break;
            case 5: $value = $oVentaPieza->getSucursal()->getDs_nombre();
			break;
			case 6: $value = $oVentaPieza->getUsuario()->getDs_apynom();
			break;
			case 7: $value = $oVentaPieza->getDs_piezas();
			break;
			default: $value = '';
			break;
		}
		return $value;
	}

	public function getEncabezados() {
		$encabezados[] = $this->buildTh($this->getColumnName(0), 'dt_ventapieza', 'Fecha Venta');
		$encabezados[] = $this->buildTh($this->getColumnName(1), 'ds_apynomcliente', 'Apellido y nombre del cliente');
		$encabezados[] = $this->buildTh($this->getColumnName(2), 'nu_pedidoreparacion', 'Número de Pedido de Reparación');
		$encabezados[] = $this->buildTh($this->getColumnName(3), 'nu_destino', 'Destino');
		$encabezados[] = $this->buildTh($this->getColumnName(4), 'nu_monto', 'Monto');
                $encabezados[] = $this->buildTh($this->getColumnName(5), 'ds_nombre', 'Sucursal');
		$encabezados[] = $this->buildTh($this->getColumnName(6), 'ds_nomusuario', 'Vendedor');
		$encabezados[] = $this->buildTh($this->getColumnName(7), 'ds_codigo', 'Piezas');
		return $encabezados;
	}

}
?>