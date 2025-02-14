<?php

namespace App\Helpers;

class Redirect
{
    protected $url;
    protected $params = [];
    protected $status = 302;

    /**
     * Khởi tạo đối tượng Redirect với URL.
     *
     * @param string $url
     * @return Redirect
     */
    public static function to($url)
    {
        $instance = new self();
        $instance->url = $url;
        return $instance;
    }

    // /**
    //  * Thêm dữ liệu thông điệp vào URL (với method chaining).
    //  *
    //  * @param string $message
    //  * @param string $status
    //  * @return Redirect
    //  */
    // public function message($message, $status = 'success')
    // {
    //     // Thêm các tham số vào URL
    //     $this->params['msg'] = urlencode($message);
    //     $this->params['status'] = urlencode($status);
    //     return $this; // Cho phép gọi tiếp các phương thức
    // }


    /**
     * Thêm thông báo và trạng thái vào session.
     */
    public function message($status = 'success', $message)
    {
        // Thêm các tham số vào URL
        \session_put($status, $message);
        return $this; // Cho phép gọi tiếp các phương thức
    }

    /**
     * Thực hiện redirect tới URL với trạng thái HTTP.
     *
     * @param int $status
     */
    public function send($status = null)
    {
        $this->status = $status ?: $this->status;

        // Xử lý việc thêm query string vào URL nếu có tham số
        if (!empty($this->params)) {
            $queryString = http_build_query($this->params);
            $this->url .= '?' . $queryString;
        }

        http_response_code($this->status);
        header("Location: $this->url");
        exit;
    }

    /**
     * Redirect back to the previous URL with message and status (optional).
     *
     * @param string $message
     * @param string $status
     * @param int $httpStatus
     */
    public static function back($message = null, $status = 'success', $httpStatus = 302)
    {
        $previousUrl = $_SERVER['HTTP_REFERER'] ?? '/';

        // if ($message) {
        //     $params = [
        //         'msg' => urlencode($message),
        //         'status' => urlencode($status)
        //     ];
        //     $previousUrl .= '?' . http_build_query($params);
        // }

        \session_put($status, $message);

        self::to($previousUrl)->send($httpStatus);
    }

    /**
     * Lấy thông báo và trạng thái từ URL.
     *
     * @return array|null
     */
    public static function getMessageFromUrl()
    {
        if (isset($_GET['msg']) && isset($_GET['status'])) {
            return [
                'msg' => urldecode($_GET['msg']),
                'status' => urldecode($_GET['status'])
            ];
        }

        // Nếu không có thông điệp, trả về null
        return null;
    }
}
