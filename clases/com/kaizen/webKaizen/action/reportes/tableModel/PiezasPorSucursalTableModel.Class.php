<?php
/**
 * 
 * @author marcos
 * @since 2--02-2012
 * 
 * Descriptor para la colección del reporte de piezas por Sucursal.
 * 
 */

class PiezasPorSucursalTableModel extends ListarTableModel{
	
	private $columnNames = array('Código', 'Descripción', 'Sucursal', 'Stock');

	private $columnWidths = array(40, 120, 90, 30);
	
	
	public function PiezasPorSucursalTableModel(ItemCollection $items){
		$this->setItems( $items );
	}	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/pdf/ICollectionDescriptor#getTitle()
	 */
	function getTitle(){
		return "Piezas por sucursal";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount(){
		return 4;
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
	

	function getValueAt( $rowIndex, $columnIndex){
		return $this->getValue($this->items->getObjectByIndex($rowIndex), $columnIndex);
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/elecnor/webElecnor/action/ListarTableModel#getValue($anObject, $columnIndex)
	 */
	function getValue($anObject, $columnIndex){
		$value=0;
		
		switch ($columnIndex) {
			case 0: $value= $anObject->getPieza()->getDs_codigo (); break;
			case 1: $value= $anObject->getPieza()->getDs_descripcion (); break;
			case 2: $value= $anObject->getSucursal()->getDs_nombre(); break;
			case 3: $value= $anObject->getNu_cantidad(); break;
			
			default: $value='';	break;
		}
		return $value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/elecnor/webElecnor/action/ListarTableModel#getEncabezados()
	 */
	public function getEncabezados(){
		$encabezados[]= $this->buildTh($this->getColumnName(0), 'ds_codigo',  'código'); 
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_descripcion',  'descripción');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_nombre',  'sucursal');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'nu_cantidad',  'stock');
		
		
	 	return $encabezados;
	}	
	
}
?>