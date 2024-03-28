<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Helpers;


use Okay\Core\Config;
use Okay\Core\Design;
use Okay\Core\EntityFactory;
use Okay\Core\Modules\Extender\ExtenderFacade;
use Okay\Core\Request;
use Okay\Entities\PagesEntity;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CompanyEntity;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CountryEntity;


class CompanyHelper
{
    /**
     * @var CompanyEntity
     */
    private $companyEntity;

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
        $this->companyEntity = $entityFactory->get(CompanyEntity::class);
        $this->request       = $request;
        $this->design        = $design;
        $this->config        = $config;
        $this->entityFactory = $entityFactory;
    }

    public function prepareAdd($company)
    {
        return ExtenderFacade::execute(__METHOD__, $company, func_get_args());
    }

    public function add($company)
    {
        $insertId = $this->companyEntity->add($company);
        return ExtenderFacade::execute(__METHOD__, $insertId, func_get_args());
    }

    public function prepareUpdate($company)
    {
        return ExtenderFacade::execute(__METHOD__, $company, func_get_args());
    }

    public function update($id, $company)
    {
        $this->companyEntity->update($id, $company);
        return ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function addSelectedEntities($company)
    {
        return ExtenderFacade::execute(__METHOD__, $company, func_get_args());
    }

    public function getCompany($id)
    {
        $company = $this->companyEntity->get($id);
        return ExtenderFacade::execute(__METHOD__, $company, func_get_args());
    }

    public function getSelectedEntities($company)
    {
        return ExtenderFacade::execute(__METHOD__, $company, func_get_args());
    }

    public function getCompaniesListForAdmin($filter)
    {
        $companies = $this->companyEntity->mappedBy('id')->find($filter);

        if ($companies) {
            $countries = $this->entityFactory->get(CountryEntity::class)->find();

            foreach ($companies as $company){
                $company->country_selected  = $company->country;
      
                foreach ($countries as $c){
                    if ($c->id == $company->country_selected){
                        $company->country_show[] = $c;
                    }
                }
            }
        }
        return ExtenderFacade::execute(__METHOD__, $companies, func_get_args());
    }

    public function buildFilter()
    {
        $filter = [];
        $filter['page'] = max(1, $this->request->get('page', 'integer'));
        $filter['limit'] = 20;
        
        return ExtenderFacade::execute(__METHOD__, $filter, func_get_args());
    }

    public function countCompanies($filter)
    {
        $companiesCount = $this->companyEntity->count($filter);
        return ExtenderFacade::execute(__METHOD__, $companiesCount, func_get_args());
    }

    public function makePagination($companiesCount, $filter)
    {
        if ($this->request->get('page') == 'all') {
            $filter['limit'] = $companiesCount;
        }

        if ($filter['limit'] > 0) {
            $pagesCount = ceil($companiesCount/$filter['limit']);
        } else {
            $pagesCount = 0;
        }

        $filter['page'] = min($filter['page'], $pagesCount);

        return [$filter, $pagesCount];
    }
    
}