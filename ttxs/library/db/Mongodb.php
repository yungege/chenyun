<?php
/**
 * mongodb 简单 封装
 * @author 422909231@qq.com
 */
class Db_Mongodb {
    
    protected $host     = 'localhost';
    protected $port     = '27017';
    protected $db       = '';
    protected $table    = '';
    protected $user     = '';
    protected $pwd      = '';

	protected $pk		= '_id'; // 主键
	
    protected static $instance   = []; // 实例对象数组
    protected $connection = [];
    
	protected $manager = null;

    protected $fields = [];
    protected $updateFields = [];

    protected static $op = [
        '$inc',
    ];

    /**
     * 禁止外部克隆
     * @return [type]
     */
    protected function __clone() {

    }

    /**
     * 构造
     */
    protected function __construct() {
        try{
            if(!extension_loaded('mongodb')) {
                self::log('mongodb extension not install.');
                throw new Exception('mongodb extension not install.');
            }

            self::parseConfig();

            if(!isset($this->$connection[$this->host][$this->port])){
                self::connect();
            }

            $this->manager = $this->connection[$this->host][$this->port];   
        } catch (Exception $e) {
            self::log($e->getMessage());
        }
    }

    /**
     * 解析 mongo 配置
     * @return [type]
     */
    private function parseConfig (){
        $config = Yaf_Registry::get('mongodb')['master'];

        if (!empty($config)) {
            $this->host = $config['server'];
            $this->port = $config['port'];
            $this->db   = $config['database'];
            $this->user = $config['user'];
            $this->pwd  = $config['password'];
        }
        else {
            throw new Exception('Mongo config file not exists.');
        }
    }

    /**
     * 链接数据库
     * @return [type]
     */
    private function connect (){
		$uri = "mongodb://{$this->user}:{$this->pwd}@{$this->host}:{$this->port}/{$this->db}";
		$this->connection[$this->host][$this->port] = new MongoDB\Driver\Manager($uri);
    }

    /**
     * 查询数据
     * @param  array  $filter  条件 $filter = ['x' => ['$gt' => 1]];
     * @param  array  $options 额外参数 
     * $options = [
     *    'projection' => ['_id' => 0],
     *    'limit' => 5
     *    'sort' => ['x' => -1],
     * ];
     * @return array           [description]
     */
	public function query(array $filter, $options = ['limit'=>1]){
		$list = [];

		if(isset($filter[$this->pk])){
            if(!is_array($filter[$this->pk])){
                $oid = $this->makeObjectId($filter[$this->pk]);
                if(false === $oid)
                    return [];
                $filter[$this->pk] = $oid;
            }
            else{
                foreach ($filter[$this->pk] as $key => $row) {
                    if(!is_array($row)){
                        $oid = $this->makeObjectId($filter[$this->pk]);
                        if(false !== $oid)
                            $filter[$this->pk][$key] = $oid;
                    }
                    else{
                        $oids = [];
                        foreach ($row as $_id) {
                            $oid = $this->makeObjectId($_id);
                            if(false !== $oid)
                                $oids[] = $oid;
                        }
                        if(!empty($oids))
                            $filter[$this->pk][$key] = $oids;
                    }
                }
            }
        }

		$query = new MongoDB\Driver\Query($filter, $options);
        // print_r($query);
		$cursor = $this->manager
            ->executeQuery("{$this->db}.{$this->table}", $query)
            ->toArray();

		foreach ($cursor as $document) {
			$itemArr = Tools::object_array($document);
			if(isset($itemArr[$this->pk])){
				$itemArr[$this->pk] = $itemArr[$this->pk]['oid'];
			}
			$list[] = $itemArr;
		}
		
		return $list;	
	}

    public function queryOne(array $filter, $options = []){
        if(empty($options) || !isset($options['limit']) || $options['limit'] != 1){
            $options['limit'] = 1;
        }

        return (array)$this->query($filter, $options)[0];
    }

	/**
     * 更新数据
     * @param  array  $match    ['x' => 2],
     * @param  array  $update   修改字段 ['username' => 'cc','job' => 'IT']
     *                          ['$inc' => ['num' => 10, 'age' => -12]]
     * @param  array  $options  可选参数  
     * 'multi' => true, 'upsert'=>false
     * upsert 如果不存在update的记录，是否插入objNew,true为插入,默认是false，不插入
     * multi  默认是false,只更新找到的第一条记录，如果这个参数为true,就把按条件查出来多条记录全部更新
     * ['multi' => false, 'upsert' => false]
     */
    public function update(array $match, array $update, $options = ['multi' => true, 'upsert'=>false]){
        if(empty($match) || empty($update))
            throw new Exception('Not safe for none match or update fields');

		if(isset($match[$this->pk])){
			$oid = $this->makeObjectId($match[$this->pk]);
            if(false === $oid)
                return false;
            $match[$this->pk] = $oid;
        }

		// 字段过滤
        foreach ($update as $field => $val) {
            if($flag = in_array($field, self::$op))
                continue;

            if(!isset($this->fields[$field]))
                unset($update[$field]);
        }

        if(empty($update))
            throw new Exception('Not safe for none match or update fields');

		$bulk = new MongoDB\Driver\BulkWrite;

        if($flag === true){
            $bulk->update($match, $update, $options);
        }
        else{
            $bulk->update($match, ['$set' => $update], $options);
        }
 
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $result = $this->manager->executeBulkWrite("{$this->db}.{$this->table}", $bulk, $writeConcern);

        $isSuccess = $result->getModifiedCount();
        
		return (bool) $isSuccess;
    }

	/**
     * 插入数据
     * @param  array  $arr 插入的数据 ['username' => 'cc','job' => 'IT']
     * @return bool
     */
    public function insert(array $arr){
        if(empty($arr))
            throw new Exception('Insert data is empty.');

        $bulk = new MongoDB\Driver\BulkWrite; // bulk

        if(empty($this->fields))
            throw new Exception('Please defiend the fields first.');

        // 字段过滤
        $newFields = [];
        foreach ($this->fields as $field => &$defaultVal) {
            if(isset($arr[$field]))
                $defaultVal = $arr[$field];
        }
        $newFields = $this->fields;
        
		$_id = Tools::object_array($bulk->insert($newFields))['oid'];
        // WriteConcern 
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $result = $this->manager->executeBulkWrite("{$this->db}.{$this->table}", $bulk, $writeConcern);
		// 获取本次成功插入条数
		$isSuccess = (bool) $result->getInsertedCount();
		return $isSuccess === true ? $_id : false;  
    }

	// limit 为 1 时，删除第一条匹配数据, 为 0时，删除所有匹配数据 默认 全部删除
    

    /**
     * 删除数据
     * @param  array  $match   匹配条件 参考查询、修改匹配条件语法
     * @param  array  $options limit 为0 只删除符合条件的一条数据，为1全部删除
     * @return [type]          [description]
     */
    public function delete(array $match, $options = ['limit'=>0]){
		if(empty($match))
            throw new Exception('Not safe for none match fields');

        if(isset($options['limit']) && !in_array($options['limit'], [0,1]))
            throw new Exception('Invalid limit option.');

        if(isset($match[$this->pk])){
            $oid = $this->makeObjectId($match[$this->pk]);
            if(false === $oid)
                return false;
            $match[$this->pk] = $oid;
        }

		$bulk = new MongoDB\Driver\BulkWrite;
		$bulk->delete($match, $options);

		$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
	
		$result = $this->manager->executeBulkWrite("{$this->db}.{$this->table}", $bulk, $writeConcern);
		$isSuccess = $result->getDeletedCount();

		return (bool)$isSuccess;
    }

    /**
     * 查询记录总量
     * @Author    422909231@qq.com
     * @DateTime  2017-04-10
     * @copyright [copyright]
     * @param     array            $match
     * @return    int
     */
    public function count($match = []){
        $cmd = [
            'count' => $this->table,
            'query' => $match
        ];
        $cursor = $this->execute($cmd);
        $info = $cursor->toArray();
        $count = $info[0]->n;
        return $count;
    }

    /**
     * 聚合
     * 聚合计算 mongodb拓展 与 mongo 拓展语法稍有不同, aggregate pipeline cursor 三个参数参入 
     * executeCommand，其中pipeline 为聚合语法，与mongo拓展一致，
     * 参考 http://php.net/manual/en/mongodb-driver-manager.executecommand.php，只做简单封装
     * @param  array  $pipeline 聚合语法
     * @param  string $table    table name
     * @return array
     */
	public function aggregate($pipeline = [], $table = ''){
		if(empty($pipeline))
			return [];

		$cmd = [
			'aggregate' => $table ? : $this->table,
			'pipeline' => $pipeline,
			'cursor' => new stdClass,
		];

		$cursor = $this->execute($cmd);
		
		foreach ($cursor as $document) {
            $itemArr = Tools::object_array($document);
            if(isset($itemArr[$this->pk]['oid'])){
                $itemArr[$this->pk] = $itemArr[$this->pk]['oid'];
            }
            $list[] = $itemArr;
        }
        
		return $list;
	}

	// map reduce
	public function mapReduce(){}

    /**
     * 生成 ObjectId
     * @Author    422909231@qq.com
     * @DateTime  2017-04-12
     * @copyright [copyright]
     * @param     string           $_id [description]
     * @return    [type]                [description]
     */
	public function makeObjectId($_id = ''){
        try{
            $oid = new MongoDB\BSON\ObjectID($_id);
        }
		catch (Exception $e){
            $oid = false;
        }

        return $oid;
	} 
    
	// 原生语句执行
	protected function execute(array $cmd) {
        $cmd = new MongoDB\Driver\Command($cmd);
        return $this->manager->executeCommand($this->db, $cmd);
    }

    /**
     * @Author    422909231@qq.com
     * @DateTime  2017-04-11
     * @copyright [copyright]
     * @param     array           $fields 需要过滤的字段
     * @return    array                   [description]
     */
    protected function filterFields($fields){
        if(empty($fields))
            return [];

        $newFields = [];
        foreach ($fields as $key => $field) {
            if($field == '_id'){
                $newFields[$field] = 1;
                continue;
            }

            if(isset($this->fields[$field]))
                $newFields[$field] = 1;
        }

        return $newFields;
    }

    /**
     * 日志记录
     * @param  string $msg [description]
     * @return [type]      [description]
     */
    protected static function log($msg = '') {
        $file = 'mongodb_error';
        $line = '===================' . date('Y-m-d H:i:s') . '===================';
        Log::writeLog($file, $line, '');
        Log::writeLog($file, 'Info', $msg);
    } 
    
}
