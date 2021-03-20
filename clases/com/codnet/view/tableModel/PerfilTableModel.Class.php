<?php
/**
 * 
 * @author bernardo
 * @since 03-05-2010
 * 
 * Table model para perfiles.
 * 
 */

class PerfilTableModel extends ListarTableModel{

	private $columnNames = array('Código de Perfil', 'Nombre de perfil');

	private $columnWidths = array(30, 70);

	public function PerfilTableModel(ItemCollection $items){
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Perfiles";
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
		$oPerfil = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oPerfil, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oPerfil = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oPerfil->getCd_perfil(); break;
			case 1: $value= $oPerfil->getDs_perfil(); break;
			default: $value='';	break;
		}
		return $value;
	}

	public function getEncabezados(){
		$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_perfil', 'c&oacute;digo de perfil');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_perfil', 'Nombre de perfil');
		return $encabezados;
	}

}
?>