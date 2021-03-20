<?php



/**

 * El actionController decide qu� acciones ejecutar.

 * Dependiendo de los resultados, direccionar� a la vista

 * adecuada.

 * (dispatcher).

 *

 * @author bernardo

 * @since 03-03-2010

 */

class ActionController{



	private $map;



	public function ActionController(){

	}



	public function execute($ds_action_name, $cd_usuario){



		try{

			//inicializa el mapeo de acciones.

			$map = $this->getActionMapHelper();



			//obtenemos la acci�n a ejecutar.

			$ds_action=$map->getAction($ds_action_name);



			//instanciamos la acci�n por reflection.

			$oClass = new ReflectionClass($ds_action);

			$oAction = $oClass->newInstance();



			//ejecutamos la acci�n.

			$ds_action_result = $oAction->execute($cd_usuario);



			//obtenemos la vista de acuerdo al resultado.

			$ds_forward = $map->getForward($ds_action_result);






			//tiene sentido que una acci�n setee el forward a null cuando

			//dicha acci�n renderiza la vista utilizando XTemplate.

			if($ds_forward!=null)	{



				//vemos si la acci�n tiene par�metros para el forward.

				if($oAction->getDs_forward_params()!=null){



					//chequeamos si el forward ya tiene par�metros (?).

					if(!$this->tieneParametros($ds_forward))

						$ds_forward .= '?';

					else

						$ds_forward .= '&';



					$ds_forward .= $oAction->getDs_forward_params();

				}
				$nombreFile=date('Ymd');

				$_Log = fopen(APP_PATH."logs/".$nombreFile.".log", "a+") or die("Operation Failed!");

				FuncionesComunes::_log($_SESSION['ds_usuario'].': Accion ->'.$ds_action_name.' - '.$ds_action.': Resultado ->'.$ds_action_result.': Siguiente ->'.$ds_forward,$_Log);



				$this->doForward( $ds_forward );



			}



		}catch(ReflectionException $e1){

			////no existe la acci�n requerida

			$this->error( $e1 );



		}catch(GenericException $e2){

			//error no esperado.

			//print_r($e2);

			$this->error( $e2 );

		}catch(Exception $e3){

			//error no esperado.

			$this->error( $e3 );

		}



	}



	private function tieneParametros($ds_forward){

		$tiene = false;

		if(!strrchr($ds_forward, '?'));

			$tiene = true;

		return tiene;

	}



	protected function doForward( $ds_forward ){

        $host = $_SERVER['HTTP_HOST'];
        $ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        $url = "http://$host$ruta/".$ds_forward;

        header("Location: $url");
        include "../utils/redirect.php";
        die();


		//header ( 'Location: '.$ds_forward );

	}



	protected function getActionMapHelper(){

		return  new ActionMapHelper();

	}



	protected function error($e){

		$ds_forward = WEB_PATH . 'doAction?action=error&msg='.$e->getMessage() . '&code='.$e->getCode();

		print_r($ds_forward);

		$this->doForward( $ds_forward );

	}



}
