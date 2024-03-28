<?php


namespace Okay\Modules\OkayCMS\GoldMiner\Entities;


use Okay\Core\Entity\Entity;

class LeaderEntity extends Entity
{
    protected static $fields = [
        'id',
        'company',
        'date',
        'mined',
        'visible',
        'position',
    ];

    protected static $defaultOrderFields = [
        'position',
    ];

    protected static $table = '__okaycms__gm__leader';
    protected static $tableAlias = 'gm_l';

    
}