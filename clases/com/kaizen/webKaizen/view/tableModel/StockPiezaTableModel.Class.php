<?php
/**
 *
 * @author Ma. Jesï¿½s
 * @since 18-06-2011
 *
 * Table model para stock piezas.
 *
 */

class StockPiezaTableModel extends ListarTableModel{

	private $columnNames = array('Remito','Pieza', 'Descripción', 'Cantidad', 'Pcio. Costo', 'Pcio. Mínimo', 'Sucursal', 'Proveedor', 'Fecha Ingreso');

	private $columnWidths = array(30,30, 40, 30, 40, 40, 30, 40, 40);

	public function StockPiezaTableModel(ItemCollection $items){
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Stock Pistas";
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
		$oStockPista = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oStockPista, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oStockPieza = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oStockPieza->getDs_remito(); break;						case 1: $value= $oStockPieza->getPieza()->getDs_codigo(); break;
			case 2: $value= $oStockPieza->getPieza()->getDs_descripcion(); break;
			case 3: $value= $oStockPieza->getNu_cantidad (); break;
			case 4: $value= $oStockPieza->getQt_costo(); break;
			case 5: $value= $oStockPieza->getQt_minimo(); break;
			case 6: $value= $oStockPieza->getSucursal()->getDs_nombre(); break;
			case 7: $value= $oStockPieza->getProveedor()->getDs_proveedor(); break;
			case 8: $value= $oStockPieza->getDt_ingreso (); break;
			default: $value='';	break;
			
		}
		return $value;
	}

	public function getEncabezados(){		$encabezados[]= $this->buildTh($this->getColumnName(0), 'ds_remito', 'Remito');		
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_codigo', 'Pieza');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_descripcion', 'Descripción');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'nu_cantidad', 'Cantidad');
		$encabezados[]= $this->buildTh($this->getColumnName(4), 'qt_costo', 'Pcio. Costo');
		$encabezados[]= $this->buildTh($this->getColumnName(5), 'qt_minimo', 'Pcio. Mínimo');
		$encabezados[]= $this->buildTh($this->getColumnName(6), 'ds_nombre', 'Sucursal');
		$encabezados[]= $this->buildTh($this->getColumnName(7), 'ds_proveedor', 'Proveedor');
		$encabezados[]= $this->buildTh($this->getColumnName(8), 'dt_ingreso', 'Fecha Ingreso');
		return $encabezados;
	}

}
?>