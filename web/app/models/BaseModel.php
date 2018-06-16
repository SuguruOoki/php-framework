<?php 

require_once(__DIR__ . '/../db/DbConnector.php');

class BaseModel
{
    public static function findBy($columns, $value) {
        $table = __CLASS__ . 's';
        $sql = "SELECT * FROM :table WHERE :column=:value";
        
        $pdo = DbConnector::getPdo();
        
        $stmt = $pdo->prepare($sql);
        
        if ($stmt === false) {
            // FIXME:? Exceptionの方が良い？
            return false;
        }
        
        $stmt->bindparam(':table', $table);
        $stmt->bindparam(':column', $column);
        $stmt->bindparam(':value', $value);
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_LAZY);
        
        return $result;
    }
    
    public static function insert() {
        $table = __CLASS__ . 's';
    }
}