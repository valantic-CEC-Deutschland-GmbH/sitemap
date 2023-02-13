<?php

namespace Zed\Sitemap\Business\Model\Handler;

use DateTime;
use DOMDocument;
use Generated\Shared\Transfer\SitemapResponseTransfer;
use Generated\Shared\Transfer\SitemapTransfer;
use Generated\Shared\Transfer\UrlStorageTransfer;
use Propel\Runtime\Collection\ObjectCollection;
use Zed\Sitemap\Persistence\SitemapQueryContainerInterface;
use Zed\Sitemap\SitemapConfig;

class SitemapHandler implements SitemapHandlerInterface
{
    protected const DOT_XML_EXTENSION = '.xml';
    protected const SITEMAP_FILE_NAME = 'sitemap';

    /**
     * @var \Zed\Sitemap\Persistence\SitemapQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \Zed\Sitemap\SitemapConfig
     */
    protected $config;

    /**
     * @param \Zed\Sitemap\Persistence\SitemapQueryContainerInterface $queryContainer
     * @param \Zed\Sitemap\SitemapConfig $config
     */
    public function __construct(
        SitemapQueryContainerInterface $queryContainer,
        SitemapConfig $config
    ) {
        $this->queryContainer = $queryContainer;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\SitemapTransfer $transfer
     *
     * @return void
     */
    public function createSitemapXml(SitemapTransfer $transfer): void
    {
        $locale = $transfer->getLocale();
        $urlList = $this->queryContainer->findVisibleUrls($locale, false);
        $this->paginateResultSet($urlList, $locale);
    }

    /**
     * @param \Generated\Shared\Transfer\UrlStorageTransfer $urlStorageTransfer
     *
     * @return bool
     */
    public function toggleUrlVisibility(UrlStorageTransfer $urlStorageTransfer): bool
    {
        return $this->queryContainer->toggleUrlVisibility($urlStorageTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\SitemapTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\SitemapResponseTransfer
     */
    public function getSitemapIndexContent(SitemapTransfer $transfer): SitemapResponseTransfer
    {
        $segments = explode('_', str_replace(static::DOT_XML_EXTENSION, '', $transfer->getFile()));
        $locale = explode('_', $transfer->getLocale())[0];
        if ($segments[0] !== static::SITEMAP_FILE_NAME) {
            $segments[0] = static::SITEMAP_FILE_NAME;
        }
        $segmentsCount = count($segments);
        if ($segmentsCount == 1) {
            $segments[] = $locale;
        } elseif ($segments[1] !== $locale) {
            if (is_numeric($segments[1])) {
                array_splice($segments, 1, 0, $locale);
            } else {
                $segments[1] = $locale;
            }
        }
        $filename = implode('_', $segments) . static::DOT_XML_EXTENSION;
        $filePointer = $this->config->getSitemapPath() . "/$locale/$filename";

        if (!file_exists($filePointer)) {
            $this->createSitemapXml($transfer);
        }

        return (new SitemapResponseTransfer())->fromArray(
            [
                'urls' => file_get_contents($filePointer),
            ],
        );
    }

    /**
     * @param string $locale
     * @param int $pages
     *
     * @return void
     */
    protected function createSitemapIndex(string $locale, int $pages): void
    {
        $domtree = new DOMDocument('1.0', 'UTF-8');

        $domtree->preserveWhiteSpace = false;
        $domtree->formatOutput = true;

        $sitemapIndex = $domtree->createElement('sitemapindex');
        $sitemapIndex = $domtree->appendChild($sitemapIndex);

        for ($page = 1; $page <= $pages; $page++) {
            $sitemapIndexNode = $domtree->createElement('sitemap');
            $sitemapIndexNode = $sitemapIndex->appendChild($sitemapIndexNode);

            $filename = static::SITEMAP_FILE_NAME . "_" . $locale . "_" . $page . static::DOT_XML_EXTENSION;
            $sitemapIndexNode->appendChild(
                $domtree->createElement('loc', $this->config->getYvesHost() . "/$locale/" . $filename),
            );
        }

        $directory = $this->config->getSitemapPath() . "/$locale";

        if (!file_exists($directory)) {
            mkdir($directory, 0700, true);
        }

        $filePointer = $directory . "/" . static::SITEMAP_FILE_NAME . "_" . $locale . static::DOT_XML_EXTENSION;
        file_put_contents($filePointer, $domtree->saveXML());
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $urlSet
     * @param string $locale
     *
     * @return void
     */
    protected function paginateResultSet(ObjectCollection $urlSet, string $locale): void
    {
        $totalUrlNo = count($urlSet);
        $urlLimit = $this->config->getSitemapUrlLimit();
        $noOfPages = $totalUrlNo > 0 ? ceil($totalUrlNo / $urlLimit) : 0;

        $this->createSitemapIndex($locale, $noOfPages);

        for ($page = 1; $page <= $noOfPages; $page++) {
            $this->createSitemapXmlFiles($locale, $page, $urlLimit);
        }
    }

    /**
     * @param string $locale
     * @param int $page
     * @param string $limit
     *
     * @return void
     */
    protected function createSitemapXmlFiles(string $locale, int $page, string $limit): void
    {
        $urlList = $this->queryContainer->findVisibleUrls($locale, true, $page, $limit);
        $filename = static::SITEMAP_FILE_NAME . "_" . $locale . "_" . $page . static::DOT_XML_EXTENSION;
        $domtree = new DOMDocument('1.0', 'UTF-8');

        $domtree->preserveWhiteSpace = false;
        $domtree->formatOutput = true;

        $urlSet = $domtree->createElement('urlset');
        $urlSet = $domtree->appendChild($urlSet);

        foreach ($urlList->toArray() as $url) {
            $urlNode = $domtree->createElement('url');
            $urlNode = $urlSet->appendChild($urlNode);

            $lastModDate = new DateTime($url['UpdatedAt']);

            $urlNode->appendChild($domtree->createElement('loc', $this->config->getYvesHost() . htmlspecialchars($url['Url'])));
            $urlNode->appendChild($domtree->createElement('lastmod', $lastModDate->format('Y-m-d')));
        }

        $filePointer = $this->config->getSitemapPath() . "/$locale/$filename";
        file_put_contents($filePointer, $domtree->saveXML());
        chmod($filePointer, 0700);
    }
}
