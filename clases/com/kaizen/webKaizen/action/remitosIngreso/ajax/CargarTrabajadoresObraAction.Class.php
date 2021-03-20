<?php
/**
 * Acción para cargar trabajadores de obra en un combo
 * utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 13-04-2010
 *
 */
class CargarTrabajadoresObraAction extends CargarEntidadesAction{

	
	function CargarTrabajadoresObraAction($_onchange=null){
		$this->ds_id='trabajadorObra';	
		$this->ds_label='Trabajador Obra';
		$this->ds_parentId='cd_obra';
		$this->onchange=$_onchange;
		
	}

	protected function parseEntidad ($entidad, $xtpl){
		
		//las entidades con código=0 serán separadores.
		if($entidad->getCd_tipoTrabajador()==0){
		
			$xtpl->assign ( $this->getDs_codeTag(), $entidad->getDs_trabajador()  );				
			$xtpl->assign ( 'option', 'optgroup' );				
			$xtpl->assign ( 'tag', 'label' );				
			$xtpl->assign ( 'style', 'style="color: rgb(196, 113, 0);"' );				
			$xtpl->parse ( 'main.option' );
							
		}else{
			parent::parseEntidad( $entidad, $xtpl );
		}
		
		
	}
	
	public function getEntidades($parent){
		$manager = new ObraManager();
		try{
			$oObra = new Obra();
			$oObra->setCd_obra( $parent );
			$trabajadoresObra = $manager->getTrabajadores( $oObra );
			
			/*
			 * ordenamos por tipo de trabajador y mostramos
			 * una opción a modo de encabezado para cada tipo
			 * de trabajador:			   
			 *    ----- contratista -----
			 *          Martín
			 *          Carlos
			 *    ----- cuadrilla -----
			 *          N° 8 - Responsable: Javier
			 *          N° 9 - Responsable: Claudia      			
			 */
			$trabajadores = new ItemCollection();
			
			$oTipoTrabajador= new TipoTrabajador();
			
			foreach ($trabajadoresObra as $key => $oNext) {

				if($oTipoTrabajador->getCd_tipoTrabajador()!= $oNext->getCd_tipoTrabajador()){
					$oTipoTrabajador = $oNext->getTipoTrabajador();
					$oTrabajadorTitulo = $this->getSeparador( $oTipoTrabajador->getDs_tipoTrabajador() );
					$trabajadores->addItem($oTrabajadorTitulo);
				}
				$trabajadores->addItem($oNext);
				
			}
			
			
			
			
		}catch(GenericException $ex){
			$trabajadores = new ItemCollection();
		}
		return $trabajadores;
	}
	
	public function getCode($entidad){
		return $entidad->getCd_trabajadorObra();
	}
	
	public function getDesc($entidad){
		return htmlentities( $entidad );
	}
	
	public function getFuncion(){
		return null;
		//TODO return "Listar TrabajadorObra";
	}
	
	private function getSeparador($titulo){
		
		$oTrabajadorTitulo = new TrabajadorObra();
		$oTrabajador = new Trabajador();
		$oTrabajador->setDs_nombre('--------- '. $titulo . ' ---------');
		$oTrabajadorTitulo->setTrabajador($oTrabajador);
		$oTrabajadorTitulo->setCd_trabajadorObra(0);
		return $oTrabajadorTitulo;
	}
}