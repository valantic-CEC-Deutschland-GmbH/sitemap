<?php

namespace ValanticSpryker\Client\Sitemap;

use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;

interface SitemapClientInterface
{
    /**
     * Specification:
     * - Returns the sitemapindex's or the sitemap's content as a string.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SitemapTransfer $sitemapTransfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemap(SitemapTransfer $sitemapTransfer): SitemapResponseTransfer;
}
