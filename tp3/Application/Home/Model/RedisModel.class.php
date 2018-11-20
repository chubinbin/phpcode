<?php
namespace Home\Model;
use Think\Cache;


Class RedisModel extends MongoModel {
    
	protected $_idType = self::TYPE_INT;
    protected $_autoinc =  true;
	
	protected $connection       =   'mongo://localhost';  //这里跟前一篇使用 MongoClient 连接 MongoDB 的格式一样，注意后面一定要是 admin
    protected $tableName        =   'test'; 
//在这里指定要操作的表
    protected $dbName           =   'test';
//这里指定数据库的名字
}