<?php
/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Factory para cliente.
 *
 */
class ClienteFactory implements ObjectFactory{

	/**
	 * construye una cliente.
	 * @param $next
	 * @return cliente
	 */
	public function build($next){
		$oCliente = new Cliente();

		$oCliente->setCd_cliente($next ['cd_cliente']);
		if(isset($next ['cliente_ds_apynom'])){
			$oCliente->setDs_apynom($next ['cliente_ds_apynom']);
		}else{
			$oCliente->setDs_apynom($next ['ds_apynom']);
		}
		$oCliente->setCd_tipodoc($next ['cd_tipodoc']);
		$oCliente->setNu_doc($next ['nu_doc']);
		$oCliente->setDt_nacimiento(implode("/", array_reverse(explode("-",$next ['dt_nacimiento']))));
		$oCliente->setCd_estadocivil($next ['cd_estadocivil']);
		$oCliente->setDs_conyuge($next ['ds_conyuge']);
		$oCliente->setDs_nacionalidad($next ['ds_nacionalidad']);
		$oCliente->setDs_cp($next ['ds_cp']);
		$oCliente->setDs_teparticular($next ['ds_telparticular']);
		$oCliente->setDs_telaboral($next ['ds_tellaboral']);
                $oCliente->setDs_email($next ['ds_email']);
		$oCliente->setDs_actividad_ocupacion($next ['ds_actividad_ocupacion']);
		$oCliente->setDs_lugartrabajo($next ['ds_lugar_trabajo']);
		$oCliente->setDs_cuil_cuit($next ['ds_cuil_cuit']);
		$oCliente->setCd_condiva($next ['cd_condiva']);
		$oCliente->setDs_dircalle($next ['ds_dircalle']);
		$oCliente->setDs_dirnro($next ['ds_dirnro']);
		$oCliente->setDs_dirpiso($next ['ds_dirpiso']);
		$oCliente->setDs_dirdepto($next ['ds_dirdepto']);
		$oCliente->setCd_localidad($next ['cd_localidad']);

		//para el caso de join con localidad.
		if(array_key_exists('ds_localidad',$next)){
			$localidadFactory = new LocalidadFactory();
			$oCliente->setLocalidad( $localidadFactory->build($next) );
		}

		if(array_key_exists('ds_tipodoc',$next)){
			$tipodocFactory = new TipodocFactory();
			$oCliente->setTipodoc( $tipodocFactory->build($next) );
		}

		if(array_key_exists('ds_estadocivil',$next)){
			$estadocivilFactory = new EstadocivilFactory();
			$oCliente->setEstadocivil( $estadocivilFactory->build($next) );
		}

		if(array_key_exists('ds_condiva',$next)){
			$condivaFactory = new CondivaFactory();
			$oCliente->setCondiva( $condivaFactory->build($next) );
		}
		
		if(array_key_exists('ds_comollego',$next)){
			$comollegoFactory = new ComollegoFactory();
			$oCliente->setComollego( $comollegoFactory->build($next) );
		}

		return $oCliente;
	}
}
?>