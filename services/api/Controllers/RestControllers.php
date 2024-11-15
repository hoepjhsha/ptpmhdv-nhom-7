<?php
/**
 * @project ptpmhdv-nhom-7
 * @email hiepnguyen3624@gmail.com
 * @date 14/11/2024
 * @time 14:59
 */

namespace Api\Controllers;

use CodeIgniter\RESTful\ResourceController;

/**
 * Class RestController.
 *
 * RestController provides a convenient place for loading components
 * and performing functions that are needed by all your API controllers.
 * Extend this class in any new API controllers:
 *
 * ```
 *     class Home extends RestController
 * ```
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class RestControllers extends ResourceController
{
    /**
     * @var string Define how to format the response data
     */
    protected $format = 'json';
}
