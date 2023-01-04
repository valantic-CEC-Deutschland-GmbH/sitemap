<?php

namespace ValanticSpryker\Zed\Sitemap\Communication\Controller;

use Generated\Shared\Transfer\SitemapTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \ValanticSpryker\Zed\Sitemap\Communication\SitemapCommunicationFactory getFactory()
 * @method \ValanticSpryker\Zed\Sitemap\Business\SitemapFacade getFacade()
 * @method \ValanticSpryker\Zed\Sitemap\Persistence\SitemapQueryContainerInterface getQueryContainer()
 */
class GenerateController extends AbstractController
{
    /**
     * @return void
     */
    public function generateAction(): void
    {
        $locale = $this->getFactory()->getLocaleFacade()->getCurrentLocale()->getLocaleName();
        $sitemapTransfer = (new SitemapTransfer())->fromArray(['locale' => explode('_', $locale)[0]]);

        $this->getFacade()->createSitemapXml($sitemapTransfer);
    }
}
