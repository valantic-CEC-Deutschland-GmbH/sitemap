<?php

namespace ValanticSpryker\Zed\Sitemap\Communication\Table;

use Orm\Zed\UrlStorage\Persistence\Map\SpyUrlStorageTableMap;
use Orm\Zed\UrlStorage\Persistence\SpyUrlStorage;
use Orm\Zed\UrlStorage\Persistence\SpyUrlStorageQuery;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use ValanticSpryker\Zed\Sitemap\Persistence\SitemapQueryContainerInterface;

class SitemapDataTable extends AbstractTable
{
    public const ACTIONS = 'Actions';
    public const COL_ID_URL = 'id_url_storage';
    public const COL_URL = 'url';
    public const COL_VISIBLE = 'visible';
    public const LABEL_ACTIVATE = 'Activate';
    public const LABEL_DEACTIVATE = 'Deactivate';
    public const PARAM_ID_URL = 'id-url';
    public const PARAM_IS_VISIBLE = 'is-visible';
    public const URL_TOGGLE_URL_VISIBILITY = '/sitemap/index/toggle-url-visibility';

    /**
     * @var \ValanticSpryker\Zed\Sitemap\Persistence\SitemapQueryContainerInterface
     */
    protected $sitemapQueryContainer;

    /**
     * @param \ValanticSpryker\Zed\Sitemap\Persistence\SitemapQueryContainerInterface $sitemapQueryContainer
     */
    public function __construct(SitemapQueryContainerInterface $sitemapQueryContainer)
    {
        $this->sitemapQueryContainer = $sitemapQueryContainer;
    }

    /**
     * @param \Orm\Zed\UrlStorage\Persistence\SpyUrlStorage|null $urlStorageEntity
     *
     * @return string
     */
    protected function buildLinks(?SpyUrlStorage $urlStorageEntity = null): string
    {
        if ($urlStorageEntity === null) {
            return '';
        }

        $buttons = [];

        if ($urlStorageEntity->getVisible() === true) {
            $url = $this->generateUrl(static::URL_TOGGLE_URL_VISIBILITY, [
                static::PARAM_ID_URL => $urlStorageEntity->getIdUrlStorage(),
                static::PARAM_IS_VISIBLE => 0,
            ]);
            $buttons[] = $this->generateDeactivateButton($url, static::LABEL_DEACTIVATE);
        } else {
            $url = $this->generateUrl(static::URL_TOGGLE_URL_VISIBILITY, [
                static::PARAM_ID_URL => $urlStorageEntity->getIdUrlStorage(),
                static::PARAM_IS_VISIBLE => 1,
            ]);
            $buttons[] = $this->generateActivateButton($url, static::LABEL_ACTIVATE);
        }

        return implode(' ', $buttons);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            static::COL_ID_URL => '#',
            static::COL_URL => 'URL',
            static::COL_VISIBLE => 'Is visible?',
            static::ACTIONS => static::ACTIONS,
        ]);

        $config->addRawColumn(static::ACTIONS);

        $config->setSortable([
            static::COL_ID_URL,
            static::COL_URL,
            static::COL_VISIBLE,
        ]);

        $config->setSearchable([
            SpyUrlStorageTableMap::COL_URL,
            SpyUrlStorageTableMap::COL_VISIBLE,
        ]);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $query = $this->prepareQuery();

        $urlsCollection = $this->runQuery($query, $config, true);

        if ($urlsCollection->count() < 1) {
            return [];
        }

        return $this->formatUrlCollection($urlsCollection);
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $urlsCollection
     *
     * @return array
     */
    protected function formatUrlCollection(ObjectCollection $urlsCollection): array
    {
        $urlList = [];

        foreach ($urlsCollection as $url) {
            $urlList[] = $this->hydrateUrlListRow($url);
        }

        return $urlList;
    }

    /**
     * @param string $url
     * @param string $title
     * @param array $options
     *
     * @return string
     */
    protected function generateActivateButton(string $url, string $title, array $options = []): string
    {
        $defaultOptions = [
            'class' => 'btn-create',
            'icon' => 'fa-plus',
        ];

        return $this->generateButton($url, $title, $defaultOptions, $options);
    }

    /**
     * @param string $url
     * @param string $title
     * @param array $options
     *
     * @return string
     */
    protected function generateDeactivateButton(string $url, string $title, array $options = []): string
    {
        $defaultOptions = [
            'class' => 'btn-remove',
            'icon' => 'fa-minus',
        ];

        return $this->generateButton($url, $title, $defaultOptions, $options);
    }

    /**
     * @param string $url
     * @param array $queryParams
     *
     * @return string
     */
    protected function generateUrl(string $url, array $queryParams): string
    {
        return Url::generate($url, $queryParams);
    }

    /**
     * @param \Orm\Zed\UrlStorage\Persistence\SpyUrlStorage $spyUrlData
     *
     * @return array
     */
    protected function hydrateUrlListRow(SpyUrlStorage $spyUrlData): array
    {
        $tableRow = $spyUrlData->toArray();
        $tableRow[static::ACTIONS] = $this->buildLinks($spyUrlData);

        return $tableRow;
    }

    /**
     * @return \Orm\Zed\UrlStorage\Persistence\SpyUrlStorageQuery
     */
    protected function prepareQuery(): SpyUrlStorageQuery
    {
        return $this->sitemapQueryContainer->getSpyUrlStorageQuery();
    }

    /**
     * @return array
     */
    protected function getTwigPaths()
    {
        return [
            '/../../Presentation/Table/',
        ];
    }
}
