<?php
namespace Cloud\Dotenv\Test;
use PHPUnit\Framework\TestCase;
use Cloud\Dotenv\EnvironmentLoader;
use Cloud\Dotenv\Exception\InvalidFileException;
use Cloud\Dotenv\Exception\InvalidTypeException;
/**
 * Description of EnvironmentLoaderTest
 *
 * @author Cloud
 */
class EnvironmentLoaderTest extends TestCase
{
    public function testEnviromentType()
    {
        $this->assertEquals(".env", EnvironmentLoader::production);
        $this->assertEquals(".env.dev", EnvironmentLoader::development);
        $this->assertEquals(".env.testing", EnvironmentLoader::testing);
    }
    public function testLoad()
    {        
        $dotenv=new EnvironmentLoader(__DIR__, EnvironmentLoader::production);
        $dotenv->load();
        $this->assertEquals("/adm", getenv('ADMIN_DIR'));
        $this->assertEquals(true, getenv('TRUE_TEST'));
        $this->assertEmpty(getenv('TEST'));
    }
}

