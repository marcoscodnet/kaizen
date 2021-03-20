<?php

/**
 * Representa el layout para kaizen en el cuál
 * se incluye el menú:
 * 
 *  <header>
 *  <menu>
 *  <content>
 *  <footer>
 * 
 * 
 * @author Lucrecia
 * @since 07-04-2010
 */
class LayoutMenuKaizen extends LayoutKaizen implements SecureLayout{

	private $menu;
	
	public function getContenido(){
		$content = parent::getContenido();

		//le agregamos el menú.
		//$content = $this->menu . $content;
			
		return $content;	
	}
	
	public function setMenu($_menu){
		$this->menu = $_menu;
	}
	
	public function showLayout(){
		return $this->show();
	}


}
