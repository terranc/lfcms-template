<?php

namespace App\Traits;
use Illuminate\Support\Facades\Request;


/**
 * Class JsonResponseTrait
 * @package App\Traits
 */
trait JsonResponseTrait {

    private $redirect_url;

    /**
     * @param int    $code
     * @param string $message
     * @param null   $data
     *
     * @return array
     */
    protected function apiArray($code = 200, $message = '', $data = null) {
        if (is_array($code)) {
            $res = [
                'code' => $code['code'],
                'message' => $code['message'],
                'data' => $code['data'],
            ];
        } else {
            $res = [
                'code' => $code,
                'message' => $message,
                'data' => $data,
            ];
        }
        return $res;
    }


    /**
     * @param int $code
     * @param string $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     * 返回值规范说明:
     * 1、成功正数（多种成功情况，不同的正数数字标示,原则上是不样的message对应不同的code）
     * 2、报错、失败、异常负数（返回数据集，但数据集为[]或null，不属于报错、失败、异常，所以视为成功，仅仅暂无数据而已）
     * 3、404、403、500等http status code可以均直接加上`-`号(如:-404),作为错误code,方便大家一目了然
     */
    protected function apiResponse($code = 200, $message = '', $data = null) {
        $res = $this->apiArray($code, $message, $data);
        if ($this->redirect_url) {
            $res['redirect_url'] = $this->redirect_url;
        }
        return \Response::jsonp(request()->callback, $res)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * 设置 data.url 的值
     * @param       $url
     * @param array $param
     *
     * @return $this
     */
    protected function redirectUrl($url, $param=[]) {
        $this->redirect_url = url($url, $param);
        return $this;
    }

    /**
     * apiResponse的快捷方式-没找到
     * @param int    $code
     * @param string $message
     * @param null   $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function apiResponseNotFound($code = -404, $message = '没找到', $data = null) {
        return $this->apiResponse($code, $message, $data);
    }

    /**
     * piResponse的快捷方式-数据库错误
     * @param int    $code
     * @param string $message
     * @param null   $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function apiResponseDBError($code = -501, $message = 'data base error', $data = null) {
        return $this->apiResponse($code, $message, $data);
    }

    /**
     * apiResponse的快捷方式-系统错误
     * @param int    $code
     * @param string $message
     * @param null   $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function apiResponseSyStemError($code = -500, $message = 'system error', $data = null) {
        return $this->apiResponse($code, $message, $data);
    }
}
