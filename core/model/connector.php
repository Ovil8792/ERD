<?php

namespace erd\core\model;

class connector
{

    // protected static $host;
    public static function conn(){
        $host= getenv("DB_HOST");
        $user= getenv("DB_USER");
        $pass= getenv("DB_PASS");
        $db= getenv("DB_NAME");
        //pdo connect
        try {
            $conn = new \PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }
    public static function loadEnv($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File .env không tồn tại: $filePath");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Bỏ qua comment
            if (strpos($line, '#') === 0) {
                continue;
            }

            // Phân tích dòng dạng KEY=VALUE
            $parts = explode('=', $line, 2);

            if (count($parts) == 2) {
                $name = trim($parts[0]);
                $value = trim($parts[1]);

                // Nếu có dấu ngoặc kép hoặc đơn thì loại bỏ
                if (
                    (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                    (str_starts_with($value, "'") && str_ends_with($value, "'"))
                ) {
                    $value = substr($value, 1, -1);
                }

                // Đặt biến môi trường (nếu chưa tồn tại)
                if (getenv($name) === false) {
                    putenv("$name=$value");
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }
}
