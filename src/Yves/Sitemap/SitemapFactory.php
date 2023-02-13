<?php

namespace Yves\Sitemap;

use Client\Sitemap\SitemapClientInterface;
use Spryker\Yves\Kernel\AbstractFactory;

class SitemapFactory extends AbstractFactory
{
    /**
     * @return \Client\Sitemap\SitemapClientInterface
     */
    public function getSitemapClient(): SitemapClientInterface
    {
        return $this->getProvidedDependency(SitemapDependencyProvider::CLIENT_SITEMAP);
    }
}
