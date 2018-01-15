<?php

namespace PhpUnitGen\Container;

use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpUnitGen\Configuration\ConfigurationInterface\ConfigInterface;
use PhpUnitGen\Configuration\ConfigurationInterface\ConsoleConfigInterface;
use PhpUnitGen\Container\ContainerInterface\ContainerFactoryInterface;
use PhpUnitGen\Container\ContainerInterface\ContainerInterface;

/**
 * Class ContainerFactory.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
class ContainerFactory implements ContainerFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function invoke(
        ConfigInterface $config,
        string $autoResolvableArrayPath = __DIR__ . '/../../config/autoresolvable.config.php'
    ): ContainerInterface {
        $container = new Container();

        // Instance dependencies
        $container->setInstance(ConfigInterface::class, $config);
        $container->setInstance(ConsoleConfigInterface::class, $config);
        $container->setInstance(Parser::class, (new ParserFactory())->create(ParserFactory::PREFER_PHP7));

        // Automatically created dependencies and aliases
        $container->addAutoResolvableArray(require $autoResolvableArrayPath);

        return $container;
    }
}
