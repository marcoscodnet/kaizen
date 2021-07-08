<?php



/**

 * Acci�n para editar un entidad.

 *

 * @author Lucrecia

 * @since 22-04-2010

 *

 */

abstract class EditarEntidadAction extends EditarAction{



	/**

	 * (non-PHPdoc)

	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()

	 */

	protected function getEntidad(){

		$oEntidad = new Entidad();



		if (isset ( $_POST ['cd_entidad'] ))

			$oEntidad->setCd_entidad (  $_POST ['cd_entidad']  );



		if (isset ( $_POST ['ds_entidad'] ))

			$oEntidad->setDs_entidad (  $_POST ['ds_entidad']  );

        $oEntidad->setBl_activo(0);
        if ($_POST ['bl_activo']){
            $oEntidad->setBl_activo(1);
        }

		return $oEntidad;

	}

}
