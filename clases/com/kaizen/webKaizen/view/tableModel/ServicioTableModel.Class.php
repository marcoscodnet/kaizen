<?php

/**
 *
 * @author Marcos
 * @since 15-05-2012
 *
 * Table model para servicios.
 *
 */
class ServicioTableModel extends ListarTableModel {

	private $columnNames = array('Nro. servicio','Fecha','Nro. Motor','Modelo','Nro. Chasis','Cliente','Técnico','Monto','Servicio','Cerrado','Sucursal','Vendedor');
	private $columnWidths = array(15,25,30,30,30,30,30,15,30,10,18,20);

	public function ServicioTableModel(ItemCollection $items) {
		$this->items = $items;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
	 */
	function getTitle() {
		return "Servicios";
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount() {
		return 12;
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnName($columnIndex)
	 */
	function getColumnName($columnIndex) {
		return $this->columnNames[$columnIndex];
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getColumnWidth($columnIndex)
	 */
	function getColumnWidth($columnIndex) {
		return $this->columnWidths[$columnIndex];
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getRowCount()
	 */
	function getRowCount() {
		$this->items->size();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getValueAt($rowIndex, $columnIndex)
	 */
	function getValueAt($rowIndex, $columnIndex) {
		$oServicio = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oServicio, $columnIndex);
	}

	public function getValue($anObject, $columnIndex) {
		$oServicio = $anObject;
		$value = 0;
		switch ($columnIndex) {
			case 0: $value = $oServicio->getCd_servicio();
			break;
			case 1: $value = $oServicio->getDt_carga();
			break;
			case 2: $value = $oServicio->getNu_motor();
			break;
			case 3: $value = $oServicio->getDs_modelo();
			break;
			case 4: $value = $oServicio->getNu_chasis();
			break;
			case 5: $value = $oServicio->getDs_apynom();
			break;
			case 6: $value = $oServicio->getDs_mecanicos();
			break;
			case 7: $value = '$ '.FuncionesComunes::Format_toDecimal($oServicio->getNu_monto());
			break;
			case 8: $value = $oServicio->getDs_tiposervicio();
			break;
			case 9: 
				if ($oServicio->getBl_pagado()==1) {
					$value = 'SI';
				}
				else $value = 'NO';
				
			break;
			case 10: $value = $oServicio->getDs_nombre();
			break;
			case 11: $value = $oServicio->getUsuario()->getDs_apynom();
			break;
			default: $value = '';
			break;
		}
		return $value;
	}

	public function getEncabezados() {
		$encabezados[] = $this->buildTh($this->getColumnName(0), 'cd_servicio', 'Nro.servicio');
		$encabezados[] = $this->buildTh($this->getColumnName(1), 'dt_carga', 'Fecha');
		$encabezados[] = $this->buildTh($this->getColumnName(2), 'nu_motor', 'Nro.motor');
		$encabezados[] = $this->buildTh($this->getColumnName(3), 'ds_modelo', 'Modelo');
		$encabezados[] = $this->buildTh($this->getColumnName(4), 'nu_chasis', 'Chasis');
		$encabezados[] = $this->buildTh($this->getColumnName(5), 'C.ds_apynom', 'Apellido y nombre del cliente');
		$encabezados[] = $this->buildTh($this->getColumnName(6), 'ds_mecanicos', 'Técnico');
		$encabezados[] = $this->buildTh($this->getColumnName(7), 'nu_monto', 'Monto');
		$encabezados[] = $this->buildTh($this->getColumnName(8), 'ds_tipo_servicio', 'Tipo de servicio');
		$encabezados[] = $this->buildTh($this->getColumnName(9), 'bl_pagado', 'Cerrado');
		$encabezados[] = $this->buildTh($this->getColumnName(10), 'S.cd_sucursal', 'Sucursal');
		$encabezados[] = $this->buildTh($this->getColumnName(11), 'U.ds_apynom', 'Nombre de usuario');
		
		return $encabezados;
	}

}
?>