<?php
/**
 * Para representar criterios de b�squeda.
 *
 * La idea es no tener que modificar la especificaci�n de un m�todo
 * cada vez que queremos agregar criterios de b�squeda a un query.
 *
 * Ej:
 *    -  buscar($id, $nombre);
 *    despu�s queremos buscar tambi�n por domicilio y tel�fono
 *    -  buscar($id, $nombre, $domicilio, $telefono);
 *    y adem�s luego queremos filtrar tambi�n por celular
 *    -  buscar($id, $nombre, $domicilio, $telefono, $celular);
 *
 *    y as� va creciendo la especificaci�n del m�todo.
 *
 *    Usando el un criterio de b�squeda ser�a:
 *
 *    - buscar ($criterio );
 *
 *    y vamos modificando el criterio de b�squeda a medida que sea necesario.
 *
 * @author bernardo
 * @since 27-04-10
 *
 */
class CriterioBusqueda{

	private $camposNotNull;//campos a determinar que no sean null.
	private $camposNull;//campos a determinar que sean null.
	private $camposOrden;//campos para ordenar.
	private $camposGroupBy;//campos para ordenar.
	private $page;//p�gina a paginar.
	private $row_per_page;//cantidad de filas para el paginado.
	private $filtros; //filtros de b�squeda. array ( key=>campo, value=> (valor, operador, format))
	private $filtros_having;
	private $oExpresion;

	public function CriterioBusqueda(){
		$this->filtros = array();
		$this->filtros_having = array();
		$this->camposNotNull = array();
		$this->camposNull = array();
		$this->camposOrden = array();
		$this->camposGroupBy = array();
		$this->oExpresion = null;
	}

	public function setPage($page){
		$this->page = $page;
	}

	public function setRowPerPage($row_per_page){
		$this->row_per_page = $row_per_page;
	}

	public function getPage(){
		return $this->page;
	}

	public function getRowPerPage(){
		return $this->row_per_page;
	}


	/**
	 * setea el valor a un campo para buscar por like.

	 *	NOTA: Cambi� la manera de tratar los filtros.
	 * Primeramente se agregaban filtros con este m�todo, y siempre se anidaban con el operador AND.
	 * Ahora se cre� la clase Expresion para que los criterios puedan ser m�s elaborados, de la forma ( X AND ( Y OR Z AND (NOT B) ) ) ....
	 *	Se deja este m�todo para que lo anterior sigo funcionando correctamente.
	 * Al momento de crear el filtro de b�squeda, si $this->filtros[] tuviese elementos, se generar� una expresi�n AND con los mismos.
	 *
	 * @param $campo campo a filtrar
	 * @param $valor valor por el cual filtrar el campo
	 * @param $operador operador para el filtrado.
	 * @param $format clase que le da formato al valor, por default ser� la identidad (format($value)=>$value).
	 * @return unknown_type
	 */
	public function addFiltro($campo, $valor, $operador, $format=null){

		if(empty($format))
		$format = new FormatValor();
		//$this->filtros[$campo] = array('operador' => $operador, 'valor' => $valor, 'format' => $format);
		$this->filtros[] = array('campo' => $campo, 'operador' => $operador, 'valor' => $valor, 'format' => $format);
	}
	public function addFiltroHaving($campo, $valor, $operador, $format=null){

		if(empty($format))
		$format = new FormatValor();
		$this->filtros_having[] = array('campo' => $campo, 'operador' => $operador, 'valor' => $valor, 'format' => $format);
	}

	/**
	 * se agrega un campo a evaluar 'por not null'.
	 * @param $campo
	 * @return unknown_type
	 */
	public function addNotNull($campo){
		$this->camposNotNull[] = $campo;
	}

	public function addNull($campo){
		$this->camposNull[] = $campo;
	}
	/**
	 * se agrega un campo para ordenar.
	 * @param $campo
	 * @param $valor ASC / DESC
	 * @return unknown_type
	 */
	public function addOrden($campo, $valor='ASC'){
		$this->camposOrden[$campo] = $valor;
	}

	public function addGroupBy($campo){
		$this->camposGroupBy[] = $campo;
	}
	/**
	 * retorna los valores a evaluar 'por not null'
	 * @return unknown_type
	 */
	public function getCamposNotNull(){
		return $this->camposNotNull;
	}

	public function getCamposNull(){
		return $this->camposNull;
	}
	/**
	 * retorna los filtros.
	 * @return unknown_type
	 */
	public function getFiltros(){
		return $this->filtros;
	}


	public function buildWHERE(){
		$where = '' ;

		//WHERE
		//foreach ($this->filtros as $campo => $operador_valor) {
		foreach ($this->filtros as $key => $campo_operador_valor) {
			$campo = $campo_operador_valor['campo'];
			$operador = $campo_operador_valor['operador'];
			$valor = $campo_operador_valor['valor'];
			$format = $campo_operador_valor['format'];
			$valor = $format->format($valor);
			$where .= " AND $campo $operador $valor";
		}

		foreach ($this->getCamposNotNull() as $campo) {
			$where .= " AND not ($campo is null OR $campo='') ";
		}
		foreach ($this->getCamposNull() as $campo) {
			$where .= " AND ($campo is null) ";
		}
		if( !FormatUtils::isEmpty( $this->oExpresion ) )
		$where .= " AND  " . $this->oExpresion->build() ;
			
		if(!empty($where)){
			$where =  substr( $where, 4); //le quitamos el primer AND
			$where = " WHERE " . $where;
		}

		return $where;
	}

	public function buildHAVING(){
		$having = '' ;
		//HAVING
		foreach ($this->filtros_having as $key => $campo_operador_valor) {
			$campo = $campo_operador_valor['campo'];
			$operador = $campo_operador_valor['operador'];
			$valor = $campo_operador_valor['valor'];
			$format = $campo_operador_valor['format'];
			$valor = $format->format($valor);
			$having .= " AND $campo $operador $valor";
		}
		if(!empty($having)){
			$having =  substr( $having, 4); //le quitamos el primer AND
			$having = " HAVING " . $having;
		}
		return $having;
	}


	public function buildORDERBY(){
		//ORDER BY
		$orden = '';
		foreach ($this->camposOrden  as $campo => $valor) {
			$orden = ", $campo $valor ";
		}
		if(!empty($orden)){
			$orden =  substr( $orden, 2); //le quitamos la primer coma
			$orden = " ORDER BY " . $orden;
		}

		return $orden;
	}

	public function buildGROUPBY(){
		//GROUP BY
		$group = '';
		foreach ($this->camposGroupBy  as $campo) {
			$group = ", $campo ";
		}
		if(!empty($group)){
			$group =  substr( $group, 2); //le quitamos la primer coma
			$group = " GROUP BY " . $group;
		}

		return $group;
	}


	public function buildLIMIT(){
		//PAGINACION
		$limit='';
		if(!empty($this->page)){
			$limitInf = (($this->page - 1) * $this->row_per_page);
			$limit .= " LIMIT $limitInf,$this->row_per_page";
		}

		return $limit;
	}

	/**
	 * se construye el filtro de b�squeda.
	 * @return unknown_type
	 */
	public function buildFiltro(){
		$filtro  = $this->buildWHERE();
		$filtro .= $this->buildGROUPBY();
		$filtro .= $this->buildHAVING();
		$filtro .= $this->buildORDERBY();
		$filtro .= $this->buildLIMIT();
		return $filtro;

	}

	/**
	 * se construye el filtro de b�squeda.
	 * @return unknown_type
	 */
	public function buildFiltroSinPaginar(){
		$filtro  = $this->buildWHERE();
		return $filtro;

	}


	public function getValorFiltro($campoBuscar){
		$valor = null;
		foreach ($this->filtros as $key => $campo_operador_valor) {
			$campo = $campo_operador_valor['campo'];
			if($campoBuscar==$campo)
			$valor = $campo_operador_valor['valor'];
		}
		return $valor;
	}

	public function setExpresion( Expresion $exp ){
		$this->oExpresion = $exp;
	}
}

?>