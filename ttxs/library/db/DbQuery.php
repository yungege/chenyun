<?php

class Db_DbQuery {
	protected $query = array(
		'select' => '',
		'from' => '',
		'join' => '',
		'where' => '',
		'group' => array(),
		'having' => array(),
		'order' => '',
		'limit' => array('offset' => 0, 'limit' => 0),
	);

	public function select($fields) {
		if(is_array($fields) && !empty($fields))
			$this->query['select'] = implode(', ', $fields);
		else if($fields)
			$this->query['select'] = $fields;
		return $this;
	}

	public function from($table) {
		if ($table){
			$this->query['from'] = $table;
		}
		return $this;
	}

	public function join($join) {
		if ($join)
			$this->query['join'] = $join;
		return $this;
	}

	public function leftJoin($table, $alias = null, $on = null) {

		return $this->join('LEFT JOIN `' . bqSQL($table) . '`' . ($alias ? ' `' . pSQL($alias) . '`' : '') . ($on ? ' ON ' . $on : ''));
	}

	public function innerJoin($table, $alias = null, $on = null) {
		return $this->join('INNER JOIN `' . bqSQL($table) . '`' . ($alias ? ' ' . pSQL($alias) : '') . ($on ? ' ON ' . $on : ''));
	}

	public function leftOuterJoin($table, $alias = null, $on = null) {
		return $this->join('LEFT OUTER JOIN `' . bqSQL($table) . '`' . ($alias ? ' ' . pSQL($alias) : '') . ($on ? ' ON ' . $on : ''));
	}

	public function naturalJoin($table, $alias = null) {
		return $this->join('NATURAL JOIN `' . bqSQL($table) . '`' . ($alias ? ' ' . pSQL($alias) : ''));
	}

	public function where($restriction) {
		if (!empty($restriction))
			$this->query['where'] = $restriction;

		return $this;
	}

	public function having($restriction) {
		if (!empty($restriction))
			$this->query['having'][] = $restriction;

		return $this;
	}

	public function orderBy($fields) {
		if (!empty($fields))
			$this->query['order'] = $fields;

		return $this;
	}

	public function groupBy($fields) {
		if (!empty($fields))
			$this->query['group'][] = $fields;

		return $this;
	}

	public function limit($limit, $offset = 0) {
		$offset = (int)$offset;
		if ($offset < 0)
			$offset = 0;

		$this->query['limit'] = array(
				'offset' => $offset,
				'limit' => (int)$limit,
		);

		return $this;
	}

	public function build() {

		$sql = 'SELECT ' . ((($this->query['select'])) ? $this->query['select'] : '*') . "\n";

		if (!$this->query['from'])
			die('Db_DbQuery->build() missing from clause');
		$sql .= 'FROM ' . $this->query['from'] . "\n";

		if ($this->query['join'])
			// $sql .= implode("\n", $this->query['join']) . "\n";
			$sql .= $this->query['join'] . "\n";
		if ($this->query['where'])
			// $sql .= 'WHERE (' . implode(') AND (', $this->query['where']) . ")\n";
			$sql .= 'WHERE (' . $this->query['where'] . ")\n";

		if ($this->query['group'])
			$sql .= 'GROUP BY ' . implode(', ', $this->query['group']) . "\n";

		if ($this->query['having'])
			$sql .= 'HAVING (' . implode(') AND (', $this->query['having']) . ")\n";

		if ($this->query['order'])
			// $sql .= 'ORDER BY ' . implode(', ', $this->query['order']) . "\n";
			$sql .= 'ORDER BY ' . $this->query['order'] . "\n";

		if ($this->query['limit']['limit'])
		{
			$limit = $this->query['limit'];
			$sql .= 'LIMIT ' . (($limit['offset']) ? $limit['offset'] . ', ' . $limit['limit'] : $limit['limit']);
		}
	    //echo $sql."<br/>";
        //exit;
		return $sql;
	}

	public function flushBuild(){
		$this->query['select'] = '';
		$this->query['from']   = '';
		$this->query['join']   = '';
		$this->query['where']  = '';
		$this->query['group']  = array();
		$this->query['having'] = array();
		$this->query['order']  = '';
		$this->query['limit']  = array('offset' => 0, 'limit' => 0);
	}

	public function __toString() {
		return $this->build();
	}
}

