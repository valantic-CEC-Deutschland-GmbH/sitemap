<?php

namespace Client\Sitemap\Zed;

use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class SitemapStub extends ZedRequestStub implements SitemapStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\SitemapTransfer $sitemapTransfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemap(SitemapTransfer $sitemapTransfer): SitemapResponseTransfer
    {
        /**
         * @var \Generated\Shared\Transfer\SitemapResponseTransfer $sitemapTransfer
         */
        $sitemapTransfer = $this->zedStub->call('/sitemap/gateway/get-sitemap', $sitemapTransfer);

        return $sitemapTransfer;
    }
}
