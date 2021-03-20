<?php
/**
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 * Table model para sucursales.
 * 
 */

class BuscarProductoTableModel extends ListarTableModel{

	private $columnNames = array('C&oacute;digo', 'Producto');

	private $columnWidths = array(30, 100);
	
	public function BuscarProductoTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Buscar Productos";
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
		$oProducto = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oProducto, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oProducto = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oProducto->getCd_producto(); break;
			case 1: $value= $oProducto->getDs_producto(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_producto', 'c&oacute;digo de producto');
	 	$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_producto', 'Producto');
	 	return $encabezados;	
	}
	
}
?>