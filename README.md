# dotenv

environment variables setter

## Description 

透過`.env`, `.env.dev`, `.env.testing`檔案設定`$_ENV`環境變數

## Usage

假設需要設定資料庫, 您的`.env`檔案可以設定如下: 

    DB_HOST=localhost
    DB_NANE=testdb
    DB_USER=root
    DB_PASS=root
    
## Examples

目錄結構:

```
project
│   .env            環境設定檔案
|   .env.dev        環境設定檔案
│───app             APP目錄
│───public_html     入口文件目錄
|   |   index.php   入口檔案
|   
|───vendor
|
```
 
根據設定的環境`production`, `development`, `testing` 來讀取對應env檔案, 以下是讀取`.env`的範例:

    $dotenv=new Dotenv\EnvironmentLoader(__DIR__."/../", Dotenv\EnvironmentLoader::production);
    $dotenv->load();
    
    $db = [
      'host' => $_ENV['DB_HOST'],  //localhost
      'name' => $_ENV['DB_NAME'],  //testdb
      'user' => $_ENV['DB_USER'],  //root
      'pass' => $_ENV['DB_PASS']   //root
    ];
 
