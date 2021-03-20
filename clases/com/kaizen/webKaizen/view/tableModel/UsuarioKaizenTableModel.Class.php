<?php

/**
 * 
 * @author bernardo
 * @since 03-05-2010
 * 
 * Table model para usuarios.
 * 
 */
class UsuarioKaizenTableModel extends ListarTableModel {

    private $columnNames = array('Nombre de Usuario', 'Perfil', 'Nombre y Apellido', 'Sucursal', 'Activo');
    private $columnWidths = array(50, 60, 70, 60, 20);

    protected function getEntidad() {
        return new UsuarioKaizen();
    }

    public function UsuarioKaizenTableModel(ItemCollection $items) {
        $this->items = $items;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/view/tableModel/TableModel#getTitle()
     */
    function getTitle() {
        return "Usuarios";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/view/tableModel/TableModel#getColumnCount()
     */
    function getColumnCount() {
        return 5;
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

    public function getValue($anObject, $columnIndex) {
        $oUsuario = $anObject;
        $value = 0;
        switch ($columnIndex) {
            case 0: $value = $oUsuario->getDs_nomusuario();
                break;
            case 1: $value = $oUsuario->getDs_perfil();
                break;
            case 2: $value = $oUsuario->getDs_apynom();
                break;
            case 3: $value = $oUsuario->getDs_sucursal();
                break;
            case 4: 
				
				if ($oUsuario->getBl_activo()==1) {
					$value = 'SI';
				}
				else $value = 'NO';
				
			break;
            default: $value = '';
                break;
        }
        return $value;
    }

    function getValueAt($rowIndex, $columnIndex) {
        $oUsuario = $this->items->getObjectByIndex($rowIndex);
        return $this->getValue($oUsuario, $columnIndex);
    }

    public function getEncabezados() {
        $encabezados[] = $this->buildTh($this->getColumnName(0), 'ds_nomusuario', 'c&oacute;digo de usuario');
        $encabezados[] = $this->buildTh($this->getColumnName(1), 'ds_perfil', 'Nombre de usuario');
        $encabezados[] = $this->buildTh($this->getColumnName(2), 'ds_apynom', 'Nobre y Apellido');
        $encabezados[] = $this->buildTh($this->getColumnName(3), 'ds_nombre', 'Sucursal');
		$encabezados[] = $this->buildTh($this->getColumnName(4), 'bl_activo', 'Activo');
        return $encabezados;
    }

}
?>