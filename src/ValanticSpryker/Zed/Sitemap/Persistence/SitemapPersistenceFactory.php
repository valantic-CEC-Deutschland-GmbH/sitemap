<?php

namespace ValanticSpryker\Zed\Sitemap\Persistence;

use Orm\Zed\Category\Persistence\SpyCategoryNodeQuery;
use Orm\Zed\Locale\Persistence\SpyLocaleQuery;
use Orm\Zed\UrlStorage\Persistence\SpyUrlStorageQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \ValanticSpryker\Zed\Sitemap\SitemapConfig getConfig()
 * @method \ValanticSpryker\Zed\Sitemap\Persistence\SitemapQueryContainerInterface getQueryContainer()
 */
class SitemapPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return array
     */
    public function getAvailableLocale(): array
    {
        return $this->getConfig()->getAvailableLocale();
    }

    /**
     * @return \Orm\Zed\UrlStorage\Persistence\SpyUrlStorageQuery
     */
    public function getSpyUrlStorageQuery(): SpyUrlStorageQuery
    {
        return SpyUrlStorageQuery::create();
    }

    /**
     * @return \Orm\Zed\Locale\Persistence\SpyLocaleQuery
     */
    public function getSpyLocaleQuery(): SpyLocaleQuery
    {
        return SpyLocaleQuery::create();
    }

    /**
     * @return \Orm\Zed\Category\Persistence\SpyCategoryNodeQuery
     */
    public function getSpyCategoryNodeQuery(): SpyCategoryNodeQuery
    {
        return SpyCategoryNodeQuery::create();
    }
}
