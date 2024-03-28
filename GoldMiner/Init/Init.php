<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Init;


use Okay\Core\Modules\EntityField;
use Okay\Core\Modules\AbstractInit;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CountryEntity;
use Okay\Modules\OkayCMS\GoldMiner\Entities\CompanyEntity;
use Okay\Modules\OkayCMS\GoldMiner\Entities\LeaderEntity;

class Init extends AbstractInit
{
    const PERMISSION = 'okaycms_gold_miners';

    public function install()
    {
        $this->setBackendMainController('CountriesAdmin');
        $this->migrateEntityTable(CountryEntity::class, [
            (new EntityField('id'))->setIndexPrimaryKey()->setTypeInt(11, false)->setAutoIncrement(),
            (new EntityField('name'))->setTypeText()->setIsLang(),
            (new EntityField('code'))->setTypeText()->setIndexUnique(),
            (new EntityField('plan'))->setTypeDecimal('10,3'),
            (new EntityField('position'))->setTypeInt(11)->setDefault(0)->setIndex(),
            (new EntityField('visible'))->setTypeTinyInt(1, true)->setDefault(1)->setIndex(),
        ]);
        $this->setBackendMainController('CompaniesAdmin');
        $this->migrateEntityTable(CompanyEntity::class, [
            (new EntityField('id'))->setIndexPrimaryKey()->setTypeInt(11, false)->setAutoIncrement(),
            (new EntityField('name'))->setTypeText()->setIsLang(),
            (new EntityField('email'))->setTypeText()->setIsLang()->setNullable(),
            (new EntityField('country'))->setTypeTinyInt(1)->setIsLang(),
            (new EntityField('position'))->setTypeInt(11)->setDefault(0)->setIndex(),
            (new EntityField('visible'))->setTypeTinyInt(1, true)->setDefault(1)->setIndex(),
        ]);
        $this->setBackendMainController('LeadersAdmin');
        $this->migrateEntityTable(LeaderEntity::class, [
            (new EntityField('id'))->setIndexPrimaryKey()->setTypeInt(11, false)->setAutoIncrement(),
            (new EntityField('company'))->setTypeTinyInt(1),
            (new EntityField('date'))->setTypeDatetime(),
            (new EntityField('mined'))->setTypeDecimal('10,3'),
            (new EntityField('position'))->setTypeInt(11)->setDefault(0)->setIndex(),
            (new EntityField('visible'))->setTypeTinyInt(1, true)->setDefault(1)->setIndex(),
        ]);
    }
    
    public function init()
    {
        $this->registerBackendController('CountriesAdmin');
        $this->registerBackendController('CountryAdmin');
        $this->registerBackendController('CompanyAdmin');
        $this->registerBackendController('CompaniesAdmin');
        $this->registerBackendController('LeadersAdmin');
        
        $this->addBackendControllerPermission('CountriesAdmin', self::PERMISSION);
        $this->addBackendControllerPermission('CountryAdmin', self::PERMISSION);
        $this->addBackendControllerPermission('CompanyAdmin', self::PERMISSION);
        $this->addBackendControllerPermission('CompaniesAdmin', self::PERMISSION);
        $this->addBackendControllerPermission('LeadersAdmin', self::PERMISSION);


        $this->extendUpdateObject('okay_cms__countries', self::PERMISSION, CountriesEntity::class);
        $this->extendUpdateObject('okay_cms__companies', self::PERMISSION, CompaniesEntity::class);
        $this->extendUpdateObject('okay_cms__leaders', self::PERMISSION, LeadersEntity::class);

        $this->extendBackendMenu('left_gm_title', [
            'left_gm_company_title' => ['CompaniesAdmin', 'CompanyAdmin'],
            'left_gm_country_title' => ['CountriesAdmin', 'CountryAdmin'],
            'left_gm_leaders_title' => ['LeadersAdmin'],
        ]);
    }
}