<?php

namespace Zed\Sitemap\Communication\Controller;

use Generated\Shared\Transfer\UrlStorageTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Zed\Sitemap\Business\SitemapFacade getFacade()
 * @method \Zed\Sitemap\Persistence\SitemapQueryContainer getQueryContainer()
 * @method \Zed\Sitemap\Communication\SitemapCommunicationFactory getFactory()
 */
class IndexController extends AbstractController
{
    public const PARAM_ID_URL = 'id-url';
    public const PARAM_IS_VISIBLE = 'is-visible';
    public const REDIRECT_URL_DEFAULT = '/sitemap';

    /**
     * @return array
     */
    public function indexAction(): array
    {
        return $this->viewResponse([
            'sitemapDataTable' => $this->getFactory()->createSitemapDataTable()->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction(): JsonResponse
    {
        $table = $this->getFactory()
            ->createSitemapDataTable();

        return $this->jsonResponse($table->fetchData());
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleUrlVisibilityAction(Request $request): RedirectResponse
    {
        $idUrl = $this->getParamIdUrl($request);
        $isVisible = $this->getParamIsVisible($request);

        $urlStorageTransfer = $this->createUrlStorageTransfer()
            ->setIdUrlStorage($idUrl)
            ->setVisible($isVisible);

        if ($this->getFactory()->createSitemapHandler()->toggleUrlVisibility($urlStorageTransfer)) {
            $this->addSuccessMessage("Success!");
        } else {
            $this->addErrorMessage("Url was not found!");
        }

        return $this->redirectResponse(static::REDIRECT_URL_DEFAULT);
    }

    /**
     * @return \Generated\Shared\Transfer\UrlStorageTransfer
     */
    protected function createUrlStorageTransfer(): UrlStorageTransfer
    {
        return new UrlStorageTransfer();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return int
     */
    protected function getParamIdUrl(Request $request): int
    {
        return $this->castId($request->query->get(static::PARAM_ID_URL));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return bool
     */
    protected function getParamIsVisible(Request $request): bool
    {
        return $this->castId($request->query->get(static::PARAM_IS_VISIBLE)) === 0 ? false : true;
    }
}
