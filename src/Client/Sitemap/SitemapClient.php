<?php

namespace Client\Sitemap;

use Client\Sitemap\Zed\SitemapStubInterface;
use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Client\Sitemap\SitemapFactory getFactory()
 */
class SitemapClient extends AbstractClient implements SitemapClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\SitemapTransfer $sitemapTransfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemap(SitemapTransfer $sitemapTransfer): SitemapResponseTransfer
    {
        return $this->getZedStub()->getSitemap($sitemapTransfer);
    }

    /**
     * @return \Client\Sitemap\Zed\SitemapStubInterface
     */
    protected function getZedStub(): SitemapStubInterface
    {
        return $this->getFactory()->createZedStub();
    }
}
