<?php

namespace App\Consts\Schema;
use App\Consts\DbTypes;

abstract class DBPostFields
{
	const POSTS = [
		'updated_at' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'monthly_rent_cost' => [
			'type' => DbTypes::INT,
			'cache' => true,
		],
		'area' => [
			'type' => DbTypes::FLOAT,
			'cache' => true,
		],
		'rating' => [
			'type' => DbTypes::FLOAT,
			'cache' => true,
		],
		'image' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'additional_infomation' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'created_at' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'description' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'cover_image' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'owner_name' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'user_id' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'title' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'owner_phone_number' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'type' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'id' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'rent_status' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
	];
}