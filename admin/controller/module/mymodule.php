<?php
class ControllerModuleMymodule extends Controller {
	private $error = array();

	public function index() {
		/* Load language file. */
		$this->load->language('module/mymodule');

		$this->document->setTitle($this->language->get('heading_title'));

		/* Check if data has been posted back. */
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('mymodule', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->cache->delete('mymodule');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		/* Load language strings. */
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_module'] = $this->language->get('text_module');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		/* Loading up some URLS. */
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['form_action'] = $this->url->link('module/mymodule', 'token=' . $this->session->data['token'], 'SSL');

		/* Present error messages to users. */
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


		/* Initial values for form. */
		if (isset($this->request->post['mymodule_title'])) {
			$data['mymodule_title'] = $this->request->post['mymodule_title'];
		} else {
			$data['mymodule_title'] = $this->config->get('mymodule_title');
		}
		
		if (isset($this->request->post['mymodule_text'])) {
			$data['mymodule_text'] = $this->request->post['mymodule_text'];
		} else {
			$data['mymodule_text'] = $this->config->get('mymodule_text');
		}

		if (isset($this->request->post['mymodule_status'])) {
			$data['mymodule_status'] = $this->request->post['mymodule_status'];
		} else {
			$data['mymodule_status'] = $this->config->get('mymodule_status');
		}

		/* Breadcrumb. */
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/mymodule', 'token=' . $this->session->data['token'], 'SSL')
		);

		/* Render some output. */
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/mymodule.tpl', $data));
	}

	/* Check user input. */
	private function validate() {
		if (strlen($this->request->post['mymodule_title']) <= 3) {
			$this->error['warning'] = $this->language->get('error_title');
		}

		if ($this->error) {
			return false;
		} else {
			return true;
		}
	}
}