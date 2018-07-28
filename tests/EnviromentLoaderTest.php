<?php
namespace Dotenv\Test;
use PHPUnit\Framework\TestCase;
use Dotenv\EnviromentLoader;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Exception\InvalidTypeException;
/**
 * Description of EnviromentLoaderTest
 *
 * @author Cloud
 */
class EnviromentLoaderTest extends TestCase
{
    public function testEnviromentType()
    {
        $this->assertEquals(".env", EnviromentLoader::production);
        $this->assertEquals(".env.dev", EnviromentLoader::development);
        $this->assertEquals(".env.testing", EnviromentLoader::testing);
    }
    public function testLoad()
    {        
        $dotenv=new \Dotenv\EnviromentLoader(__DIR__, EnviromentLoader::production);
        $dotenv->load();
        $this->assertEquals("/adm", getenv('ADMIN_DIR'));
        $this->assertEmpty(getenv('TEST'));
    }
}

