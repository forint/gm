<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Backend\Controllers;

use Carbon\Carbon;
use Okay\Admin\Controllers\IndexAdmin;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CountryEntity;
use Okay\Entities\BrandsEntity;
use Okay\Entities\CategoriesEntity;
use Okay\Entities\PagesEntity;
use Okay\Modules\OkayCMS\GoldMiner\Helpers\LeaderHelper;
use Okay\Modules\OkayCMS\GoldMiner\Requests\CountriesRequest;


class LeadersAdmin extends IndexAdmin
{

    public function fetch(
        CountryEntity $countryEntity,
        LeaderHelper $leaderHelper
    ) {

        $filter = ['year' => null, 'month' => null];
        $filter['year'] = $this->request->post('year');
        $filter['month'] = $this->request->post('month');

        $countries      = $countryEntity->find();

        /*Принимаем данные о группе баннеров*/
        if ($this->request->method('POST')) {
            if ($this->request->post('generate_data')){
                $leaderHelper->generateData();
                $this->postRedirectGet->storeMessageSuccess('added');
                $this->postRedirectGet->redirect();
            }elseif ($this->request->post('show_report')){
                $year = $this->request->post('year');
                $month = $this->request->post('month');

                $leaders = $leaderHelper->showReport($year, $month);
            }

        }
        
        $yearFrom = Carbon::now()->subMonths(6)->year;
        $yearTo = Carbon::now()->year;
        
        $this->design->assign('year_from', $yearFrom);
        $this->design->assign('year_to', $yearTo);
        // print_r('<pre>');print_r($leaders);print_r('</pre>');die;
        $this->design->assign('filter', $filter);
        $this->design->assign('leaders', $leaders);

        $this->response->setContent($this->design->fetch('leaders.tpl'));
    }
}
