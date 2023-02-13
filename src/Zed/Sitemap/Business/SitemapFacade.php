<?php

namespace Zed\Sitemap\Business;

use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Zed\Sitemap\Business\SitemapBusinessFactory getFactory()
 */
class SitemapFacade extends AbstractFacade implements SitemapFacadeInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\SitemapTransfer $sitemapTransfer
     *
     * @return void
     */
    public function createSitemapXml(SitemapTransfer $sitemapTransfer): void
    {
        $this->getFactory()->createSitemapHandler()->createSitemapXml($sitemapTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\SitemapTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemapIndexContent(SitemapTransfer $transfer): SitemapResponseTransfer
    {
        return $this->getFactory()->createSitemapHandler()->getSitemapIndexContent($transfer);
    }
}
