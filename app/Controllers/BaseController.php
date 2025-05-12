<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;
use App\Models\M_log;
use App\Models\M_setting;
use App\Models\M_menu;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $settingModel;

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */

	 public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	 {
		 parent::initController($request, $response, $logger);
	 
		 $id_role = session()->get('level');
		 $menuModel = new M_menu();
		 $menuList = $menuModel->getMenuByRole($id_role);
	 
		 $groupedMenu = [];
	 
		 foreach ($menuList as $menu) {
			 $parentId = $menu->parent_id ?? 0;
			 $groupedMenu[$parentId][] = $menu;
		 }
	 
		foreach ($groupedMenu[0] ?? [] as $key => $parentMenu) {
			$idParent = $parentMenu->id_menu;
		}

		 Services::renderer()->setVar('menus', $groupedMenu);
	 
		 $this->settingModel = new M_setting();
		 $setting = $this->settingModel->getSetting();
	 
		 if (!$setting) {
			 $setting = [
				 'nama' => 'Website Default',
				 'foto' => 'default-logo.png'
			 ];
		 }
	 
		 Services::renderer()->setVar('setting', $setting);
	 }
	 
	protected function logActivity($aktivitas)
    {
        $M_log = new M_log();

        $id_user = session()->get('id_user');
        if (!$id_user) return;

        $ip_address = $this->request->getIPAddress();

        $M_log->saveLog($id_user, $aktivitas, $ip_address);
    }
}
