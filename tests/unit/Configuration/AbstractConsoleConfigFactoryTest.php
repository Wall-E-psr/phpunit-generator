<?php

namespace UnitTests\PhpUnitGen\Configuration;

use PHPUnit\Framework\TestCase;
use PhpUnitGen\Configuration\AbstractConsoleConfigFactory;
use PhpUnitGen\Configuration\BaseConfig;
use PhpUnitGen\Configuration\JsonConsoleConfigFactory;

/**
 * Class AbstractConsoleConfigFactoryTest.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 *
 * @covers     \PhpUnitGen\Configuration\AbstractConsoleConfigFactory
 */
class AbstractConsoleConfigFactoryTest extends TestCase
{
    private $configFactory;

    private $configProperty;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->configFactory = new JsonConsoleConfigFactory();

        $this->configProperty = (new \ReflectionClass(BaseConfig::class))
            ->getProperty('config');
        $this->configProperty->setAccessible(true);
    }

    /**
     * @covers \PhpUnitGen\Configuration\AbstractConsoleConfigFactory::invoke()
     */
    public function testInvoke(): void
    {
        $config = __DIR__ . '/../../../examples/phpunitgen.config.json';

        $expected = require __DIR__ . '/../../../examples/phpunitgen.config.php';

        $result = $this->configFactory->invoke($config);

        $this->assertEquals($expected, $this->configProperty->getValue($result));
    }

    /**
     * @covers \PhpUnitGen\Configuration\AbstractConsoleConfigFactory::invokeOneFile()
     */
    public function testInvokeOneFile(): void
    {
        $config = __DIR__ . '/../../../examples/phpunitgen.config.json';

        $expected          = require __DIR__ . '/../../../examples/phpunitgen.config.php';
        $expected['dirs']  = [];
        $expected['files'] = ['input.php' => 'output.php'];

        $result = $this->configFactory->invokeOneFile($config, 'input.php', 'output.php');

        $this->assertEquals($expected, $this->configProperty->getValue($result));
    }
}