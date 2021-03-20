<?php
/**
 *
 * @author Lucrecia
 * @since 03-01-2011
 *
 * Table model para sucursales.
 *
 */

class ProductoTableModel extends ListarTableModel{

	private $columnNames = array('Código', 'Tipo', 'Marca','Modelo', 'Color','Pcio Sugerido', 'Stock Min. ', 'Stock Actual', 'Discontinuo');

	private $columnWidths = array(30, 40, 30, 20,40, 40, 40, 40,20);

	public function ProductoTableModel(ItemCollection $items){
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Productos";
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
		$oProducto = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oProducto, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oProducto = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oProducto->getCd_producto(); break;
			case 1: $value= $oProducto->getDs_tipounidad(); break;
			case 2: $value= $oProducto->getDs_marca(); break;
			case 3: $value= $oProducto->getDs_modelo(); break;
			case 4: $value= $oProducto->getDs_color(); break;
			case 5: $value= $oProducto->getNu_monto_sugerido(); break;
			case 6: $value= $oProducto->getNu_stock_minimo(); break;
			case 7: $value= $oProducto->getNu_stock_actual(); break;
			case 8: 
				
				if ($oProducto->getBl_discontinuo()==1) {
					$value = 'SI';
				}
				else $value = 'NO';
				
			break;
			default: $value='';	break;
		}
		return $value;
	}

	public function getEncabezados(){
		$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_producto', 'c&oacute;digo de producto');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_tipo_unidad', 'Tipo de unidad');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_marca', 'Marca');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'ds_modelo', 'Modelo');
		$encabezados[]= $this->buildTh($this->getColumnName(4), 'ds_color', 'Color');
		$encabezados[]= $this->buildTh($this->getColumnName(5), 'nu_monto_sugerido', 'Monto Sugerido');
		$encabezados[]= $this->buildTh($this->getColumnName(6), 'nu_stock_minimo', 'Stock Mínimo');
		$encabezados[]= $this->buildTh($this->getColumnName(7), 'stock_actual', 'Stock Actual');
		$encabezados[]= $this->buildTh($this->getColumnName(8), 'bl_discontinuo', 'Discontinuo');
		return $encabezados;
	}

}
?>