<?php
/**
 * 
 * @author bernardo
 * @since 03-05-2010
 * 
 * Table model para las acciones listar.
 * 
 */

abstract class ListarTableModel implements TableModel{

	protected $items; //modelo (ItemCollection).
	
	public function setItems(ItemCollection $items){
		$this->items = $items;
	}
	
	public function getItems(){
		return $this->items;
	}
	
	/**
	 * retorna el valor de una columna para un objecto.
	 * @param unknown_type $anObject
	 * @param unknown_type $columnIndex
	 * @return valor
	 */
	abstract public function getValue($anObject, $columnIndex);
	
	/**
	 * se retorna una lista con los encabezados de las columnas.
	 * cada elemento de la lista deberá ser un array de la forma:
	 *    - th['encabezado']='titulo'
	 *    - th['campoOrden']='campo_orden'
	 *    - th['descripcionOrden']='descripción de la ordenación'
	 * se puede usar el método buildTh(nombre, orden, descripcion) para formar dicho arreglo.   
	 * @return unknown_type
	 */
	abstract public function getEncabezados();
	
	/**
	 * construye un encabezado.
	 * @param unknown_type $titulo
	 * @param unknown_type $orden
	 * @param unknown_type $descripcion
	 * @return unknown_type
	 */
	protected function buildTh($titulo, $orden, $descripcion){
		$th['encabezado']= $titulo;
	 	$th['campoOrden']= $orden;
	 	$th['descripcionOrden']= $descripcion;
		return $th;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/view/tableModel/TableModel#getRowCount()
	 */
	function getRowCount(){
		return $this->getItems()->size();
	}
	
	
}
?>