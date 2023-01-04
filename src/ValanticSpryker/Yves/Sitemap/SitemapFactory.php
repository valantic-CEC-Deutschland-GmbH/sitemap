<?php

namespace ValanticSpryker\Yves\Sitemap;

use ValanticSpryker\Client\Sitemap\SitemapClientInterface;
use Spryker\Yves\Kernel\AbstractFactory;

class SitemapFactory extends AbstractFactory
{
    /**
     * @return \ValanticSpryker\Client\Sitemap\SitemapClientInterface
     */
    public function getSitemapClient(): SitemapClientInterface
    {
        return $this->getProvidedDependency(SitemapDependencyProvider::CLIENT_SITEMAP);
    }
}
