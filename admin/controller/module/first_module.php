<?php
/**
 * Webkul Software.
 *
 * @category Webkul
 * @package Opencart Module Tutorial
 * @author Webkul
 * @copyright Copyright (c) 2010-2016 Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */
/**
 * The controller class must extend the parent class i.e. Controller
 * The controller name must be like Controller + directory path (with first character of each folder in capital) + file name (with first character in capital)
 * For version 2.3.0.0 and upper, the name of the controller must be ControllerExtensionModuleFirstModule
 */
class ControllerModuleFirstModule extends Controller {
    /**
     * property named $error is defined to put errors
     * @var array
     */
    private $error = array();
    /**
     * Basic function of the controller. This can be called using route=module/first_module
     */
    public function index() {
        /**
         * Loads the language file. Path of the file along with file name must be given
         */
        $this->load->language('module/first_module');
        /**
         * Sets the title to the html page
         */
        $this->document->setTitle($this->language->get('heading_title'));
        /**
         * Loads the model file. Path of the file to be given
         */
        $this->load->model('setting/setting');
        /**
         * Checks whether the request type is post. If yes, then calls the validate function.
         */
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            /**
             * The function named 'editSetting' of a model is called in this way
             * The first argument is the code of the module and the second argument contains all the post values
             * The code must be same as your file name
             */
            $this->model_setting_setting->editSetting('first_module', $this->request->post);
            /**
             * The success message is kept in the session
             */
            $this->session->data['success'] = $this->language->get('text_success');
            /**
             * The redirection works in this way.
             * After insertion of data, it will redirect to extension/module file along with the token
             * The success message will be shown there
             */
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
        }
        /**
         * Putting the language into the '$data' array
         * This is the way how you get the language from the language file
         */
        $data['heading_title'] = $this->language->get('heading_title');
 
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
 
        $data['entry_status'] = $this->language->get('entry_status');
 
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        /**
         * If there is any warning in the private property '$error', then it will be put into '$data' array
         */
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        /**
         * Breadcrumbs are declared as array
         */
        $data['breadcrumbs'] = array();
        /**
         * Breadcrumbs are defined
         */
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );
 
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
        );
 
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/first_module', 'token=' . $this->session->data['token'], true)
        );
        /**
         * Form action url is created and defined to $data['action']
         */
        $data['action'] = $this->url->link('module/first_module', 'token=' . $this->session->data['token'], true);
        /**
         * Cancel/back button url which will lead you to module list
         */
        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
        /**
         * checks whether the value exists in the post request
         */
        if (isset($this->request->post['first_module_status'])) {
            $data['first_module_status'] = $this->request->post['first_module_status'];
        } else {
        /**
         * if the value do not exists in the post request then value is taken from the config i.e. setting table
         */
            $data['first_module_status'] = $this->config->get('first_module_status');
        }
        /**
         * Header data is loaded
         */
        $data['header'] = $this->load->controller('common/header');
        /**
         * Column left part is loaded
         */
        $data['column_left'] = $this->load->controller('common/column_left');
        /**
         * Footer data is loaded
         */
        $data['footer'] = $this->load->controller('common/footer');
        /**
         * Using this function tpl file is called and all the data of controller is passed through '$data' array
         * This is for Opencart 2.2.0.0 version. There will be minor changes as per the version.
         */
        $this->response->setOutput($this->load->view('module/first_module', $data));
    }
    /**
     * validate function validates the values of the post and also the permission
     * @return boolean return true if any of the index of $error contains value
     */
    protected function validate() {
        /**
         * Check whether the current user has the permissions to modify the settings of the module
         * The permissions are set in System->Users->User groups
         */
        if (!$this->user->hasPermission('modify', 'module/first_module')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
 
        return !$this->error;
    }
}