<?php

namespace App\Structs\Post;

use App\Libs\Serializer\Normalize;
use App\Structs\Struct;
use Illuminate\Support\Carbon;

class PostStruct extends Struct
{
    public ?object $image;
    public ?int    $monthly_rent_cost;
    public ?object $additional_information;
    public ?Carbon $created_at;
    public ?Carbon $updated_at;
    public ?float  $area;
    public ?string $owner_name;
    public ?string $owner_phone_number;
    public ?string $cover_image;
    public ?string $id;
    public ?string $address;
    public ?string $user_id;
    public ?string $title;
    public ?string $type;
    public ?string $rental_status;
    public ?string $description;

    public function __construct(object|array $data)
    {
        if (is_object($data)) {
            $data = $data->toArray();
        }

        $this->image = Normalize::initObject($data, 'image');
        $this->monthly_rent_cost = Normalize::initInt($data, 'monthly_rent_cost');
        $this->additional_information = Normalize::initObject($data, 'additional_information');
        $this->created_at = Normalize::initCarbon($data, 'created_at');
        $this->updated_at = Normalize::initCarbon($data, 'updated_at');
        $this->area = Normalize::initFloat($data, 'area');
        $this->owner_name = Normalize::initString($data, 'owner_name');
        $this->owner_phone_number = Normalize::initString($data, 'owner_phone_number');
        $this->cover_image = Normalize::initString($data, 'cover_image');
        $this->id = Normalize::initString($data, 'id');
        $this->address = Normalize::initString($data, 'address');
        $this->user_id = Normalize::initString($data, 'user_id');
        $this->title = Normalize::initString($data, 'title');
        $this->type = Normalize::initString($data, 'type');
        $this->rental_status = Normalize::initString($data, 'rental_status');
        $this->description = Normalize::initString($data, 'description');

    }
}