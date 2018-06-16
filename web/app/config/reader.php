<?php 

/**
 * configファイルを読み込むためのclass
 */
class ConfigReader
{
    const DB_CONFIG_PATH = __DIR__ . '/config.json';
    
    /**
     * DBのconfigファイルを読み込む
     *
     * @return array DBのconfig情報を含む連想配列
     */
    public static function readDbConfig() {
        
        $json = file_get_contents(self::DB_CONFIG_PATH);
        
        if ($json === false) {
            return false;
        }
        
        $config_assoc_arr = json_decode($json, true);
        
        if (is_null($config_assoc_arr) === true) {
            return false;
        }
        
        return $config_assoc_arr;
    }
}


