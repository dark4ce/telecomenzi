<?php
/**
 * @author Tomáš Blatný
 */

use Smartsupp\Auth\Api;


require __DIR__ . '/../../smartsupp/vendor/autoload.php';

class ControllerModuleSmartsupp extends Controller
{

	const SETTING_NAME = 'smartsupp';

	public function index()
	{
		$this->load->language('module/smartsupp');
		$this->load->model('setting/setting');

		$settings = $this->model_setting_setting->getSetting(self::SETTING_NAME);
		if (!isset($settings[self::SETTING_NAME . 'firstRun'])) {
			$settings[self::SETTING_NAME . 'firstRun'] = TRUE;

			try {
				require_once __DIR__ . '/../extension/modification.php';
				$controller = new ControllerExtensionModification($this->registry);
				$controller->refresh();
			} catch (Exception $e) {}

			$this->model_setting_setting->editSetting(self::SETTING_NAME, $settings);
		}

		$message = NULL;
		$formAction = NULL;

		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case 'disable':
					$this->model_setting_setting->deleteSetting(self::SETTING_NAME);
					break;
				case 'login':
				case 'register':
					$api = new Api;
					$data = array(
						'email' => $_POST['email'],
						'password' => $_POST['password'],
					);
					$result = $_GET['action'] === 'register' ? $api->create($data + array('lang' => $this->language->get('code'))) : $api->login($data + array('partnerKey' => 'j29hnc919y'));
					if (isset($result['error'])) {
						$message = $result['message'];
						$formAction = $_GET['action'];
						$data['email'] = $_POST['email'];
					} else {
						$this->model_setting_setting->editSetting(self::SETTING_NAME, array(
							self::SETTING_NAME . 'firstRun' => TRUE,
							self::SETTING_NAME . 'email' => $_POST['email'],
							self::SETTING_NAME . 'chatId' => $result['account']['key'],
							self::SETTING_NAME . 'customCode' => ''
						));
					}
					break;
				case 'update':
					$smartsupp = $this->model_setting_setting->getSetting(self::SETTING_NAME);
					$smartsupp[self::SETTING_NAME . 'customCode'] = $_POST['code'];
					$this->model_setting_setting->editSetting(self::SETTING_NAME, $smartsupp);
					$message = 'Custom code was updated.';
					break;
				case 'remove':
					$this->model_setting_setting->deleteSetting(self::SETTING_NAME);
					$this->load->model('extension/modification');
					if ($modification = $this->model_extension_modification->getModificationByCode('smartsupp')) {
						$this->model_extension_modification->deleteModification($modification['modification_id']);
					}

					try {
						require_once __DIR__ . '/../extension/modification.php';
						$controller = new ControllerExtensionModification($this->registry);
						$controller->refresh();
					} catch (Exception $e) {}

					foreach (array(
						__FILE__,
						__DIR__ . '/../../../admin/controller/module/smartsupp.php',
						__DIR__ . '/../../../admin/language/english/module/smartsupp.php',
						__DIR__ . '/../../../admin/view/javascript/smartsupp.js',
						__DIR__ . '/../../../admin/view/stylesheet/smartsupp.css',
						__DIR__ . '/../../../admin/view/template/module/smartsupp.tpl',
						__DIR__ . '/../../../catalog/controller/module/smartsupp.php',
						__DIR__ . '/../../../catalog/language/english/module/smartsupp.php',
						__DIR__ . '/../../../catalog/view/theme/default/template/module/smartsupp.tpl',
					) as $file) {
						@unlink($file);
					}

					foreach (array(
						__DIR__ . '/../../../admin/smartsupp',
						__DIR__ . '/../../../admin/view/image/smartsupp',
					) as $dir) {
						$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
						foreach ($iterator as $file) {
							$file->isDir() ? @rmdir($file) : @unlink($file);
						}
					}

					break;
			}
		}

		$that = $this;
		$data['_'] = $_ = function ($text) use ($that) {
			return $that->language->get($text);
		};

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$base = $this->config->get('site_ssl');
		} else {
			$base = $this->config->get('site_base');
		}

		$base = rtrim($base, '/\\');

		$this->document->addScript($base . '/view/javascript/smartsupp.js');
		$this->document->addStyle($base . '/view/stylesheet/bootstrap-smartsupp.css');
		$this->document->addStyle($base . '/view/stylesheet/smartsupp.css');
		$this->document->setTitle($title = $_('headingTitle'));

		$settings = $this->model_setting_setting->getSetting(self::SETTING_NAME);
		if (isset($settings[self::SETTING_NAME . 'email'])) {
			$data['email'] = $settings[self::SETTING_NAME . 'email'];
			$data['enabled'] = TRUE;
		} else {
			$data['enabled'] = FALSE;
		}
		if (isset($settings[self::SETTING_NAME . 'customCode'])) {
			$data['customCode'] = $settings[self::SETTING_NAME . 'customCode'];
		}
		$data['base'] = $base;
		$data['headingTitle'] = $title;

		if (isset($_GET['action'])) {
			$data['header'] = '';
			$data['leftMenu'] = '';
			$data['footer'] = '';
		} else {
			$data['header'] = $this->load->controller('common/header');
			$data['leftMenu'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
		}

		$data['message'] = $message;
		$data['formAction'] = $formAction;

		$this->response->setOutput($this->load->view('module/smartsupp.tpl', $data));
	}

}
