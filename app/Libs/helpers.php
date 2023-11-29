<?php

use Illuminate\Http\JsonResponse;
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