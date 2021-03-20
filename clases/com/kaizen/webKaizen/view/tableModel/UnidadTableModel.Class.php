<?php

class UnidadTableModel extends ListarTableModel{

	private $columnNames = array('Tipo','Marca','Modelo', 'Color', 'Sucursal', 'F. Ingreso','Año', 'Envío', 'Nro. Motor', 'Nro. Cuadro');

	private $columnWidths = array(35, 35,45,25,20,20,12,20,35,35);

	public function UnidadTableModel(ItemCollection $items){
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Unidades";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount(){
		return 10;
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
		$oUnidad = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oUnidad, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oUnidad = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oUnidad->getProducto()->getDs_tipounidad(); break;
			case 1: $value= $oUnidad->getProducto()->getDs_marca(); break;
			case 2: $value= $oUnidad->getProducto()->getDs_modelo(); break;
			case 3: $value= $oUnidad->getProducto()->getDs_color(); break;
			case 4: $value= $oUnidad->getDs_sucursal(); break;
			case 5: $value= $oUnidad->getDt_ingreso(); break;
			case 6: $value= $oUnidad->getNu_aniomodelo(); break;
			case 7: $value= $oUnidad->getNu_envio(); break;
			case 8: $value= $oUnidad->getNu_motor(); break;
			case 9: $value= $oUnidad->getNu_cuadro(); break;
			default: $value='';	break;
		}
		return $value;
	}

	public function getEncabezados(){
		$encabezados[]= $this->buildTh($this->getColumnName(0), 'ds_tipo_unidad', 'Tipo de unidad');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_marca', 'Marca');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_modelo', 'Modelo');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'ds_color', 'Color');
		$encabezados[]= $this->buildTh($this->getColumnName(4), 'ds_nombre', 'Sucursal');
		$encabezados[]= $this->buildTh($this->getColumnName(5), 'dt_ingreso', 'Fecha Ingreso');
		$encabezados[]= $this->buildTh($this->getColumnName(6), 'nu_aniomodelo', 'A&ntilde;o modelo');
		$encabezados[]= $this->buildTh($this->getColumnName(7), 'nu_envio', 'Nro, env&iacute;o');
		$encabezados[]= $this->buildTh($this->getColumnName(8), 'nu_motor', 'Nro. Motor');
		$encabezados[]= $this->buildTh($this->getColumnName(9), 'nu_cuadro', 'Nro. Cuadro');

		return $encabezados;
	}

}
?>