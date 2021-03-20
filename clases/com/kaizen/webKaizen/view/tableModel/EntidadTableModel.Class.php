<?php
/**
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 * Table model para entidades.
 * 
 */

class EntidadTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Entidad');

	private $columnWidths = array(30, 80);
	
	public function EntidadTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Entidades";
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
		$oEntidad = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oEntidad, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oEntidad = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oEntidad->getCd_entidad(); break;
			case 1: $value= $oEntidad->getDs_entidad(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_entidad', 'c&oacute;digo de entidad');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_entidad', 'entidad');
	 	return $encabezados;	
	}
	
}
?>