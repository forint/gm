<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Backend\Controllers;


use Okay\Admin\Controllers\IndexAdmin;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CountryEntity;
use Okay\Modules\OkayCMS\GoldMiner\Helpers\CountryHelper;

class CountriesAdmin extends IndexAdmin
{
    public function fetch(
        CountryEntity $countryEntity,
        CountryHelper $countryHelper
    ) {

        $filter = $countryHelper->buildFilter();
        
        /*Принимаем выбранные группы баннеров*/
        if ($this->request->method('post')) {
            $ids = $this->request->post('check');
            if (is_array($ids)) {
                switch ($this->request->post('action')) {
                    case 'disable': {
                        /*Выключаем группы баннеров*/
                        $countryEntity->update($ids, ['visible'=>0]);
                        break;
                    }
                    case 'enable': {
                        /*Включаем группы банннеров*/
                        $countryEntity->update($ids, ['visible'=>1]);
                        break;
                    }
                    case 'delete': {
                        /*Удаляем группы баннеров*/
                        $countryEntity->delete($ids);
                        break;
                    }
                }
            }
            
            // Сортировка
            $positions = $this->request->post('positions');
            $ids = array_keys($positions);
            sort($positions);
            foreach($positions as $i=>$position) {
                $countryEntity->update($ids[$i], ['position'=>$position]);
            }
        }

        $countriesCount              = $countryHelper->countCountry($filter);
        list($filter, $pagesCount) = $countryHelper->makePagination($countriesCount, $filter);
        $countries = $countryHelper->getCountriesListForAdmin($filter);
   
        $this->design->assign('countries_count', $countriesCount);
        $this->design->assign('pages_count', $pagesCount);
        $this->design->assign('current_page', $filter['page']);
        
        $this->design->assign('countries', $countries);

        $this->response->setContent($this->design->fetch('countries.tpl'));
    }
    
}
