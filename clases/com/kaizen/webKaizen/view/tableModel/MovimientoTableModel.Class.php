<?php

/**
 *
 * @author Lucrecia
 * @since 03-01-2011
 *
 * Table model para movimientos.
 *
 */
class MovimientoTableModel extends ListarTableModel {

	private $columnNames = array('C&oacute;digo','Usuario', 'Sucursal Origen', 'Sucursal Destino', 'Fecha');
	private $columnWidths = array(30,30, 55,55,55);

	public function MovimientoTableModel(ItemCollection $items) {
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle() {
		return "Movimientos";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount() {
		return 5;
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
		$oUnidad = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oUnidad, $columnIndex);
	}

	public function getValue($anObject, $columnIndex) {
		$oMovimiento = $anObject;
		$value = 0;
		switch ($columnIndex) {
			case 0: $value = $oMovimiento->getCd_movimiento();
			break;
			case 1: $value = $oMovimiento->getDs_nomusuario();
			break;
			case 2: $value = $oMovimiento->getDs_sucursalorigen();
			break;
			case 3: $value = $oMovimiento->getDs_sucursaldestino();
			break;
			case 4: $value = $oMovimiento->getDt_movimiento();
			break;
			default: $value = '';
			break;
		}
		return $value;
	}

	public function getEncabezados() {
		$encabezados[] = $this->buildTh($this->getColumnName(0), 'cd_movimiento', 'c&oacute;digo de movimiento');
		$encabezados[] = $this->buildTh($this->getColumnName(1), 'ds_nomusuario', 'Nombre de Usuario');
		$encabezados[] = $this->buildTh($this->getColumnName(2), 'SO.ds_nombre', 'Sucursal Origen');
		$encabezados[] = $this->buildTh($this->getColumnName(3), 'SD.ds_nombre', 'Sucursal Destino');
		$encabezados[] = $this->buildTh($this->getColumnName(4), 'dt_movimiento', 'Fecha movimiento');
		return $encabezados;
	}

}
?>