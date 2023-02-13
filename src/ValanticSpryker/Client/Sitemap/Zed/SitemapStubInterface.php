<?php

namespace ValanticSpryker\Client\Sitemap\Zed;

use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;

interface SitemapStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\SitemapTransfer $sitemapTransfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemap(SitemapTransfer $sitemapTransfer): SitemapResponseTransfer;
}
