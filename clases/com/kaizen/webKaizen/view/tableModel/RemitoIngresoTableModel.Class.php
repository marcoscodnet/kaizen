<?php
/**
 * 
 * @author Lucrecia
 * @since 03-01-2011
 * 
 * Table model para remitos de ingreso.
 * 
 */

class RemitoIngresoTableModel extends ListarTableModel{

	private $columnNames = array('N° Remito ingreso', 'Fecha', 'Proveedor', 'Tipo y N° Comprobante Proveedor');

	private $columnWidths = array(35, 30, 50, 50);
	
	public function RemitoEgresoTableModel(ItemCollection $items){
		$this->setItems($items);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Remitos de ingreso";
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
	 * @see clases/com/codnet/view/tableModel/TableModel#getValueAt($rowIndex, $columnIndex)
	 */
	function getValueAt($rowIndex, $columnIndex){
		$oRemito = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oRemito, $columnIndex);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarTableModel#getValue($anObject, $columnIndex)
	 */
	public function getValue($anObject, $columnIndex){
		$oRemito = $anObject;
		$value=0;
		switch ($columnIndex) {
			case 0: $value= $oRemito->getCd_remito(); break;
			case 1: $value= FuncionesComunes::fechaMysqlaPHP ( $oRemito->getDt_fecha() ); break;
			case 2: $value= $oRemito->getDs_proveedor(); break;
			case 3: $value= $oRemito->getDs_tipo() . ' N° ' . $oRemito->getNu_numero(); break;
			default: $value='';	break;
		}
		return $value;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/ListarTableModel#getEncabezados()
	 */
	public function getEncabezados(){
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_remito',  'n&uacute;mero de remito');
		$encabezados[]= $this->buildTh($this->getColumnName(1), 'dt_fecha',  'fecha del remito');
		$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_razonSocial',  'proveedor del remito');
		$encabezados[]= $this->buildTh($this->getColumnName(3), 'ds_tiporemitoingreso',  'n&deg; comprobante proveedor');
		return $encabezados;	
	}
	
}
?>