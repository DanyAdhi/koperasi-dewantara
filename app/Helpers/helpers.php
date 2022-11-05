<?php

    use PhpAnsiColor\Color;
    use Illuminate\Support\Facades\DB;

    function responseJson($success=false, $message='', $code=500){
        return response()->json([
            'success'  => $success,
            'message'   => $message,
            'code'      => $code,
        ], $code);
    };

    function responseDataJson($success=false, $message='', $data='', $code=500){
        return response()->json([
            'success'   => $success,
            'message'   => $message,
            'code'      => $code,
            'data'      => $data
        ], $code);
    };

    function responseDataPaginationJson($success=false, $message='', $data='', $meta='', $code=500){
        return response()->json([
            'success'   => $success,
            'message'   => $message,
            'code'      => $code,
            'data'      => $data,
            'meta'      => $meta,
        ], $code);
    };

    function getMeta($table, $where){
        $totalData = DB::table($table)
                    ->where($where)
                    ->count();
        return $totalData;
    
    };

    function logData ($context, $message, $code){
        if($code >= 500){
            $color = "red";
        }else if($code >= 400){
            $color = "yellow";
        }else if($code >= 300){
            $color = "cyan";
        }else if($code >=200){
            $color = "green";
        }

        error_log(Color::set($context, "white").", ".Color::set($message, "magenta+italic")." ".Color::set($code, $color) );

    }

?>