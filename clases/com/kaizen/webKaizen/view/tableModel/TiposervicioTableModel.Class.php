<?php
/**
 * 
 * @author Marcos
 * @since 15-05-2012
 * 
 * Table model para tipos de servicios.
 * 
 */

class TiposervicioTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Tipo de servicio');

	private $columnWidths = array(30, 80);
	
	public function TiposervicioTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Tipos de servicios";
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
		$oTiposervicio = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oTiposervicio, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oTiposervicio = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oTiposervicio->getCd_tiposervicio(); break;
			case 1: $value= $oTiposervicio->getDs_tiposervicio(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_tipo_servicio', 'c&oacute;digo de tipo de servicio');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_tipo_servicio', 'Tipo de servicio');
	 	return $encabezados;	
	}
	
}
?>