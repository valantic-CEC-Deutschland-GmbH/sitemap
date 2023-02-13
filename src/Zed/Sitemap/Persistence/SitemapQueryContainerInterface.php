<?php

namespace Zed\Sitemap\Persistence;

use Generated\Shared\Transfer\UrlStorageTransfer;
use Orm\Zed\UrlStorage\Persistence\SpyUrlStorageQuery;
use Propel\Runtime\Collection\ObjectCollection;

interface SitemapQueryContainerInterface
{
    /**
     * @return \Orm\Zed\UrlStorage\Persistence\SpyUrlStorageQuery
     */
    public function getSpyUrlStorageQuery(): SpyUrlStorageQuery;

    /**
     * @param string $locale
     * @param bool $paginate
     * @param int|null $page
     * @param int|null $limit
     *
     * @return \Propel\Runtime\Collection\ObjectCollection
     */
    public function findVisibleUrls(string $locale, $paginate = false, ?int $page = null, ?int $limit = null): ObjectCollection;

    /**
     * @param \Generated\Shared\Transfer\UrlStorageTransfer $urlStorageTransfer
     *
     * @return bool
     */
    public function toggleUrlVisibility(UrlStorageTransfer $urlStorageTransfer): bool;
}
