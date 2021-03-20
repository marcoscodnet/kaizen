<?php
/**
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 * Table model para modelos.
 * 
 */

class MarcaTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Marca');

	private $columnWidths = array(30, 70);
	
	public function MarcaTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Marcas";
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
		$oMarca = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oMarca, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oMarca = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oMarca->getCd_marca(); break;
			case 1: $value= $oMarca->getDs_marca(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_marca', 'c&oacute;digo de marca');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_marca', 'marca');
	 	return $encabezados;	
	}
	
}
?>