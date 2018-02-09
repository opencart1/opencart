<?php
class ControllerDashboardRecentcustomers extends Controller {
  public function index() {
    $this->load->language('dashboard/recentcustomers');
 
    $data['heading_title'] = $this->language->get('heading_title');
     
    $data['column_customer_id'] = $this->language->get('column_customer_id');
    $data['column_customer_name'] = $this->language->get('column_customer_name');
    $data['column_customer_email'] = $this->language->get('column_customer_email');
    $data['column_date_added'] = $this->language->get('column_date_added');
    $data['text_no_results'] = $this->language->get('text_no_results');
 
    $data['recentcustomers'] = array();
 
    $this->load->model('report/recentcustomers');
    $results = $this->model_report_recentcustomers->getRecentCustomers();
 
    foreach ($results as $result) {
      $data['recentcustomers'][] = array(
        'customer_id' => $result['customer_id'],
        'name' => $result['firstname'] . '&nbsp;' . $result['lastname'],
        'email' => $result['email'],
        'date_added' => $result['date_added']
      );
    }
 
    return $this->load->view('dashboard/recentcustomers.tpl', $data);
  }
}