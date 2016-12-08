<?php
return array(
	'LOG_RECORD' => true, // 开启日志记录
	'SHOW_PAGE_TRACE'=>true,

	'APP_GROUP_LIST'=>'Home,Admin',
	'DEFAULT_GROUP'=>'Home',

	'db_type'  => 'mysql',
	'db_name'  => 'zentao',
	'db_host'  => '192.168.92.177',
	'db_port'  => '3306',
	'db_prefix'=> 'zt_',
	'db_user'  => 'heyu',
	'db_pwd'   => 'root',
	'db_charset'=> 'utf8',
	'DB_ZT' => array(
		'db_type'  => 'mysql',
		'db_name'  => 'zentao',
		'db_host'  => '192.168.92.177',
		'db_port'  => '3306',
		'db_prefix'=> 'zt_',
		'db_user'  => 'heyu',
		'db_pwd'   => 'root',
		'db_charset'=> 'utf8',
	),
	'DATA_CACHE_TYPE'=>'Redis',
//	'MEMCACHE_HOST'=>'192.168.20.244:11211',
	'REDIS_HOST'=>'192.168.20.244:6379'
);
?>