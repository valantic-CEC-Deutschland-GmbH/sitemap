# Sitemap:

## Implementation

1. Install dependency
```
composer require valantic-cec/sitemap
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

6. Adjust config file
- Add sitemap constants with your locales
```php
$config[SitemapConstants::SITEMAP_LOCALES] = [
    'ESA' => [
        'locales' => [
            'de' => 'de_CH',
            'fr' => 'fr_CH',
            'it' => 'it_CH',
        ]
    ]
];
$config[SitemapConstants::SITEMAP_URL_LIMIT] = 50;
$config[SitemapConstants::SITEMAP_SIZE_LIMIT] = 100;
```

7. Copy vendor template files into project folder
```
mkdir -p src/Pyz/Zed/Sitemap/Presentation
cp -r vendor/valantic-spryker/sitemap/src/ValanticSpryker/Zed/Sitemap/Presentation/* src/Pyz/Zed/Sitemap/Presentation
```

## Access Sitemap
The following paths are considered
```
  - {$storeLocales}/sitemap_{number}.xml
  - {$storeLocales}/sitemap.xml
  - sitemap_{number}.xml
  - sitemap.xml
```
