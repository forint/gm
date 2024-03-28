<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Backend\Controllers;


use Okay\Modules\OkayCMS\GoldMiner\Entities\CompanyEntity;
use Okay\Admin\Controllers\IndexAdmin;
use Okay\Core\EntityFactory;
use Okay\Modules\OkayCMS\GoldMiner\Helpers\CompanyHelper;

class CompaniesAdmin extends IndexAdmin
{
    public function fetch(
        CompanyEntity $companyEntity,
        CompanyHelper $companyHelper
    ) {
        $filter = $companyHelper->buildFilter();
        
        /*Принимаем выбранные группы баннеров*/
        if ($this->request->method('post')) {
            $ids = $this->request->post('check');
            if (is_array($ids)) {
                switch ($this->request->post('action')) {
                    case 'disable': {
                        /*Выключаем группы баннеров*/
                        $companyEntity->update($ids, ['visible'=>0]);
                        break;
                    }
                    case 'enable': {
                        /*Включаем группы банннеров*/
                        $companyEntity->update($ids, ['visible'=>1]);
                        break;
                    }
                    case 'delete': {
                        /*Удаляем группы баннеров*/
                        $companyEntity->delete($ids);
                        break;
                    }
                }
            }
            
            // Сортировка
            $positions = $this->request->post('positions');
            $ids = array_keys($positions);
            sort($positions);
            foreach($positions as $i=>$position) {
                $companyEntity->update($ids[$i], ['position'=>$position]);
            }
        }

        $companiesCount              = $companyHelper->countCompanies($filter);
        list($filter, $pagesCount) = $companyHelper->makePagination($companiesCount, $filter);
        $companies = $companyHelper->getCompaniesListForAdmin($filter);

        $this->design->assign('companies_count', $companiesCount);
        $this->design->assign('pages_count', $pagesCount);
        $this->design->assign('current_page', $filter['page']);

        $this->design->assign('companies', $companies);

        $this->response->setContent($this->design->fetch('companies.tpl'));
    }
}