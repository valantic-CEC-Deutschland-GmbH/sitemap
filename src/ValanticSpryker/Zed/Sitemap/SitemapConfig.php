<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\Sitemap;

use Pyz\Shared\Application\ApplicationConstants;
use ValanticSpryker\Shared\Sitemap\SitemapConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class SitemapConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getYvesHost(): string
    {
        return $this->get(ApplicationConstants::BASE_URL_YVES);
    }

    /**
     * @return string
     */
    public function getSitemapPath(): string
    {
        return $this->get(ApplicationConstants::SHARED_DIRECTORY) . '/sitemap';
    }

    /**
     * @return int
     */
    public function getSitemapSizeLimit(): int
    {
        return (int)$this->get(SitemapConstants::SITEMAP_SIZE_LIMIT);
    }

    /**
     * @return int
     */
    public function getSitemapUrlLimit(): int
    {
        return (int)$this->get(SitemapConstants::SITEMAP_URL_LIMIT);
    }

    /**
     * @return array
     */
    public function getAvailableLocale(): array
    {
        $allStores = $this->get(SitemapConstants::SITEMAP_LOCALES);

        return $allStores[$this->getCurrentStore()]['locales'];
    }

    /**
     * @return string
     */
    protected function getCurrentStore(): string
    {
        return Store::getInstance()->getStoreName();
    }
}
