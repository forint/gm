<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Backend\Controllers;


use Okay\Admin\Controllers\IndexAdmin;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CountryEntity;
use Okay\Entities\BrandsEntity;
use Okay\Entities\CategoriesEntity;
use Okay\Entities\PagesEntity;
use Okay\Modules\OkayCMS\GoldMiner\Helpers\CompanyHelper;
use Okay\Modules\OkayCMS\GoldMiner\Requests\CompanyRequest;

class CompanyAdmin extends IndexAdmin
{
    public function fetch(
        CountryEntity $countryEntity,
        CompanyRequest $companyRequest,
        CompanyHelper $companyHelper
    ) {
        $countries      = $countryEntity->find();

        /*Принимаем данные о группе баннеров*/
        if ($this->request->method('POST')) {

            $company = $companyRequest->postCompany();
            if (empty($company->id)) {
                /*Добавляем/обновляем группу баннеров*/
                $preparedCompany = $companyHelper->prepareAdd($company);
                $company->id = $companyHelper->add($preparedCompany);
                $this->postRedirectGet->storeMessageSuccess('added');
                $this->postRedirectGet->storeNewEntityId($company->id);
            } else {
                $preparedCompany = $companyHelper->prepareUpdate($company);
                $companyHelper->update($preparedCompany->id, $preparedCompany);
                $this->postRedirectGet->storeMessageSuccess('updated');
            }
            $company = $companyHelper->addSelectedEntities($company);
            $this->postRedirectGet->redirect();
        } else {
            $companyId = $this->request->get('id', 'integer');

            // Если пришли с меню быстрого редактирования
            if ($companySlideId = $this->request->get('company_slide_id')) {
                list($companyId, $slideId) = explode(':', $companySlideId);
            }
            
            $company   = $companyHelper->getCompany((int)$companyId);
            $company   = $companyHelper->getSelectedEntities($company);
        }
        
        //print_r('<pre>');print_r($company);print_r('</pre>');die;
        $this->design->assign('company',     $company);
        $this->design->assign('countries',      $countries);
        
        $this->response->setContent($this->design->fetch('company.tpl'));
    }
}
