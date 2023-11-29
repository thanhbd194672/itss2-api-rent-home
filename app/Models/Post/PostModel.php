<?php

namespace App\Models\Post;

use App\Structs\Post\PostStruct;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostModel extends Model
{
    use HasFactory , HasUlids;
    protected $connection = "pgsql";
    protected $table      = "posts";

    public static function checkPostExist(string $id): bool
    {
        return self::query()
            ->where('id',$id)
            ->exists();
    }
    public static function doAdd(array $data): bool
    {
        return self::query()->insert($data);
    }

    public static function doGet(array $filter): LengthAwarePaginator|Collection
    {
        $query = self::query()
            ->orderBy($filter['sort_by'] ?? 'created_at', $filter['sort'] ?? 'desc')
            ->where(function ($query) use ($filter) {
                if ($filter['search_by']) {
                    $query->where($filter['search_by'], 'LIKE', $filter['key']);
                }
                $query->where('user_id', $filter['user_id']);
            });
        if (empty($filter['limit'])) {

            return $query->get($filter['fields']);
        } else {

            return $query->paginate($filter['limit'], $filter['fields'], "{$filter['page']}", $filter['page']);
        }
    }

    public static function doGetById(string $id, array $filter, ?string $ref = null): Model|Builder|null
    {
        return self::query()
            ->where(function ($query) use ($id, $ref) {
                $query->where('id', $id);
                if ($ref) {
                    $query->where('user_id', $ref);
                }
            })
            ->distinct()
            ->first($filter);
    }

//    public static function doEdit(array $data, PostModel $diary): bool
//    {
//        $diary->forceFill($data);
//
//        return $diary->save();
//
//    }

//    public static function doDelete(PostModel $diary):bool
//    {
//        $diary->forceFill(['status' => 0]);
//
//        return $diary->save();
//    }
    public function struct(): PostStruct
    {

        return new PostStruct($this->getAttributes());
    }


}
