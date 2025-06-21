<?php 

namespace erd\core\reg;

abstract class StaticReg{

    /**
     * Truyền dữ liệu vào mảng và đưa đến hàm khác
     *
     * @param mixed $key truyền key của mảng.
     * @param mixed $value truyền dữ liệu phần tử mảng.
     * @param array $arr truyền vào mảng muốn lưu.
     */
    abstract protected static function set($key, $value);
    /**
     * Lấy dữ liệu của mảng
     *
     * @param mixed $input truyền key của mảng.
     * @param array $arr truyền vào mảng muốn lấy dữ liệu.
     */
    abstract protected static function get($key);
}