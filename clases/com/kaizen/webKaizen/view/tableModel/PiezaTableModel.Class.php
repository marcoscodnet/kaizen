<?php
/**
 *
 * @author Ma. Jesï¿½s
 * @since 18-06-2011
 *
 * Table model para piezas.
 *
 */

class PiezaTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Descripción','Stock Mínimo', 'Stock Actual','Pcio. Costo', 'Pcio. Mínimo', 'Observaciones');

	private $columnWidths = array(30, 80, 20, 20, 20, 20, 80);

	public function PiezaTableModel(ItemCollection $items){
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Piezas";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount(){
		return 7;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnName($columnIndex)
	 */
	function getColumnName($columnIndex){
		return $this->columnNames[$columnIndex];
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnWidth($columnIndex)
	 */
	function getColumnWidth($columnIndex){
		return $this->columnWidths[$columnIndex];
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getRowCount()
	 */
	function getRowCount(){
		$this->items->size();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getValueAt($rowIndex, $columnIndex)
	 */
	function getValueAt($rowIndex, $columnIndex){
		$oPista = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oPista, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oPista = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oPista->getDs_codigo (); break;
			case 1: $value= $oPista->getDs_descripcion (); break;
			case 2: $value= $oPista->getNu_stock_minimo (); break;
			case 3: $value= $oPista->getNu_stock_actual(); break;
			case 4: $value= $oPista->getQt_costo(); break;
			case 5: $value= $oPista->getQt_minimo(); break;
			case 6: $value= $oPista->getDs_observacion(); break;
			default: $value='';	break;
			
		}
		return $value;
	}

	public function getEncabezados(){
		$encabezados[]= $this->buildTh($this->getColumnName(0), 'ds_codigo', 'Código');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_descripcion', 'Descripci&oacute;n');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'nu_stock_minimo', 'Stock Mínimo');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'nu_stock_actual', 'Stock Actual');
		$encabezados[]= $this->buildTh($this->getColumnName(4), 'qt_costo', 'Pcio. Costo');
		$encabezados[]= $this->buildTh($this->getColumnName(5), 'qt_minimo', 'Pcio. Mínimo');
		$encabezados[]= $this->buildTh($this->getColumnName(6), 'ds_observacion', 'Observaciones');
		return $encabezados;
	}

}
?>