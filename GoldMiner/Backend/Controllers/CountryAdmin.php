<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Backend\Controllers;


use Okay\Admin\Controllers\IndexAdmin;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CountryEntity;
use Okay\Entities\BrandsEntity;
use Okay\Entities\CategoriesEntity;
use Okay\Modules\OkayCMS\GoldMiner\Helpers\CountryHelper;
use Okay\Modules\OkayCMS\GoldMiner\Requests\CountriesRequest;

class CountryAdmin extends IndexAdmin
{
    public function fetch(
        CountryEntity $countryEntity,
        CountriesRequest $countriesRequest,
        CountryHelper $countryHelper
    ) {
        $countries      = $countryEntity->find();

        /*Принимаем данные о группе баннеров*/
        if ($this->request->method('POST')) {

            $country = $countriesRequest->postCountry();
            if (empty($country->id)) {
                /*Добавляем/обновляем группу баннеров*/
                $preparedBanner = $countryHelper->prepareAdd($country);
                $country->id = $countryHelper->add($preparedBanner);
                $this->postRedirectGet->storeMessageSuccess('added');
                $this->postRedirectGet->storeNewEntityId($country->id);
            } else {
                $preparedBanner = $countryHelper->prepareUpdate($country);
                $countryHelper->update($preparedBanner->id, $preparedBanner);
                $this->postRedirectGet->storeMessageSuccess('updated');
            }
            $country = $countryHelper->addSelectedEntities($country);
            $this->postRedirectGet->redirect();
        } else {
            $countryId = $this->request->get('id', 'integer');

            // Если пришли с меню быстрого редактирования
            if ($countrySlideId = $this->request->get('country_slide_id')) {
                list($countryId, $slideId) = explode(':', $countrySlideId);
            }
            
            $country   = $countryHelper->getCountry((int)$countryId);
            $country   = $countryHelper->getSelectedEntities($country);
        }

        $this->design->assign('country',     $country);
        
        $this->response->setContent($this->design->fetch('country.tpl'));
    }
}
