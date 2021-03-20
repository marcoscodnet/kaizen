<?php
/**
 * 
 * @author Marcos
 * @since 29-04-2020
 * 
 * Table model para clientes.
 * 
 */

class ClienteTableModel extends ListarTableModel{

	private $columnNames = array('Codigo', 'Apellido y nombre', 'DNI', 'Te. Particular', 'Te. Movil', 'Localidad',	'Provincia','Nacimiento','E-mail');

	private $columnWidths = array(10, 90,20, 30, 20, 20, 30,20,40);
	
	public function ClienteTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Clientes";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount(){
		return 9;
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
		$oCliente = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oCliente, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oCliente = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oCliente->getCd_cliente(); break;
			case 1: $value= $oCliente->getDs_apynom(); break;
			case 2: $value= $oCliente->getDNI(); break;
			case 3: $value= $oCliente->getDs_teparticular(); break;
			case 4: $value= $oCliente->getDs_telaboral(); break;
			case 5: $value= $oCliente->getDs_localidad(); break;
			case 6: $value= $oCliente->getDs_provincia(); break;
			
			case 7: $value= $oCliente->getDt_nacimiento(); break;
			
			case 8: $value= $oCliente->getDs_email(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_cliente', 'c&oacute;digo del cliente');
		 $encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_apynom', 'Apellido y nombre del cliente');
		
	 	$encabezados[]= $this->buildTh($this->getColumnName(2), 'nu_doc', 'DNI');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'ds_telparticular', 'Te. particular del cliente');
		$encabezados[]= $this->buildTh($this->getColumnName(4), 'ds_tellaboral', 'Te. Movil');
	 	$encabezados[]= $this->buildTh($this->getColumnName(5), 'ds_localidad', 'localidad del cliente');
		$encabezados[]= $this->buildTh($this->getColumnName(6), 'ds_provincia', 'provincia del cliente');
	
		$encabezados[]= $this->buildTh($this->getColumnName(7), 'dt_nacimiento', 'Nacimiento');
		
		$encabezados[]= $this->buildTh($this->getColumnName(8), 'ds_email', 'E-mail');
	 	return $encabezados;	
	}
	
}
?>