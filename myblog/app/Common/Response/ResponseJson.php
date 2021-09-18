<?php


namespace App\Common\Response;


trait ResponseJson
{
    /**
     * 传错误码数组返回
     * @param $error_arr
     * @param string $ext
     * @return mixed
     */
    public function responseError($error_arr, $ext='')
    {
        $code = $error_arr[0];
        $message = $ext != '' ? $error_arr[1] . '(' . $ext . ')' : $error_arr[1];

        return $this->jsonData($code, $message);
    }

    /**
     * 接口请求成功时返回
     * @param array $data
     * @return mixed
     */
    public function responseSuccess($data = [])
    {
        return $this->jsonResponse(0, 'ok', $data);
    }

    /**
     * 接口业务异常时返回
     * @param $code
     * @param $message
     * @param array $data
     * @return mixed
     */
    public function jsonData($code, $message, $data = [])
    {
        return $this->jsonResponse($code, $message, $data);
    }

    /**
     * 返回一个json
     * @param $code
     * @param $message
     * @param $data
     * @return mixed
     */
    public function jsonResponse($code, $message, $data)
    {
        $content = [
            'code' => $code,
            'msg' => $message,
            'data' => $data,
        ];

        return response()->json($content);
    }
}