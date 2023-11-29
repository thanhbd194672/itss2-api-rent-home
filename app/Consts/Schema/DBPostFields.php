<?php

namespace App\Consts\Schema;
use App\Consts\DbTypes;

abstract class DBPostFields
{
	const POSTS = [
		'image' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'monthly_rent_cost' => [
			'type' => DbTypes::INT,
			'cache' => true,
		],
		'additional_information' => [
			'type' => DbTypes::JSON,
			'cache' => true,
		],
		'created_at' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'updated_at' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'area' => [
			'type' => DbTypes::FLOAT,
			'cache' => true,
		],
		'owner_name' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'owner_phone_number' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'cover_image' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'id' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'address' => [
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
		'type' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'rental_status' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
		'description' => [
			'type' => DbTypes::STRING,
			'cache' => true,
		],
	];
}