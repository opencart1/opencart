<?php
/*
Author: Denise (rei7092@gmail.com)
Page: http://www.opencart.com/index.php?route=extension/extension/info&token=862f82b6be28a025c788dfff38c7a550&extension_id=26240
*/

class ControllerExtensionModuleLiveSearch extends Controller {
	private $error = array();

	public function index() {
		$extension = version_compare(VERSION, '2.3', '>=') ? 'extension/' : null;
		$this->language->load($extension . 'module/live_search');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('live_search', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if ($extension) {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
			}
			else{
				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['view_all_results'])) {
			$data['error_view_all_results'] = $this->error['view_all_results'];
		} else {
			$data['error_view_all_results'] = '';
		}

		if (isset($this->error['limit'])) {
			$data['error_limit'] = $this->error['limit'];
		} else {
			$data['error_limit'] = '';
		}
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}
		if (isset($this->error['title_length'])) {
			$data['error_title_length'] = $this->error['title_length'];
		} else {
			$data['error_title_length'] = '';
		}
		if (isset($this->error['description_length'])) {
			$data['error_description_length'] = $this->error['description_length'];
		} else {
			$data['error_description_length'] = '';
		}

		if (isset($this->error['min_length'])) {
			$data['error_min_length'] = $this->error['min_length'];
		} else {
			$data['error_min_length'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		    unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link($extension . 'module/live_search', 'token=' . $this->session->data['token'], 'SSL');
		if ($extension) {
			$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL');
		}
		else{
			$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		}

		// Languages
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_success'] = $this->language->get('text_success');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_view_all_results'] = $this->language->get('text_view_all_results');

		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_title_length'] = $this->language->get('entry_title_length');
		$data['entry_description_length'] = $this->language->get('entry_description_length');
		$data['entry_min_length'] = $this->language->get('entry_min_length');
		$data['entry_show_image'] = $this->language->get('entry_show_image');
		$data['entry_show_price'] = $this->language->get('entry_show_price');
		$data['entry_show_description'] = $this->language->get('entry_show_description');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_view_all_results'] = $this->language->get('entry_view_all_results');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['help_length'] = $this->language->get('help_length');
		$data['help_name'] = $this->language->get('help_name');
		$data['help_view_all_results'] = $this->language->get('help_view_all_results');

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($extension . 'module/live_search', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages(array('sort' => 'code'));
		foreach ($data['languages'] as $key => $language) {
			$flag_img = 'view/image/flags/'.$language['image'];
			if (version_compare(VERSION, '2.2', '>=')) {
				$flag_img = 'language/'.$language['code'].'/'.$language['image'];
			}
			if(!is_file($flag_img)){
				$flag_img = 'language/'.$language['code'].'/'.$language['code'].'.png';
				if(!is_file($flag_img)) $flag_img = null;
			}
			$data['languages'][$key]['flag_img'] = $flag_img;
		}
		if (isset($this->request->post['live_search_view_all_results'])) {
			$data['live_search_view_all_results'] = $this->request->post['live_search_view_all_results'];
		} elseif( null !== $this->config->get('live_search_view_all_results') ) {
			$data['live_search_view_all_results'] = $this->config->get('live_search_view_all_results');
		} else {
			$data['live_search_view_all_results'] = array();
		}

		if (isset($this->request->post['live_search_limit'])) {
			$data['live_search_limit'] = $this->request->post['live_search_limit'];
		} else {
			$data['live_search_limit'] = $this->config->get('live_search_limit');
		}
		if (isset($this->request->post['live_search_image_width'])) {
			$data['live_search_image_width'] = $this->request->post['live_search_image_width'];
		} else {
			$data['live_search_image_width'] = $this->config->get('live_search_image_width');
		}
		if (isset($this->request->post['live_search_image_height'])) {
			$data['live_search_image_height'] = $this->request->post['live_search_image_height'];
		} else {
			$data['live_search_image_height'] = $this->config->get('live_search_image_height');
		}
		if (isset($this->request->post['live_search_title_length'])) {
			$data['live_search_title_length'] = $this->request->post['live_search_title_length'];
		} else {
			$data['live_search_title_length'] = $this->config->get('live_search_title_length');
		}
		if (isset($this->request->post['live_search_description_length'])) {
			$data['live_search_description_length'] = $this->request->post['live_search_description_length'];
		} else {
			$data['live_search_description_length'] = $this->config->get('live_search_description_length');
		}

		if (isset($this->request->post['live_search_min_length'])) {
			$data['live_search_min_length'] = $this->request->post['live_search_min_length'];
		} else {
			$data['live_search_min_length'] = $this->config->get('live_search_min_length');
		}

		if (isset($this->request->post['live_search_show_image'])) {
			$data['live_search_show_image'] = $this->request->post['live_search_show_image'];
		} else {
			$data['live_search_show_image'] = $this->config->get('live_search_show_image');
		}
		if (isset($this->request->post['live_search_show_price'])) {
			$data['live_search_show_price'] = $this->request->post['live_search_show_price'];
		} else {
			$data['live_search_show_price'] = $this->config->get('live_search_show_price');
		}
		if (isset($this->request->post['live_search_show_description'])) {
			$data['live_search_show_description'] = $this->request->post['live_search_show_description'];
		} else {
			$data['live_search_show_description'] = $this->config->get('live_search_show_description');
		}
		if (isset($this->request->post['live_search_ajax_status'])) {
			$data['live_search_ajax_status'] = $this->request->post['live_search_ajax_status'];
		} else {
			$data['live_search_ajax_status'] = $this->config->get('live_search_ajax_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        $data['current_lang_id'] = $this->config->get('config_language_id');

		$this->response->setOutput($this->load->view($extension . 'module/live_search.tpl', $data));
	}

	protected function validate() {
		$extension = version_compare(VERSION, '2.3', '>=') ? 'extension/' : null;
		if (!$this->user->hasPermission('modify', $extension . 'module/live_search')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['live_search_view_all_results'] as $language_id => $sort_order) {
			if (!$sort_order['name']) {
				$this->error['view_all_results'][$language_id] = $this->language->get('error_view_all_results');
			}
		}

		if (!$this->request->post['live_search_limit']) {
			$this->error['limit'] = $this->language->get('error_limit');
		}
		if (!$this->request->post['live_search_image_width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		if (!$this->request->post['live_search_image_height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
		if (!$this->request->post['live_search_title_length']) {
			$this->error['title_length'] = $this->language->get('error_title_length');
		}
		if (!$this->request->post['live_search_description_length']) {
			$this->error['description_length'] = $this->language->get('error_description_length');
		}
		if (!$this->request->post['live_search_description_length']) {
			$this->error['description_length'] = $this->language->get('error_description_length');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

}
?>