<?php

namespace Yves\Sitemap;

use Client\Sitemap\SitemapClient;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class SitemapDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_SITEMAP = 'CLIENT_SITEMAP';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Client\Sitemap\SitemapClientInterface|\Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addSitemapClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addSitemapClient(Container $container): Container
    {
        $container->set(static::CLIENT_SITEMAP, $this->getSitemapClient($container));

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Client\Sitemap\SitemapClient
     */
    protected function getSitemapClient(Container $container): SitemapClient
    {
        return $container->getLocator()->sitemap()->client();
    }
}
