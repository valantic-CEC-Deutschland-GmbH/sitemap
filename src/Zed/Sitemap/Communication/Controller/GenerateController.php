<?php

namespace Zed\Sitemap\Communication\Controller;

use Generated\Shared\Transfer\SitemapTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Zed\Sitemap\Communication\SitemapCommunicationFactory getFactory()
 * @method \Zed\Sitemap\Business\SitemapFacade getFacade()
 * @method \Zed\Sitemap\Persistence\SitemapQueryContainerInterface getQueryContainer()
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
