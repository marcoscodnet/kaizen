<?php

/**
 *
 * @author Lucrecia
 * @since 03-01-2011
 *
 * Table model para movimientos.
 *
 */
class VentaTableModel extends ListarTableModel {

	private $columnNames = array('Nro. motor','Modelo','Cliente', 'Vendedor', 'Sucursal', 'Fecha', 'Acreditado', 'Estado', "Pago");
	private $columnWidths = array(30,50,50,35,30,20, 25, 20, 15);

	public function VentaTableModel(ItemCollection $items) {
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle() {
		return "Ventas";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount() {
		return 9;
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
		$oVenta = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oVenta, $columnIndex);
	}

	public function getValue($anObject, $columnIndex) {
		$oVenta = $anObject;
		$value = 0;
		switch ($columnIndex) {
			case 0: $value = $oVenta->getNu_motor();
			break;
			case 1: $value = $oVenta->getDs_modelo();
			break;
			case 2: $value = $oVenta->getDs_apynom();
			break;
			case 3: $value = $oVenta->getDs_apynom_usuario();
			break;
			case 4: $value = $oVenta->getDs_nombre();
			break;
			case 5: $value = $oVenta->getDt_fecha();
			break;
			case 6: $value = $oVenta->getNu_montoVenta();
			break;
			case 7: $value = $oVenta->getDs_autorizada();
			break;
                        case 8: $value = $oVenta->getDs_formapago();
			break;
			default: $value = '';
			break;
		}
		return $value;
	}

	public function getEncabezados() {
		$encabezados[] = $this->buildTh($this->getColumnName(0), 'nu_motor', 'Nro.motor');
		$encabezados[] = $this->buildTh($this->getColumnName(1), 'ds_modelo', 'Modelo');
		$encabezados[] = $this->buildTh($this->getColumnName(2), 'C.ds_apynom', 'Apellido y nombre del cliente');
		$encabezados[] = $this->buildTh($this->getColumnName(3), 'U.ds_apynom', 'Nombre de usuario');
		$encabezados[] = $this->buildTh($this->getColumnName(4), 'ds_nombre', 'Sucursal');
		$encabezados[] = $this->buildTh($this->getColumnName(5), 'dt_venta', 'Fecha');
		$encabezados[] = $this->buildTh($this->getColumnName(6), 'nu_total', 'Import venta');
		$encabezados[] = $this->buildTh($this->getColumnName(7), 'cd_autorizacion', 'Autorización');
                $encabezados[] = $this->buildTh($this->getColumnName(8), 'ds_formapago', 'Forma de pago');
		return $encabezados;
	}

}
?>