<?php
spl_autoload_register(function ($class) {
    $prefix = 'erd\\';
    if (strpos($class, $prefix) === 0) {
        $class = substr($class, strlen($prefix));
    }
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Thử tìm file theo đúng cấu trúc thư mục lồng
    $file = __DIR__ . '/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    // Nếu không tồn tại, thử tìm trong thư mục con cùng tên (ví dụ: model\User\User.php)
    $parts = explode(DIRECTORY_SEPARATOR, $class);
    $last = array_pop($parts);
    $altFile = __DIR__ . '/' . implode(DIRECTORY_SEPARATOR, $parts) . DIRECTORY_SEPARATOR . $last . DIRECTORY_SEPARATOR . $last . '.php';
    if (file_exists($altFile)) {
        require_once $altFile;
        return;
    }

    // Nếu vẫn không tìm thấy, báo lỗi như cũ
    require_once $file;
});

include_once "router/main.php";
use erd\core\routing\RouteControl as RouteControl;
use erd\core\model\connector as Connector;
Connector::loadEnv(__DIR__ . '/.env');
RouteControl::dispatch();