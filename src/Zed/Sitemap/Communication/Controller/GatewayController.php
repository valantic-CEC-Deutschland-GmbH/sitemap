<?php

namespace Zed\Sitemap\Communication\Controller;

use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Zed\Sitemap\Business\SitemapFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\SitemapTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemapAction(SitemapTransfer $transfer): SitemapResponseTransfer
    {
        return $this->getFacade()->getSitemapIndexContent($transfer);
    }
}
