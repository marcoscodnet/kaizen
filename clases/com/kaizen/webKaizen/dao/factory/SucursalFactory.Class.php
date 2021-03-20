<?php

/**
 * 
 * @author Lucrecia
 * @since 18-01-2011
 * 
 * Factory para sucursal.
 *
 */
class SucursalFactory implements ObjectFactory {

    /**
     * construye una sucursal.
     * @param $next
     * @return sucursal
     */
    public function build($next) {
        $oSucursal = new Sucursal();
        $oSucursal->setCd_sucursal($next ['cd_sucursal']);
        $oSucursal->setDs_nombre($next ['ds_nombre']);
        $oSucursal->setDs_email($next ['ds_email']);
        $oSucursal->setDs_telefono($next ['ds_telefono']);
        $oSucursal->setDs_domicilio($next ['ds_domicilio']);
        $oSucursal->setDs_comentario($next ['ds_comentario']);
        $oSucursal->setCd_localidad($next ['cd_localidad']);

        //para el caso de join con localidad.
        if (array_key_exists('ds_localidad_sucursal', $next) || array_key_exists('ds_localidad', $next)) {
            $localidadFactory = new LocalidadFactory();
            if (array_key_exists('ds_localidad_sucursal', $next)) {
                $tmp_next['ds_localidad'] = $next['ds_localidad_sucursal'];
                $tmp_next['cd_localidad'] = $next['cd_localidad_sucursal'];
                $tmp_next['cd_provincia'] = $next['cd_provincia_sucursal'];
                $oSucursal->setLocalidad($localidadFactory->build($tmp_next));
            } else {

                $oSucursal->setLocalidad($localidadFactory->build($next));
            }
        }

        return $oSucursal;
    }

}
?>