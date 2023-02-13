<?php

namespace Zed\Sitemap\Persistence;

use Generated\Shared\Transfer\UrlStorageTransfer;
use Orm\Zed\Locale\Persistence\Map\SpyLocaleTableMap;
use Orm\Zed\Url\Persistence\Map\SpyUrlTableMap;
use Orm\Zed\UrlStorage\Persistence\Map\SpyUrlStorageTableMap;
use Orm\Zed\UrlStorage\Persistence\SpyUrlStorageQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Zed\Sitemap\Persistence\SitemapPersistenceFactory getFactory()
 */
class SitemapQueryContainer extends AbstractQueryContainer implements SitemapQueryContainerInterface
{
    public const LOCALE_SEP = '/';
    public const FK_CATEGORYNODE = 'fk_categorynode';

    /**
     * @return \Orm\Zed\UrlStorage\Persistence\SpyUrlStorageQuery
     */
    public function getSpyUrlStorageQuery(): SpyUrlStorageQuery
    {
        return $this->getFactory()->getSpyUrlStorageQuery();
    }

    /**
     * @param string $locale
     * @param bool $paginate
     * @param int|null $page
     * @param int|null $limit
     *
     * @return \Propel\Runtime\Collection\ObjectCollection
     */
    public function findVisibleUrls(string $locale, $paginate = false, ?int $page = null, ?int $limit = null): ObjectCollection
    {
        $locales = $this->getFactory()->getAvailableLocale();
        $localeNames = array_keys(array_flip($locales));

        if ($locale) {
            $localeNames = [$locales[$locale]];
        }

        $localeQuery = $this->getFactory()->getSpyLocaleQuery()->select('IdLocale');
        $localeNamesTxt = implode(',', $localeNames);
        $localeIds = $localeQuery->findBy('LocaleName', $localeNamesTxt);
        $localeIdsArr = implode(',', $localeIds->toArray());

        $query = $this->getFactory()->getSpyUrlStorageQuery()
            ->addJoin(SpyUrlStorageTableMap::COL_FK_URL, SpyUrlTableMap::COL_ID_URL, Criteria::INNER_JOIN)
            ->addJoin(SpyUrlTableMap::COL_FK_LOCALE, SpyLocaleTableMap::COL_ID_LOCALE, Criteria::INNER_JOIN)
            ->withColumn(SpyUrlTableMap::COL_FK_LOCALE, 'ulocale')
            ->add(SpyUrlStorageTableMap::COL_VISIBLE, true)
            ->add(SpyUrlTableMap::COL_FK_LOCALE, $localeIdsArr, Criteria::IN);

        if ($paginate == true && $page !== null && $limit !== null) {
            return $query->paginate($page, $limit)->getResults();
        }

        return $query->find();
    }

    /**
     * @param \Generated\Shared\Transfer\UrlStorageTransfer $urlStorageTransfer
     *
     * @return bool
     */
    public function toggleUrlVisibility(UrlStorageTransfer $urlStorageTransfer): bool
    {
        $urlStorageEntity = $this->getFactory()
            ->getSpyUrlStorageQuery()
            ->findOneByIdUrlStorage($urlStorageTransfer->getIdUrlStorage());

        if (!$urlStorageEntity) {
            return false;
        }

        if ($urlStorageEntity->getFkCategorynode() !== null) {
            $this->toggleUrlVisibilityForCategoryChildren(
                $urlStorageEntity->getFkCategorynode(),
                $urlStorageTransfer->getVisible(),
            );
        }

        $urlStorageEntity->setVisible($urlStorageTransfer->getVisible());

        $urlStorageEntity->save();

        return true;
    }

    /**
     * @param int $fkCategorynode
     * @param bool $isVisible
     *
     * @return void
     */
    protected function toggleUrlVisibilityForCategoryChildren(
        int $fkCategorynode,
        bool $isVisible
    ): void {
        $relatedUrlStorageEntities = $this->getFactory()
            ->getSpyUrlStorageQuery()
            ->findByFkCategorynode($fkCategorynode);

        foreach ($relatedUrlStorageEntities as $relatedUrlStorageEntity) {
            $relatedUrlStorageEntity->setVisible($isVisible);
            $relatedUrlStorageEntity->save();

            $childrenCategoryNodes = $this->getFactory()
                ->getSpyCategoryNodeQuery()
                ->filterByFkParentCategoryNode($fkCategorynode)
                ->find();
            foreach ($childrenCategoryNodes as $childrenCategoryNode) {
                $this->toggleUrlVisibilityForCategoryChildren($childrenCategoryNode->getIdCategoryNode(), $isVisible);
            }
        }
    }
}
