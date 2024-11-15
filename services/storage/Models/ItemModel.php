<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 14/11/2024
 * @time 15:33
 */

namespace Storage\Models;

use CodeIgniter\Model;
use Storage\Entities\Item;

class ItemModel extends Model
{
    protected $table         = 'items';
    protected $primaryKey    = 'id';
    protected $returnType    = Item::class;
    protected $allowedFields = [
        'item_code',
        'item_name',
        'item_price',
        'item_category_id',
        'item_image',
        'item_description',
    ];
    protected $validationRules = [
        'item_code'        => 'required|numeric|integer',
        'item_name'        => 'required',
        'item_price'       => 'required|numeric',
        'item_category_id' => 'required|numeric|integer',
        'item_image'       => 'required',
        'item_description' => 'required',
    ];
    protected $validationMessages = [
        'item_code' => [
            'required' => 'Item code is required.',
            'numeric'  => 'Item code must be a numeric value.',
            'integer'  => 'Item code must be an integer value.',
        ],
        'item_name' => [
            'required' => 'Item name is required.',
        ],
        'item_price' => [
            'required' => 'Item price is required.',
            'numeric'  => 'Item price must be a numeric value.',
        ],
        'item_category_id' => [
            'required' => 'Item category ID is required.',
            'numeric'  => 'Item category ID must be a numeric value.',
            'integer'  => 'Item category ID must be an integer value.',
        ],
        'item_image' => [
            'required' => 'Item image is required.',
        ],
        'item_description' => [
            'required' => 'Item description is required.',
        ],
    ];
}
