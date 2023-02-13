<?php

declare(strict_types = 1);

namespace Zed\Sitemap\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Zed\Sitemap\Business\Model\Handler\SitemapHandler;
use Zed\Sitemap\Business\Model\Handler\SitemapHandlerInterface;

/**
 * @method \Zed\Sitemap\Persistence\SitemapQueryContainerInterface getQueryContainer()
 * @method \Zed\Sitemap\SitemapConfig getConfig()
 */
class SitemapBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Zed\Sitemap\Business\Model\Handler\SitemapHandlerInterface
     */
    public function createSitemapHandler(): SitemapHandlerInterface
    {
        return new SitemapHandler($this->getQueryContainer(), $this->getConfig());
    }
}
