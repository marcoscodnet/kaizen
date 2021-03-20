<?php

/**
 * Representa el layout para kaizen en el cu�l
 * se incluye el men�:
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

		//le agregamos el men�.
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
