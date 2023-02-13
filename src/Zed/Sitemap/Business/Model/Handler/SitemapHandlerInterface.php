<?php

namespace Zed\Sitemap\Business\Model\Handler;

use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;
use Generated\Shared\Transfer\UrlStorageTransfer;

interface SitemapHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\SitemapTransfer $sitemapTransfer
     *
     * @return void
     */
    public function createSitemapXml(SitemapTransfer $sitemapTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\UrlStorageTransfer $urlStorageTransfer
     *
     * @return bool
     */
    public function toggleUrlVisibility(UrlStorageTransfer $urlStorageTransfer): bool;

    /**
     * @param \Generated\Shared\Transfer\SitemapTransfer $sitemapTransfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemapIndexContent(SitemapTransfer $sitemapTransfer): SitemapResponseTransfer;
}
