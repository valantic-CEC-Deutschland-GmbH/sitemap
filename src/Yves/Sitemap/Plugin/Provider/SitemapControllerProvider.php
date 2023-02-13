<?php

namespace Yves\Sitemap\Plugin\Provider;

use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class SitemapControllerProvider extends AbstractRouteProviderPlugin
{
    public const SITEMAP_INDEX = 'sitemap-index';

    /**
     * Specification:
     * - Adds Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addSitemapRoutes($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addSitemapRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildGetRoute('/{name}', 'Sitemap', 'Index', 'indexAction');
        $route->setRequirement('name', $this->getSitemapPattern());
        $routeCollection->add(static::SITEMAP_INDEX, $route);

        return $routeCollection;
    }

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
    protected function getSitemapPattern(): string
    {
        $systemLocales = Store::getInstance()->getLocales();

        if ($systemLocales) {
            $locales = '(' . implode('|', array_keys($systemLocales)) . ')';
            $pattern = '((sitemap(\_' . $locales . ')?)|(' . $locales . '\/sitemap(\_' . $locales . ')?))(\_[0-9]+)?\.xml';
        } else {
            $pattern = '(sitemap)(\_[0-9]+)?\.xml';
        }

        return $pattern;
    }
}
