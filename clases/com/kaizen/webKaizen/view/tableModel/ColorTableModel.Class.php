<?php
/**
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 * Table model para colores.
 * 
 */

class ColorTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Color');

	private $columnWidths = array(30, 80);
	
	public function ColorTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Colores";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount(){
		return 2;
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
		$oColor = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oColor, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oColor = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oColor->getCd_color(); break;
			case 1: $value= $oColor->getDs_color(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_color', 'c&oacute;digo de color');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_color', 'color');
	 	return $encabezados;	
	}
	
}
?>