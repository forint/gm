<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Entities;


use Okay\Core\Entity\Entity;

class CountryEntity extends Entity
{
    protected static $fields = [
        'id',
        'name',
        'code',
        'plan',
        'visible',
    ];

    protected static $defaultOrderFields = [
        'position',
    ];

    protected static $table = '__okaycms__gm__country';
    protected static $tableAlias = 'gm_c';

}