<?php
/**
 *
 * @author bernardo
 * @since 04-03-2010
 *
 * Este factory crea una colecci�n de objetos a partir
 * del resultado de un query.
 *
 */

class ResultFactory {

	/**
	 * mapea los resultados en una colecci�n
	 * @param $db manejador de bbdd.
	 * @param $result resultados de un query.
	 * @param $factory construye el objeto espec�fico.
	 * @return itemCollection
	 */
	public static function toCollection($db, $result, ObjectFactory $factory){
		$coleccion = new ItemCollection();
		while ( $next = $db->sql_fetchassoc ( $result ) ) {
			$oNext = $factory->build($next);
			$coleccion->addItem($oNext);
		}
		return $coleccion;
	}

	/**
	 * mapea los resultados en una colecci�n donde el �ndice para
	 * acceder a cada objeto es su identificador.
	 * @param $db manejador de bbdd.
	 * @param $result resultados de un query.
	 * @param $factory construye el objeto espec�fico.
	 * @return itemCollection
	 */
	public static function toCollectionWithCode($db, $result, ObjectCodeFactory $factory){
		$coleccion = new ItemCollection();
		while ( $next = $db->sql_fetchassoc ( $result ) ) {
			$oNext = $factory->build($next);
			$oNextCode = $factory->getCode($oNext);
			$coleccion->addItem($oNext, $oNextCode);
		}
		return $coleccion;
	}

}
?>