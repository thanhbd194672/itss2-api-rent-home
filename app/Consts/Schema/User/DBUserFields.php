<?php

namespace App\Consts\Schema;
use App\Consts\DbTypes;

abstract class DBUserFields
{
	const USERS = [
		'id' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'name' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'username' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'password' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'avatar' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'school_name' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'student_id' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
	];
}