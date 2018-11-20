<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'              =>  'mongo',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'test',          // 数据库名
    'DB_USER'               =>  '',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '27017',        // 端口
	
	//redis配置
	 'DATA_CACHE_PREFIX' => 'Redis_',//缓存前缀
	 'DATA_CACHE_TYPE'=>'Redis',//默认动态缓存为Redis
	 'REDIS_RW_SEPARATE' => true, //Redis读写分离 true 开启
	 'REDIS_HOST'=>'127.0.0.1', //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
	 'REDIS_PORT'=>'6379',//端口号
	 'REDIS_TIMEOUT'=>'300',//超时时间
	 'REDIS_PERSISTENT'=>false,//是否长连接 false=短连接
	 'REDIS_AUTH'=>'',//AUTH认证密码
	
	//memcache配置
	// 'DATA_CACHE_PREFIX' => 'Memcache_',//缓存前缀
	// 'DATA_CACHE_TYPE'=>'Memcache',//默认动态缓存为Redis
	// 'REDIS_HOST'=>'127.0.0.1:11211', //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
	// //'REDIS_PORT'=>'11211',//端口号
	// 'DATA_CACHE_TIME' => '3600',//指定默认的缓存时长为3600 秒,没有会出错
);