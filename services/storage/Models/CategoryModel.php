<?php
/**
 * @project ptpmhdv-nhom-7
 * @email honghoaphong19@gmail.com
 * @date 14/11/2024
 * @time 15:24
 */

namespace Storage\Models;

use CodeIgniter\Model;
use Storage\Entities\Category;

class CategoryModel extends Model
{
    protected $table         = 'categories';
    protected $primaryKey    = 'id';
    protected $returnType    = Category::class;
    protected $allowedFields = [
        'category_name',
    ];
    protected $validationRules = [
        'category_name' => 'required|alpha_numeric_space',
    ];
    protected $validationMessages = [
        'category_name' => [
            'required'      => 'Category is required.',
            'alpha_numeric' => 'Category must be alphanumeric.',
        ],
    ];
}
