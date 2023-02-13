<?php

namespace Zed\Sitemap\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Zed\Sitemap\Business\Model\Handler\SitemapHandler;
use Zed\Sitemap\Business\Model\Handler\SitemapHandlerInterface;
use Zed\Sitemap\Communication\Table\SitemapDataTable;
use Zed\Sitemap\SitemapDependencyProvider;

/**
 * @method \Zed\Sitemap\Persistence\SitemapQueryContainerInterface getQueryContainer()
 * @method \Zed\Sitemap\Business\SitemapFacadeInterface getFacade()
 * @method \Zed\Sitemap\SitemapConfig getConfig()
 */
class SitemapCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Zed\Sitemap\Communication\Table\SitemapDataTable
     */
    public function createSitemapDataTable(): SitemapDataTable
    {
        return new SitemapDataTable($this->getQueryContainer());
    }

    /**
     * @return \Zed\Sitemap\Business\Model\Handler\SitemapHandlerInterface
     */
    public function createSitemapHandler(): SitemapHandlerInterface
    {
        return new SitemapHandler($this->getQueryContainer(), $this->getConfig());
    }

    /**
     * @return mixed
     */
    public function getLocaleFacade()
    {
        return $this->getProvidedDependency(SitemapDependencyProvider::FACADE_LOCALE);
    }
}
