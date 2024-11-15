<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 14/11/2024
 * @time 15:30
 */

namespace Storage\Entities;

use CodeIgniter\Entity\Entity;

class Item extends Entity
{
    protected $attributes = [
        'id'               => null,
        'item_code'        => null,
        'item_name'        => null,
        'item_price'       => null,
        'item_category_id' => null,
        'item_image'       => null,
        'item_description' => null,
    ];
    protected $casts = [
        'id'               => 'int',
        'item_price'       => 'int',
        'item_category_id' => 'int',
    ];
}
