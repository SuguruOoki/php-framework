<?php 

require_once(__DIR__ . '/../db/DbConnector.php');

/**
 * BaseModel
 * 継承して利用する
 */
class BaseModel
{
    public function __call($method_name, $method_argument) {
        $column = '';
        
        if (strpos($method_name, 'findBy') === 0) {
            $column = lcfirst(substr($method_name, 6)); // findBy以降のcolumnを切取して最初を小文字に。
        }
        
        $this->findBy($column, $method_argument[0]);
    }
    
    /**
     * マジックメソッド
     * 基本的にはfindByIdのような形で呼ばれることを前提とする。
     *
     * @param  string $where_column WHEREの条件に用いるカラム。今回は一つのカラムのみとする。
     * @param  string $where_value WHEREの条件に用いる値。今回は一つのカラムのみとする。
     * @return array|bool SELECTに成功したら結果の連想配列, 失敗したらfalse
     */
    public static function findBy($where_column, $where_value) {
        
        $trace = debug_backtrace();
        $table = lcfirst(get_class($trace[1]['object'])).'s'; // この辺りは突貫実装なので汚いですすいません。
        
        $sql = "SELECT * FROM `:table` WHERE `:column`= :value";
        
        $pdo = DbConnector::getPdo();
        
        $stmt = $pdo->prepare($sql);
        var_dump($stmt);
        if ($stmt === false) {
            // FIXME:? Exceptionの方が良い？
            return false;
        }
        var_dump($table, $where_column, $where_value);
        $stmt->bindParam(':table', $table);
        $stmt->bindParam(':column', $where_column);
        $stmt->bindParam(':value', $where_value);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    public static function insert() {
        $table = __CLASS__ . 's';
    }
    
    
    public function findManyBy($attribute, array $values = [], $columns = []) {
        $query = $this->select($columns);
        foreach ($values as $value) {
            $query->orWhere([$attribute => $value]);
        }
        return $query->get();
    }
    
}