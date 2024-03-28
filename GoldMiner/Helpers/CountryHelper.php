<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Helpers;


use Okay\Core\Config;
use Okay\Core\Design;
use Okay\Core\EntityFactory;
use Okay\Core\Modules\Extender\ExtenderFacade;
use Okay\Core\Request;
use Okay\Entities\BrandsEntity;
use Okay\Entities\CategoriesEntity;
use Okay\Entities\PagesEntity;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CountryEntity;
use Okay\Modules\OkayCMS\Banners\Entities\BannersImagesEntity;


class CountryHelper
{
    /**
     * @var CountryEntity
     */
    private $countryEntity;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Design
     */
    private $design;

    private $config;

    /**
     * @var EntityFactory
     */
    private $entityFactory;

    public function __construct(
        EntityFactory $entityFactory,
        Request       $request,
        Design        $design,
        Config        $config
    ) {
        $this->countryEntity = $entityFactory->get(CountryEntity::class);
        $this->request       = $request;
        $this->design        = $design;
        $this->config        = $config;
        $this->entityFactory = $entityFactory;
    }

    public function prepareAdd($country)
    {
        return ExtenderFacade::execute(__METHOD__, $country, func_get_args());
    }

    public function add($country)
    {
        $insertId = $this->countryEntity->add($country);
        return ExtenderFacade::execute(__METHOD__, $insertId, func_get_args());
    }

    public function prepareUpdate($country)
    {
        return ExtenderFacade::execute(__METHOD__, $country, func_get_args());
    }

    public function update($id, $country)
    {
        $this->countryEntity->update($id, $country);
        return ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function addSelectedEntities($country)
    {
        return ExtenderFacade::execute(__METHOD__, $country, func_get_args());
    }

    public function getCountry($id)
    {
        $country = $this->countryEntity->get($id);
        return ExtenderFacade::execute(__METHOD__, $country, func_get_args());
    }

    public function getSelectedEntities($country)
    {
        return ExtenderFacade::execute(__METHOD__, $country, func_get_args());
    }

    public function getShowOnFilter()
    {
        $showOnFilter = [];
        if ($category = $this->design->getVar('category')) {
            $showOnFilter['categories'] = $category->id;
        }

        if ($brand = $this->design->getVar('brand')) {
            $showOnFilter['brands'] = $brand->id;
        }

        if ($page = $this->design->getVar('page')) {
            $showOnFilter['pages'] = $page->id;
        }

        $this->design->assign('page', $page);

        return ExtenderFacade::execute(__METHOD__, $showOnFilter, func_get_args());
    }

    public function getCountriesListForAdmin($filter)
    {
        $countries = $this->countryEntity->mappedBy('id')->find($filter);

        return ExtenderFacade::execute(__METHOD__, $countries, func_get_args());
    }

    public function buildFilter()
    {
        $filter = [];
        $filter['page'] = max(1, $this->request->get('page', 'integer'));
        $filter['limit'] = 20;
        
        return ExtenderFacade::execute(__METHOD__, $filter, func_get_args());
    }

    public function countCountry($filter)
    {
        $countriesCount = $this->countryEntity->count($filter);
        return ExtenderFacade::execute(__METHOD__, $countriesCount, func_get_args());
    }

    public function makePagination($countriesCount, $filter)
    {
        if ($this->request->get('page') == 'all') {
            $filter['limit'] = $countriesCount;
        }

        if ($filter['limit'] > 0) {
            $pagesCount = ceil($countriesCount/$filter['limit']);
        } else {
            $pagesCount = 0;
        }

        $filter['page'] = min($filter['page'], $pagesCount);

        return [$filter, $pagesCount];
    }
    
}