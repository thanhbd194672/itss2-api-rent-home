<?php

namespace App\Structs\Post;

use App\Libs\Serializer\Normalize;
use App\Structs\Struct;
use Illuminate\Support\Carbon;

class PostStruct extends Struct
{
	public ?Carbon $updated_at;
	public ?int $monthly_rent_cost;
	public ?float $area;
	public ?float $rating;
	public ?object $image;
	public ?object $additional_infomation;
	public ?Carbon $created_at;
	public ?string $description;
	public ?string $cover_image;
	public ?string $owner_name;
	public ?string $user_id;
	public ?string $title;
	public ?string $owner_phone_number;
	public ?string $type;
	public ?string $id;
	public ?string $rent_status;
	public function __construct(object|array $data)
	{
		if (is_object($data)) {
			$data = $data->toArray();
		}

		$this->updated_at = Normalize::initCarbon($data, 'updated_at');
		$this->monthly_rent_cost = Normalize::initInt($data, 'monthly_rent_cost');
		$this->area = Normalize::initFloat($data, 'area');
		$this->rating = Normalize::initFloat($data, 'rating');
		$this->image = Normalize::initObject($data, 'image');
		$this->additional_infomation = Normalize::initObject($data, 'additional_infomation');
		$this->created_at = Normalize::initCarbon($data, 'created_at');
		$this->description = Normalize::initString($data, 'description');
		$this->cover_image = Normalize::initString($data, 'cover_image');
		$this->owner_name = Normalize::initString($data, 'owner_name');
		$this->user_id = Normalize::initString($data, 'user_id');
		$this->title = Normalize::initString($data, 'title');
		$this->owner_phone_number = Normalize::initString($data, 'owner_phone_number');
		$this->type = Normalize::initString($data, 'type');
		$this->id = Normalize::initString($data, 'id');
		$this->rent_status = Normalize::initString($data, 'rent_status');

	}
}