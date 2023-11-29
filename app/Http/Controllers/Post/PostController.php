<?php

namespace App\Http\Controllers\Post;

use App\Consts\DateFormat;
use App\Consts\Schema\DBPostFields;
use App\Http\Controllers\BaseController;
use App\Libs\QueryFields;
use App\Models\Post\PostModel;
use App\Models\User;
use App\Structs\Post\PostStruct;
use App\Structs\Struct;
use App\Structs\User\UserStruct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Uid\Ulid;

class PostController extends BaseController
{
    public function addPost(Request $request): JsonResponse
    {
        $rule = [
            'title'                  => 'required|between:3,100',
            'monthly_rent_cost'      => 'required|integer|min:1',
            'type'                   => 'required',
            'area'                   => 'required|numeric|min:1',
            'rental_status'          => 'required',
            'description'            => 'required',
            'address'                => 'required',
            'owner_name'             => 'required|between:3,100',
            'owner_phone_number'     => 'required|between:9,10',
            //            'image'                  => 'required|image|max:8196',
            //            'cover_image'            => 'required|between:3,100',
            'additional_information' => '',
        ];

        $message = [
//            'name.required'       => trans('v1/default.error_name_required'),
//            'name.between'        => trans('v1/default.error_name_between', [
//                'min' => 3,
//                'max' => 100
//            ]),
//            'description.between' => trans('v1/default.error_description_between', [
//                'min' => 3,
//                'max' => 10000
//            ]),
//            'image'               => trans('v1/default.error_image_format'),
//            'image.max'           => trans('v1/default.error_limited_upload', ['size' => 8]),
//            'location.required'   => trans('v1/default.error_location_required'),
//            'location.between'    => trans('v1/default.error_location_between', [
//                'min' => 3,
//                'max' => 1024
//            ]),
        ];

        $validator = $this->_validate($request, $rule, $message);

        if ($validator->errors()->count()) {
            $json = [
                'error' => firstError($validator->getMessageBag()->toArray())
            ];
        } else {
//            if ($request->file('image')) {
//                $image = doImage($request->file('image'), 960, 540);
//            }
            $data = [
                'id'                     => $image['id'] ?? Ulid::generate(),
                'user_id'                => $request->user()->getAttribute('id'),
                'created_at'             => now()->format(DateFormat::TIMESTAMP_DB),
                'title'                  => $request->input('title'),
                'monthly_rent_cost'      => $request->input('monthly_rent_cost'),
                'type'                   => $request->input('type'),
                'area'                   => $request->input('area'),
                'rental_status'          => $request->input('rental_status'),
                'description'            => $request->input('description'),
                'owner_name'             => $request->input('owner_name'),
                'owner_phone_number'     => $request->input('owner_phone_number'),
                'cover_image'            => $request->input('cover_image'),
                'image'                  => $image ?? null,
                'additional_information' => $request->input('additional_information') ?? null,
                'address'                => $request->input('address'),
            ];

            $diary_struct = new PostStruct($data);
            $data = normalizeToSQLViaArray($data, DBPostFields::POSTS);

            if ($data && PostModel::doAdd($data)) {
                $json = [
                    'data' => $diary_struct->toArray([
                        Struct::OPT_CHANGE => [
                            'image' => ['getImage']  // process image by function inside struct
                        ],
                    ]),
                    'code' => 200,
                ];

            } else {
                $json = [
                    'code'  => 200, //400,
                    'error' => [
                        'warning' => trans('v1/default.error_insert'),
                    ]
                ];
            }
        }

        return resJson($json);
    }

    public function getPosts(Request $request): JsonResponse
    {
        /**@var $post_struct PostStruct
         * @var $user_access UserStruct
         * @var $post PostModel
         * */
        $rule = [
            'sort'      => 'in:asc,desc',
            'sort_by'   => 'in:created_at,name,id,user_id',
            'search_by' => 'in:name',
        ];

        $message = [
            'sort_by'   => trans('v1/default.error_selected', ['field' => 'sort_by', 'option' => 'created_at,name,id,user_id']),
            'sort'      => trans('v1/default.error_selected', ['field' => 'sort', 'option' => 'asc, desc']),
            'search_by' => trans('v1/default.error_selected', ['field' => 'search_by', 'option' => 'name']),
        ];

        $validator = $this->_validate($request, $rule, $message);

        if ($validator->errors()->count()) {
            $json = [
                'error' => firstError($validator->getMessageBag()->toArray())
            ];
        } else {
            $fields_diary = new QueryFields($request, DBPostFields::POSTS);
            $filter_data = [
                'fields'    => $fields_diary->select,
                ...pageLimit($request),
                'user_id'   => $request->user()->getAttribute('id'),
                'sort_by'   => $request->input('sort_by') ?? null,
                'sort'      => $request->input('sort') ?? 'asc',
                'search_by' => $request->input('search_by') ?? null,
                'key'       => "%{$request->input('key')}%" ?? '%%',
            ];
            if ($query = PostModel::doGet($filter_data)) {
                foreach ($query as $diary) {
                    $diary_struct = $diary->struct();
                    $data[] = $diary_struct->toArray([
                        Struct::OPT_CHANGE => [
                            'image' => ['getImage']  // process image by function inside struct
                        ],
                    ]);
                }
            }

            $json = [
                'items' => $data ?? [''],
                '_meta' => ResMetaJson($query),
            ];
        }
        return resJson($json);
    }

    public function getPost(Request $request, string $id): JsonResponse
    {
        /**@var $post PostModel* */
        $fields_diary = new QueryFields($request, DBPostFields::POSTS);

        if ($post = PostModel::doGetById($id, $fields_diary->select)) {
            $json = [
                'data' => $post->struct()->toArray([
                    Struct::OPT_CHANGE => [
                        'image' => ['getImage']  // process image by function inside struct
                    ],
                ])
            ];

        } else {
            $json = [
                'code'  => 200, //400,
                'error' => [
                    'id|user_id' => trans('v1/default.error_id_exists')
                ]
            ];
        }

        return resJson($json);
    }

    protected function _validate(Request $request, ?array $rule = [], ?array $message = []): \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
    {
        $validator = Validator::make($request->all(), $rule, $message);
        if (!$validator->fails()) {
            $this->getUser($request);
            if (!$this->user instanceof User) {
                $validator->errors()->add('user', trans('v1/auth.error_username_not_exist'));
            }
        }

        return $validator;
    }
}
