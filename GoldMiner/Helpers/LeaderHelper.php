<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Helpers;

use Carbon\Carbon;
use Okay\Core\Config;
use Okay\Core\Design;
use Okay\Core\EntityFactory;
use Okay\Core\Modules\Extender\ExtenderFacade;
use Okay\Core\Request;
use Okay\Entities\BrandsEntity;
use Okay\Entities\CategoriesEntity;
use Okay\Entities\PagesEntity;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CountryEntity;
use Okay\Modules\OkayCMS\GoldMiner\Entities\LeaderEntity;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CompanyEntity;
use Okay\Modules\OkayCMS\Banners\Entities\BannersImagesEntity;
use Okay\Core\Database;
use Okay\Core\QueryFactory;

class LeaderHelper
{
    /**
     * @var LeaderEntity
     */
    private $leaderEntity;
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

    private $db;
    private $queryFactory;


    public function __construct(
        EntityFactory $entityFactory,
        Request       $request,
        Design        $design,
        Config        $config,
        QueryFactory  $queryFactory,
        Database      $db,
    ) {
        $this->db                  = $db;
        $this->queryFactory        = $queryFactory;
        $this->leaderEntity = $entityFactory->get(LeaderEntity::class);
        $this->companyEntity = $entityFactory->get(CompanyEntity::class);
        $this->request       = $request;
        $this->design        = $design;
        $this->config        = $config;
        $this->entityFactory = $entityFactory;
    }

    public function generateData()
    {
        $countCompanies = $this->companyEntity->count();
        $currentDate = Carbon::now()->timestamp;
        $arrayOfMonth = [
            '1' => ['days' => floor(Carbon::now()->subMonths(1)->diffInDays())],
            '2' => ['days' => floor(Carbon::now()->subMonths(2)->diffInDays() - Carbon::now()->subMonths(1)->diffInDays())],
            '3' => ['days' => floor(Carbon::now()->subMonths(3)->diffInDays() - Carbon::now()->subMonths(2)->diffInDays())],
            '4' => ['days' => floor(Carbon::now()->subMonths(4)->diffInDays() - Carbon::now()->subMonths(3)->diffInDays())],
            '5' => ['days' => floor(Carbon::now()->subMonths(5)->diffInDays() - Carbon::now()->subMonths(4)->diffInDays())],
            '6' => ['days' => floor(Carbon::now()->subMonths(6)->diffInDays() - Carbon::now()->subMonths(5)->diffInDays())],
        ];

        /** 
         *  Each company of the country has at least one mining gram every month.
         *  Hence we needs minimum quantity of records per month which equivalent to number of all companies 
         */
        $iterator = 1;
        $iteratorDown = 6;
        try {
            $recordsPerMonth = array_reduce($arrayOfMonth, function($accumulator, $item) use (&$iterator, &$iteratorDown, $countCompanies){

                $accumulator[$iterator]['days'] = $item['days'];
                $min = $countCompanies;// each company need have one records per month
                $max = 500 - $min*$iteratorDown;

                $sumPreviousRecords = array_map(function($record){
                    if ($record && array_key_exists('records', $record)) return $record['records'];
                }, $accumulator);

                $max = $max - array_sum($sumPreviousRecords);

                $accumulator[$iterator]['records'] = mt_rand($min, $max);
                $iterator += 1;
                $iteratorDown -= 1;

                return $accumulator;
            });
        }catch(Exception $e){
            /** We can get error:: Uncaught ValueError: mt_rand(): Argument #2 ($max) must be greater than or equal to argument #1 ($min) */
            /** TODO:: need write to logs */
            var_dump($e->getMessage());die;
        }

        /** Test sum of all records ( hould have approximately 50-500 records ) */
        // $sum = array_map(function($record){
        //     if ($record['records']) return $record['records'];
        // }, $recordsPerMonth);
        // print_r('<pre>');print_r(array_sum($sum));print_r('</pre>');die;

        $companies = $this->companyEntity->mappedBy('id')->find();
        $records = [];
        foreach ($recordsPerMonth as $indexMonth => $recordPerMoth){
            //var_dump(Carbon::now()->subMonths($indexMonth)->year);
            /** 
             * A) Firstly we populate every company with record, because "Each company of the country has at least one mining gram every month.".
             * B) Secondly we populate every random company with remaining records after A.
             */
            foreach ($companies as $company){
                $leader = new \stdClass;
                $leader->company = $company->id;

                $datePerMoth = Carbon::now()->subMonths($indexMonth);
                $newDate = Carbon::create($datePerMoth->year, $datePerMoth->month, mt_rand(1, $recordPerMoth['days']), mt_rand(0,23), mt_rand(0,59), mt_rand(0,99), 'GMT');
                
                $leader->date = $newDate->toDateTimeString();
                //var_dump($newDate->toDateTimeString());die;

                $leader->mined = mt_rand(100, 10000) / 1000;
                // print_r('<pre>');print_r($leader);print_r('</pre>');die;
                $insertId = $this->leaderEntity->add($leader);
            }
            for ($i = 0; $i <= $recordPerMoth['records'] - $countCompanies; $i++){
                $leader = new \stdClass;
                shuffle($companies);
                $leader->company = $companies['1']->id;

                $datePerMoth = Carbon::now()->subMonths($indexMonth);
                $newDate = Carbon::create($datePerMoth->year, $datePerMoth->month, mt_rand(1, $recordPerMoth['days']), mt_rand(0,23), mt_rand(0,59), mt_rand(0,99), 'GMT');
                $leader->date = $newDate->toDateTimeString();

                $leader->mined = mt_rand(100, 10000) / 1000;
                //print_r('<pre>');print_r($leader);print_r('</pre>');die;
                $insertId = $this->leaderEntity->add($leader);
            }
        }
    }
    
    public function showReport($year, $month)
    {
        $date_from = $newDate = Carbon::create($year, $month, 0, 0, 0, 0, 'GMT')->toDateTimeString();
        $nextMonth = $month + 1;
        if ( $nextMonth > 12){
            $nextMonth = 1;
            $year += 1;
        }
        $date_to = $newDate = Carbon::create($year, $nextMonth, 0, 0, 0, 0, 'GMT')->toDateTimeString();

        $select = $this->queryFactory->newSelect();
        $select->from('ok_okaycms__gm__leader as gm_l')
            ->cols(['gm_comp.id','SUM(gm_l.mined) as mined', 'gm_comp.name', 'gm_c.plan'])
            ->join('left', 'ok_okaycms__gm__company AS gm_comp', 'gm_l.company = gm_comp.id')
            ->join('left', 'ok_okaycms__gm__country AS gm_c', 'gm_comp.country = gm_c.id')
            ->groupBy(['gm_comp.id'])
            ->having('mined > gm_c.plan')
            ->where("gm_l.date BETWEEN '{$date_from}' AND '{$date_to}'")
            ->orderBy(['mined DESC']);
            
        // print_r('<pre>');print_r($select->__toString());print_r('</pre>');die;
        $this->db->query($select);
        $leaders = $this->db->results();

        // print_r('<pre>');print_r($leaders);print_r('</pre>');die;

        return $leaders;
    }
}