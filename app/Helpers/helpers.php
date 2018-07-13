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
     * 返回json
     *
     * @param string $data            
     * @param
     *            $status
     * @var 10000 --- 成功
     * @var 1000x --- 参数错误或者其他逻辑错误
     * @var 20000 --- 成功但数据为空
     * @var 30000 --- 认证错误
     * @var 40000 --- 签名错误
     * @var 50000 ---非法操作
     *     
     *      单条数据返回格式：
     *      {
     *      "status": "10000",
     *      "message": "success",
     *      "data": {
     *      "info": {
     *     
     *      }
     *      }
     *      }
     *     
     *      多条数据返回格式
     *      {
     *      "status": "10000",
     *      "message": "success",
     *      "data": {
     *      "list": {
     *     
     *      }
     *      }
     *      }
     *      分页数据返回格式
     *      {
     *      "status": "10000",
     *      "message": "success",
     *      "data": {
     *      "pagination": {
     *      "total": 11,
     *      "count": 11,
     *      "per_page": 15,
     *      "current_page": 1,
     *      "total_pages": 1,
     *      },
     *      "list": {
     *     
     *      }
     *      }
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
