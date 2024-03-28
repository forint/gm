<?php


namespace Okay\Modules\OkayCMS\GoldMiner;


use Okay\Core\Config;
use Okay\Core\Database;
use Okay\Core\Design;
use Okay\Core\EntityFactory;
use Okay\Core\Image;
use Okay\Core\Languages;
use Okay\Core\Modules\Module;
use Okay\Core\OkayContainer\Reference\ParameterReference as PR;
use Okay\Core\OkayContainer\Reference\ServiceReference as SR;
use Okay\Core\QueryFactory;
use Okay\Core\Request;
use Okay\Modules\OkayCMS\GoldMiner\Helpers\CountryHelper;
use Okay\Modules\OkayCMS\GoldMiner\Helpers\CompanyHelper;
use Okay\Modules\OkayCMS\GoldMiner\Helpers\LeaderHelper;
use Okay\Modules\OkayCMS\GoldMiner\Requests\CountriesRequest;
use Okay\Modules\OkayCMS\GoldMiner\Requests\CompanyRequest;

return [

    CountriesRequest::class => [
        'class' => CountriesRequest::class,
        'arguments' => [
            new SR(Request::class),
        ],
    ],
    CompanyRequest::class => [
        'class' => CompanyRequest::class,
        'arguments' => [
            new SR(Request::class),
        ],
    ],
    CountryHelper::class => [
        'class' => CountryHelper::class,
        'arguments' => [
            new SR(EntityFactory::class),
            new SR(Request::class),
            new SR(Design::class),
            new SR(Config::class),
        ],
    ],
    CompanyHelper::class => [
        'class' => CompanyHelper::class,
        'arguments' => [
            new SR(EntityFactory::class),
            new SR(Request::class),
            new SR(Design::class),
            new SR(Config::class),
        ],
    ],
    LeaderHelper::class => [
        'class' => LeaderHelper::class,
        'arguments' => [
            new SR(EntityFactory::class),
            new SR(Request::class),
            new SR(Design::class),
            new SR(Config::class),
            new SR(QueryFactory::class),
            new SR(Database::class),
        ],
    ],
];