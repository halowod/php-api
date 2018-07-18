<?php


if (! function_exists('pretty_print')) {
    /**
     * 浏览器友好
     *
     * @param string $arr
     *
     * @return 格式化 print_r
     */
    function pretty_print($arr)
    {
        echo '<pre>';
        print_r($arr);
        die;
    }
}

if (! function_exists('msg')) {
    /**
     * 输出
     */
    function msg($status, $message = 'success', $data = null)
    {
        if (is_array($data) || is_object($data)) {
            $datas = $data;
        } else {
            if (! $data)
                $datas = NULL;
            else
                $datas = array(
                    $data
                );
        }
        
        $array = array(
            'status' => "{$status}",
            'message' => $message,
            'data' => $datas
        );
        header("Content-type: application/json");
        exit(json_encode($array, JSON_UNESCAPED_UNICODE));
    }
}
