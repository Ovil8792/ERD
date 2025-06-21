<?php 

namespace erd\core\model;

class db extends \erd\core\model\connector{
        protected $table;
        protected static $conn;
    protected $where = [];
    public function __construct($tableName) {
        $this->table = $tableName;
        self::$conn = parent::conn();
    }

    public function table($tableName) {
        $this->table = $tableName;
        return $this;
    }

    public function where($column, $value) {
        $this->where[] = "$column = '$value'";
        return $this;
    }
    public function get() {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(" AND ", $this->where);
        }
        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        // Giải thích:
        // $sql: Chuỗi SQL để lấy dữ liệu từ bảng.
        //implode(" AND ", $this->where): Nối các điều kiện trong mảng $where thành một chuỗi, ngăn cách bằng " AND ".
        // Nếu mảng $where không rỗng, thêm phần WHERE vào câu lệnh SQL.
    }
    public function first() {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(" AND ", $this->where);
        }
        $sql .= " LIMIT 1"; // Giới hạn kết quả chỉ lấy một bản ghi đầu tiên
        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
        // Giải thích:
        // LIMIT 1: Chỉ lấy một bản ghi đầu tiên từ kết quả truy vấn.
    }
    public function getCustom($orderby=[]){
        //custom with where and $orderby
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(" AND ", $this->where);
        }
        if (!empty($orderby)||$orderby !== []) {
            $sql .= " ORDER BY " . implode(", ", $orderby);
        }  
        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        // Giải thích:
        // $orderby: Mảng chứa các cột để sắp xếp kết quả.
        //implode(", ", $orderby): Nối các phần tử trong mảng $orderby thành một chuỗi, ngăn cách bằng dấu phẩy.
        // Nếu mảng $orderby không rỗng, thêm phần ORDER BY vào câu lệnh SQL.
        // Nếu mảng $where không rỗng, thêm phần WHERE vào câu lệnh SQL.
        //cách dùng ở model:
        // $model = new db("name_of_table");
        // $model->table('users')->where('status', 'active')->getCustom(['name ASC', 'created_at DESC']);
    }

    public function update(array $data) {
        $set = [];
        foreach ($data as $key => $val) {
            $set[] = "$key = '$val'";
        }

        $sql = "UPDATE {$this->table} SET " . implode(", ", $set);
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(" AND ", $this->where);
        }
        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount(); // Trả về số lượng bản ghi đã cập nhật
        //explain:
        // $set: Mảng chứa các cặp khóa-giá trị để cập nhật.
        //foreach ($data as $key => $val): Duyệt qua từng cặp khóa-giá trị trong mảng $data.
        //implode(", ", $set): Nối các phần tử trong mảng $set thành một chuỗi, ngăn cách bằng dấu phẩy.
        //if (!empty($this->where)): Kiểm tra xem mảng $where có chứa điều kiện hay không.
        //implode(" AND ", $this->where): Nối các điều kiện trong mảng $where thành một chuỗi, ngăn cách bằng " AND ".
        // $sql: Chuỗi SQL hoàn chỉnh để thực hiện cập nhật.
        // Thực thi bằng PDO thật

    }
    public function create(array $data) {
        $columns = implode(", ", array_keys($data));
        $values = implode("', '", array_values($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ('$values')";
        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return self::$conn->lastInsertId(); // Trả về ID của bản ghi mới được chèn
        // Giải thích:
        // $columns: Chuỗi chứa tên các cột, được lấy từ mảng $data.
        // array_keys($data): Lấy tất cả các khóa (tên cột) từ mảng $data.
        // $values: Chuỗi chứa các giá trị tương ứng với các cột, được lấy từ mảng $data.
        // array_values($data): Lấy tất cả các giá trị từ mảng $data.
        // implode(", ", ...): Nối các phần tử trong mảng thành một chuỗi, ngăn cách bằng dấu phẩy.
        // $sql: Chuỗi SQL hoàn chỉnh để thực hiện chèn dữ liệu vào bảng.
    }
    public function delete(int $id) {
        $sql = "DELETE FROM {$this->table} WHERE id = $id";
        self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount(); // Trả về số lượng bản ghi đã xóa
        // Giải thích:
        // $sql: Chuỗi SQL để xóa bản ghi có ID tương ứng.
        // self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION): Thiết lập chế độ báo lỗi cho PDO.
        // $stmt = self::$conn->prepare($sql): Chuẩn bị câu lệnh SQL để thực thi.
        // $stmt->execute(): Thực thi câu lệnh SQL.
        // $stmt->rowCount(): Trả về số lượng bản ghi đã bị xóa.
    }
}