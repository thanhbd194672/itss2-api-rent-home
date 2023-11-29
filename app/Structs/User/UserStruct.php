<?php

namespace App\Structs\User;

use App\Libs\Serializer\Normalize;
use App\Structs\Struct;
use Illuminate\Support\Carbon;

class UserStruct extends Struct
{
	public ?string $id;
	public ?string $name;
	public ?string $username;
	public ?string $password;
	public ?string $avatar;
	public ?string $school_name;
	public ?string $student_id;
	public function __construct(object|array $data)
	{
		if (is_object($data)) {
			$data = $data->toArray();
		}

		$this->id = Normalize::initString($data, 'id');
		$this->name = Normalize::initString($data, 'name');
		$this->username = Normalize::initString($data, 'username');
		$this->password = Normalize::initString($data, 'password');
		$this->avatar = Normalize::initString($data, 'avatar');
		$this->school_name = Normalize::initString($data, 'school_name');
		$this->student_id = Normalize::initString($data, 'student_id');

	}
}