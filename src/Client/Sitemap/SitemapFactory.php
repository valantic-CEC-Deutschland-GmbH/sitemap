<?php

namespace Client\Sitemap;

use Client\Sitemap\Zed\SitemapStub;
use Client\Sitemap\Zed\SitemapStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class SitemapFactory extends AbstractFactory
{
    /**
     * @return \Client\Sitemap\Zed\SitemapStubInterface
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
