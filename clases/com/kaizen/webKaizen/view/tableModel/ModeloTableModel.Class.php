<?php
/**
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 * Table model para modelos.
 * 
 */

class ModeloTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Modelo', 'Marca');

	private $columnWidths = array(30, 70, 60);
	
	public function ModeloTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Modelos";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount(){
		return 3;
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
		$oModelo = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oModelo, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oModelo = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oModelo->getCd_modelo(); break;
			case 1: $value= $oModelo->getDs_modelo(); break;
			case 2: $value= $oModelo->getDs_marca(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_modelo', 'c&oacute;digo de modelo');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_modelo', 'modelo');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_marca', 'marca');
	 	return $encabezados;	
	}
	
}
?>