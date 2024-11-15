<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 14/11/2024
 * @time 15:23
 */

namespace Storage\Entities;

use CodeIgniter\Entity\Entity;

class Category extends Entity
{
    protected $attributes = [
        'id'            => null,
        'category_name' => null,
    ];
    protected $casts = [
        'id' => 'int',
    ];
}
