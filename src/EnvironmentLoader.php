<?php
namespace Cloud\Dotenv;

use Cloud\Dotenv\Exception\InvalidTypeException;
use Cloud\Dotenv\Exception\InvalidFileException;
/**
 * Description of EnvironmentLoader
 * You can define you're Enviroment type here
 * here are 3 type to use
 * .env : use it when ur project is a production project
 * .env : 請在正式環境使用
 * .env.dev : use it when ur project is a local development project
 * .env.dev : 請在開發環境(本機端)使用
 * .env.testing : use it when ur project is a online testing project
 * .env.testing : 請在線上測試環境使用(server端)
 * @author Cloud
 */
class EnvironmentLoader
{    
    const production = '.env';
    const development = '.env.dev';
    const testing = '.env.testing';
    const default_type = [
        self::production,
        self::development,
        self::testing
    ];
    protected $file;
    protected $type;
    /**
     * Create a new loader instance.     
     * @param type $file_path   you're env file locate
     * @param type $type env type
     */
    public function __construct($file_path, $type = self::development)
    {
        $this->type=$type;
        $this->file=$file_path."/{$type}";
    }
    /**
     * Load env file
     */
    public function load()
    {        
        $this->checkEnviromentType();
        $this->checkFileReadable();  
        $lines=$this->getFileLines();
        foreach ($lines as $line) {
            if (!$this->isComment($line) && $this->looksLikeSetter($line)) {
                list($name, $value)=$this->splitToNameValue($line);
                $value = $this->boolaenValue($value);
                $this->setEnv($name, $value);
            }
        }
    }
    /**
     * Check if the given file type is allowed
     * @throws InvalidTypeException
     */
    private function checkEnviromentType()
    {
        if (!in_array($this->type, self::default_type)) {
            throw new InvalidTypeException(sprintf("Error type of enviroment : %s", $this->type));
        }
    }
    /**
     * Check file readable
     * @throws InvalidFileException
     */
    private function checkFileReadable()
    {
        if (!is_readable($this->file)) {
            throw new InvalidFileException(sprintf("Error file : %s", $this->file));
        }
    }
    /**
     * Check if the line in the file is Commented
     * @param type $line
     * @return type
     */
    private function isComment($line)
    {        
        return strpos(ltrim($line), "#") === 0;
    }
    /**
     * Check if the line in the file is a setter line ex: DB_TEST='test'
     * @param type $line
     * @return type
     */
    private function looksLikeSetter($line)
    {
        return strpos($line, "=") !== false;
    }
    /**
     * split line to name, value
     * @param type $line
     */
    private function splitToNameValue($line)
    {
        if (strpos($line, "=") !== false) {
            return array_map("trim", explode("=", $line, 2));
        }        
    }
    /**
     * get lines
     * @return type
     */
    private function getFileLines()
    {
        $autodetect = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');  //if it is using Unix, MS-Dos or Macintosh line-ending conventions    檢查是否使用以上三種的結束行的約定
        $lines = file($this->file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);   
        ini_set('auto_detect_line_endings', $autodetect);
        return $lines;
    }
    /**
     * set env variables
     * @param type $name
     * @param type $value
     */
    private function setEnv($name, $value)
    {
        if (function_exists("putenv")) {
            putenv("$name=$value");    
        }
        $_ENV[$name]=$value;
    }
    /**
     * convert string boolean value to real boolean value
     * @param type $value
     * @return type
     */
    private function boolaenValue($value)
    {
        $value = $value === "true" || $value === 'True' || $value === 'TRUE' ? true : $value; 
        $value = $value === "false"|| $value === 'False' || $value === 'FALSE' ? false : $value;
        return $value;
    }
    /**
     * clear env variables
     */
    public function clearEnv()
    {
        $_ENV=[];
    }
}
