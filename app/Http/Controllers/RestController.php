<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestController extends Controller
{
    public function response($data, $msg = '')
    {
        $res = [
            'success' => true,
            'data' => $data,
            'msg' => $msg
        ];

        return response()->json($res, 200);
    }

    public function error($error, $msgs = [], $code = 404)
    {
        $res = [
            'success' => false,
            'msg' => $error
        ];

        if (!empty($msgs)) {
            $res['data'] = $msgs;
        }

        return response()->json($response, $code);
    }
}
