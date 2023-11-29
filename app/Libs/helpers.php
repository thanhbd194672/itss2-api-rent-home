<?php

use App\Consts\DbTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

function firstError(array $error): array
{
    $new = [];

    foreach ($error as $key => $item) {
        $new[$key] = $item[0];
    }

    return $new;
}
function rmArrayObjectByValue(array|object $arr, mixed $compare = [null, '']): array|object
{
    $is_object = is_object($arr);

    $data = [];

    foreach ((array)$arr as $key => $value) {
        if (is_array($value)) {
            if (!$value) {
                continue;
            }
            $data[$key] = rmArrayObjectByValue($value, $compare);
        } else {
            if (is_array($compare)) {
                if (in_array($value, $compare, true)) {
                    continue;
                }
            } else {
                if ($value === $compare) {
                    continue;
                }
            }

            $data[$key] = $value;
        }
    }

    if ($is_object) {
        return (object)$data;
    }

    return $data;
}

function normalizeToSQLViaArray(array $input, array $compare): array
{
    $data = [];

    foreach ($input as $key => $value) {
        if (!isset($compare[$key])) {
            continue;
        }

        if (!is_null($value)) {
            switch ($compare[$key]['type']) {
                case DbTypes::STRING:
                    if (!is_string($value)) {
                        $value = strval($value);
                    } else {
                        $value = trim($value);
                    }

                    break;
                case DbTypes::INT:
                    if (!is_int($value)) {
                        $value = intval($value);
                    }

                    break;
                case DbTypes::FLOAT:
                    if (!is_float($value)) {
                        $value = floatval($value);
                    }

                    break;
                case DbTypes::BOOL:
                    if (!is_bool($value)) {
                        if (is_string($value)) {
                            if ($value === 'true') {
                                $value = true;
                            } elseif ($value === '1') {
                                $value = true;
                            } elseif ($value === 'false') {
                                $value = false;
                            } elseif ($value === '0') {
                                $value = false;
                            } else {
                                $value = boolval($value);
                            }
                        } elseif (is_int($value)) {
                            if ($value === 1) {
                                $value = true;
                            } elseif ($value === 0) {
                                $value = false;
                            } else {
                                $value = boolval($value);
                            }
                        } elseif (is_array($value)) {
                            $value = count($value) > 0;
                        } else {
                            $value = boolval($value);
                        }
                    }

                    break;
                case DbTypes::JSON:
                    $value = formatJsonToSQL($value);

                    break;
            }
        }

        $data[$key] = $value;
    }

    return $data;
}

function formatJsonToSQL($value): string
{
    if (Str::isJson($value)) {
        return $value;
    }

    return json_encode($value && is_array($value) ? $value : []);
}

function resJson($data = [], bool $is_clear = true): JsonResponse
{
//    if (!is_array($data)) {
//        if (setting()->dataClient?->isEncrypt()) {
//            return response()->json(EDData::setData($data), SymfonyResponse::HTTP_OK);
//        } else {
//            return response()->json($data, SymfonyResponse::HTTP_OK);
//        }
//    }
    if (!is_array($data)) {
        return response()->json($data, SymfonyResponse::HTTP_OK);
    }

    if (isset($data['code'])) {
        $code = $data['code'];
    } else {
        $code = SymfonyResponse::HTTP_OK;

        $data['code'] = $code;
    }

    if (isset($data['error'])) {
        $success = false;
    } else {
        $success = true;
    }

    $data['success'] = $success;

    if ($is_clear) {
        $data = rmArrayObjectByValue($data);
    }

//    if (setting()->dataClient?->isEncrypt()) {
//        return response()->json(EDData::setData($data), $code);
//    } else {
//        return response()->json($data, $code);
//    }
    return response()->json($data, $code);
}

function pageLimit(Request $request): ?array
{
    if (!empty($request['limit'])) {
        return [
            'limit' => intval(trim($request->input('limit'), "'")),
            'page'  => intval(trim($request->input('page'), "'") ?? 1),
        ];
    } else {
        return [];
    }
}

function ResMetaJson(mixed $data): ?array
{
    if ($data instanceof LengthAwarePaginator) {

        return [
            'per_page'     => $data->perPage(),
            'total_count'  => $data->total(),
            'page_count'   => $data->lastPage(),
            'current_page' => $data->currentPage(),
            'next_page'    => ($data->lastPage() > $data->currentPage()) ? ($data->currentPage() + 1) : null
        ];
    } else {

        return null;
    }
}

//function doImage($image_file, $width, $height): ?array
//{
//    $ulid      = Ulid::generate();
//    $now       = $ulid->getDateTime();
//    $directory = cdn_sc_path_files($now->format('Y/m/d'));
//
//
//    $file      = $image_file;
//    $filename  = $file->getClientOriginalName();
//    $mime      = $file->getMimeType();
//    $extension = $file->getClientOriginalExtension();
//    $iid       = $ulid->toString();
//    $file->move($directory, "$iid.$extension");
//
//    ResImage::resize("{$now->format('Y/m/d')}/$iid.$extension", $width, $height);
//    $cache = [
//        "{$width}x$height",
//    ];
//
//    return [
//        'id'    => $iid,
//        'name'  => $filename,
//        'mime'  => $mime,
//        'ext'   => $extension,
//        'time'  => $now->format(DateFormat::TIMESTAMP_DB),
//        'cache' => $cache,
//    ];
//}