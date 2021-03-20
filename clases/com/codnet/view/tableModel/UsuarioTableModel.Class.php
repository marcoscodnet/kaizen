<?php
/**
 * 
 * @author bernardo
 * @since 03-05-2010
 * 
 * Table model para usuarios.
 * 
 */

class UsuarioTableModel extends ListarTableModel{

	private $columnNames = array('Nombre de Usuario', 'Perfil', 'Nombre y Apellido','E-mail');

	private $columnWidths = array(50, 60, 70, 60);
	
	public function UsuarioTableModel(ItemCollection $items){
		$this->items = $items;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Usuarios";
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
		$oUsuario = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oUsuario, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oUsuario = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oUsuario->getDs_nomusuario(); break;
			case 1: $value= $oUsuario->getDs_perfil(); break;
			case 2: $value= $oUsuario->getDs_apynom(); break;
			case 3: $value= $oUsuario->getDs_mail(); break;
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'ds_nomusuario', 'c&oacute;digo de usuario');
	 	$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_perfil', 'Nombre de usuario');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_apynom', 'Nobre y Apellido');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'ds_mail', 'E-mail');
		
	 	return $encabezados;	
	}
	
}
?>