<?php
/**
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 * Table model para tipos de unidades.
 * 
 */

class TipounidadTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Tipo de unidad');

	private $columnWidths = array(30, 80);
	
	public function TipounidadTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Tipos de unidades";
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
		$oTipounidad = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oTipounidad, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oTipounidad = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oTipounidad->getCd_tipounidad(); break;
			case 1: $value= $oTipounidad->getDs_tipounidad(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_tipo_unidad', 'c&oacute;digo de tipo de unidad');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_tipo_unidad', 'Tipo de unidad');
	 	return $encabezados;	
	}
	
}
?>