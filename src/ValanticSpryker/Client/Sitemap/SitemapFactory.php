<?php

namespace ValanticSpryker\Client\Sitemap;

use ValanticSpryker\Client\Sitemap\Zed\SitemapStub;
use ValanticSpryker\Client\Sitemap\Zed\SitemapStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class SitemapFactory extends AbstractFactory
{
    /**
     * @return \ValanticSpryker\Client\Sitemap\Zed\SitemapStubInterface
     */
    public function createZedStub(): SitemapStubInterface
    {
        return new SitemapStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(SitemapDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
