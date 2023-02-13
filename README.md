## Implementation:

1. Install dependency
```
composer require valantic-spryker/sitemap
```

2. Register RouterPlugin
```php
<?php

namespace Pyz\Yves\Router;

use [...]

class RouterDependencyProvider extends SprykerRouterDependencyProvider
{
    [...]

    /**
     * @return \Spryker\Yves\RouterExtension\Dependency\Plugin\RouteProviderPluginInterface[]
     */
    protected function getRouteProvider(): array
    {
        return [
            [...]
            new SitemapControllerProvider(),
        ];
    }
}
```

3. Register Console command
```php
<?php
declare(strict_types = 1);

namespace Pyz\Zed\Console;

use [...]

/**
 * @method \Pyz\Zed\Console\ConsoleConfig getConfig()
 */
class ConsoleDependencyProvider extends SprykerConsoleDependencyProvider
{
    [...]
    
     /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Symfony\Component\Console\Command\Command[]
     */
    protected function getConsoleCommands(Container $container)
    {
        $commands = [
            [...]
            new SitemapGenerateConsole(),
        ];
    }
}
```

4. Rename ESA into your project name
- In src/ValanticSpryker/Yves/Sitemap/Plugin/Provider/SitemapControllerProvider.php:45-53
```php
/**
 * Pattern: ((esa(\_(de|en))?)|((de|en)\/esa(\_(de|en))))(\_[0-9]+)?\.xml
 * Takes into consideration the following paths:
 * - {$storeLocales}/esa_{$storeLocales}_{number}.xml
 * - {$storeLocales}/esa_{$storeLocales}.xml
 * - {$storeLocales}/esa.xml
 * - esa_{$storeLocales}_{number}.xml
 * - esa_{$storeLocales}.xml
 * - esa_{number}.xml
 * - esa.xml
 *
 * @return string
 */
```

5. Replace project name
- Add cronjob in current/config/Zed/cronjobs/jenkins.php
```php
$jobs[] = [
    'name' => 'generate-sitemap-de',
    'command' => '$PHP_BIN vendor/bin/console sitemap:generate de -vvv',
    'schedule' => '0 0 1 1 *',
    'enable' => false,
    'run_on_non_production' => true,
    'stores' => $allStores,
];
```
