<?php

namespace ValanticSpryker\Zed\Sitemap\Business;

use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;

interface SitemapFacadeInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\SitemapTransfer $sitemapTransfer
     *
     * @return void
     */
    public function createSitemapXml(SitemapTransfer $sitemapTransfer): void;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\SitemapTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemapIndexContent(SitemapTransfer $transfer): SitemapResponseTransfer;
}
