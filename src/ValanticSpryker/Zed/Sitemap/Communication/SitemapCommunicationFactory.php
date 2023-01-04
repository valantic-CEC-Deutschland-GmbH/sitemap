<?php

namespace ValanticSpryker\Zed\Sitemap\Communication;

use ValanticSpryker\Zed\Sitemap\Business\Model\Handler\SitemapHandler;
use ValanticSpryker\Zed\Sitemap\Business\Model\Handler\SitemapHandlerInterface;
use ValanticSpryker\Zed\Sitemap\Communication\Table\SitemapDataTable;
use ValanticSpryker\Zed\Sitemap\SitemapDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \ValanticSpryker\Zed\Sitemap\Persistence\SitemapQueryContainerInterface getQueryContainer()
 * @method \ValanticSpryker\Zed\Sitemap\Business\SitemapFacadeInterface getFacade()
 * @method \ValanticSpryker\Zed\Sitemap\SitemapConfig getConfig()
 */
class SitemapCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \ValanticSpryker\Zed\Sitemap\Communication\Table\SitemapDataTable
     */
    public function createSitemapDataTable(): SitemapDataTable
    {
        return new SitemapDataTable($this->getQueryContainer());
    }

    /**
     * @return \ValanticSpryker\Zed\Sitemap\Business\Model\Handler\SitemapHandlerInterface
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
