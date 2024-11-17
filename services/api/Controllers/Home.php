<?php
/**
 * @project ptpmhdv-nhom-7
 * @email honghoaphong19@gmail.com
 * @date 14/11/2024
 * @time 15:01
 */

namespace Api\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class Home.
 *
 * This is the default API controller.
 */
class Home extends RestControllers
{
    /**
     * Default action.
     */
    public function index(): ResponseInterface
    {
        return $this->respond('Hoep');
    }
}
