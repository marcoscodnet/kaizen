<?php

/**
 *
 * @author Lucrecia
 * @since 03-01-2011
 *
 * Table model para movimientos.
 *
 */
class PedidoTableModel extends ListarTableModel {

	private $columnNames = array('F. Pedido','Pieza','Pieza Nueva','Observación', 'Estado');
	private $columnWidths = array(30,50,50,50,40);

	public function PedidoTableModel(ItemCollection $items) {
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle() {
		return "Pedidos";
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
		$oPedido = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oPedido, $columnIndex);
	}

	public function getValue($anObject, $columnIndex) {
		$oPedido = $anObject;
		$value = 0;
				
		$dsPiezaAux = $oPedido->getDs_pieza();
		/*if (!isset($dsPiezaAux)){
			$dsPiezaAux = $oPedido->getPieza()->getDs_codigo();
		} */
		
		$cd_estado=$oPedido->getCd_estado();
		if($cd_estado==0)
			$ds_estado="A PEDIR";
		else 
			$ds_estado="PEDIDO";
			
		switch ($columnIndex) {
			case 0: $value = $oPedido->getDt_pedido();
			break;
			case 1: $value = $oPedido->getPieza()->getDs_codigo();
			break;
			case 2: $value = $dsPiezaAux;
			break;
			case 3: $value = $oPedido->getDs_observacion();
			break;
			case 4: $value = $ds_estado;
			break;
			default: $value = '';
			break;
		}
		return $value;
	}

	public function getEncabezados() {
		$encabezados[] = $this->buildTh($this->getColumnName(0), 'dt_pedido', 'F. Pedido');
		$encabezados[] = $this->buildTh($this->getColumnName(1), 'ds_codigo', 'Pieza');
		$encabezados[] = $this->buildTh($this->getColumnName(2), 'ds_pieza', 'Pieza Nueva');
		$encabezados[] = $this->buildTh($this->getColumnName(3), 'ds_observacion', 'Observación');
		$encabezados[] = $this->buildTh($this->getColumnName(4), 'cd_estado', 'Estado');
		return $encabezados;
	}

}
?>