<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\Sitemap\Business;

use ValanticSpryker\Zed\Sitemap\Business\Model\Handler\SitemapHandler;
use ValanticSpryker\Zed\Sitemap\Business\Model\Handler\SitemapHandlerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \ValanticSpryker\Zed\Sitemap\Persistence\SitemapQueryContainerInterface getQueryContainer()
 * @method \ValanticSpryker\Zed\Sitemap\SitemapConfig getConfig()
 */
class SitemapBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \ValanticSpryker\Zed\Sitemap\Business\Model\Handler\SitemapHandlerInterface
     */
    public function createSitemapHandler(): SitemapHandlerInterface
    {
        return new SitemapHandler($this->getQueryContainer(), $this->getConfig());
    }
}
