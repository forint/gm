<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Entities;


use Okay\Core\Entity\Entity;

class CompanyEntity extends Entity
{
    protected static $fields = [
        'id',
        'name',
        'email',
        'country',
        'visible',
    ];

    protected static $defaultOrderFields = [
        'position',
    ];

    protected static $table = '__okaycms__gm__company';
    protected static $tableAlias = 'gm_comp';
}