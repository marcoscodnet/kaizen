<?php
/**
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 * Table model para sucursales.
 * 
 */

class SucursalTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Nombre', 'E-mail', 
								 'Teléfono', 'Localidad',	'Provincia', 'País');

	private $columnWidths = array(30, 70, 60, 
								 30, 30, 30, 30);
	
	public function SucursalTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Sucursales";
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
		$oSucursal = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oSucursal, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oSucursal = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oSucursal->getCd_sucursal(); break;
			case 1: $value= $oSucursal->getDs_nombre(); break;
			case 2: $value= $oSucursal->getDs_email(); break;
			case 3: $value= $oSucursal->getDs_telefono(); break;
			case 4: $value= $oSucursal->getDs_localidad(); break;
			case 5: $value= $oSucursal->getDs_provincia(); break;
			case 6: $value= $oSucursal->getDs_pais(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_sucursal', 'c&oacute;digo de sucursal');
	 	$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_nombre', 'nombre de la sucursal');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_email', 'e-mail de la sucursal');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'ds_telefono', 'tel&eacute;fono de la sucursal');
	 	$encabezados[]= $this->buildTh($this->getColumnName(4), 'ds_localidad', 'localidad');
		$encabezados[]= $this->buildTh($this->getColumnName(5), 'ds_provincia', 'provincia');
		$encabezados[]= $this->buildTh($this->getColumnName(6), 'ds_pais', 'pa&iacute;s');
	 	return $encabezados;	
	}
	
}
?>