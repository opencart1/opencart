<?php
class ControllerInformationNews extends Controller { // Controller - This is a controller file. Information - This is the folder it is in. News - This file name is news.php
 
   public function index() {
      $this->language->load('information/news'); // Calling for my language file
      $this->load->model('catalog/news'); // Calling for my model file
 
      $this->document->setTitle($this->language->get('heading_title')); // Set the title of your web page.
 
      $this->data['breadcrumbs'] = array(); // Breadcrumbs for your website.
      $this->data['breadcrumbs'][] = array(
         'text' => $this->language->get('text_home'),
         'href' => $this->url->link('common/home'),
         'separator' => false
      );
      $this->data['breadcrumbs'][] = array(
         'text' => $this->language->get('heading_title'),
         'href' => $this->url->link('information/news'),
         'separator' => $this->language->get('text_separator')
      );
 
      // Text from language file
      $this->data['heading_title'] = $this->language->get('heading_title');
      $this->data['text_title'] = $this->language->get('text_title');
      $this->data['text_description'] = $this->language->get('text_description');
      $this->data['text_view'] = $this->language->get('text_view');
 
      // Calling for the function getAllNews from the model file
      $all_news = $this->model_catalog_news->getAllNews();
 
      $this->data['all_news'] = array();
 
      foreach ($all_news as $news) {
         $this->data['all_news'][] = array (
            'title' => $news['title'],
            'description' => (strlen(html_entity_decode($news['description'])) > 50 ? substr(strip_tags(html_entity_decode($news['description'])), 0, 50) . '..' : html_entity_decode($news['description'])),
            'view' => $this->url->link('information/news/news', 'news_id=' . $news['news_id'])
         );
      }
 
      // We call this Fallback system
      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news_list.tpl')) { // if file exists in your current template folder
         $this->template = $this->config->get('config_template') . '/template/information/news_list.tpl'; // get it
      } else {
         $this->template = 'default/template/information/news_list.tpl'; // or else get the file from the default folder (this is a fall back folder) always remember to have your template file in the default folder.
      }
 
      $this->children = array( // Required. The children files for the page.
         'common/column_left', // Column left which will allow you to place modules at the left of your page.
         'common/column_right',
         'common/content_top',
         'common/content_bottom',
         'common/footer', // the footer of your website
         'common/header'
      );
 
      $this->response->setOutput($this->render()); // Let's display it all!
   }
 
   public function news() {
      $this->load->model('catalog/news');
      $this->language->load('information/news');
 
      if (isset($this->request->get['news_id']) && !empty($this->request->get['news_id'])) {
         $news_id = $this->request->get['news_id'];
      } else {
         $news_id = 0;
      }
 
      $news = $this->model_catalog_news->getNews($news_id);
 
      $this->data['breadcrumbs'] = array();
      $this->data['breadcrumbs'][] = array(
         'text' => $this->language->get('text_home'),
         'href' => $this->url->link('common/home'),
         'separator' => false
      );
      $this->data['breadcrumbs'][] = array(
         'text' => $this->language->get('heading_title'),
         'href' => $this->url->link('information/news'),
         'separator' => $this->language->get('text_separator')
      );
 
      if ($news) {
         $this->data['breadcrumbs'][] = array(
            'text' => $news['title'],
            'href' => $this->url->link('information/news/news', 'news_id=' . $news_id),
            'separator' => $this->language->get('text_separator')
         );
 
         $this->document->setTitle($news['title']);
 
         $this->data['heading_title'] = $news['title'];
         $this->data['description'] = html_entity_decode($news['description']);
 
         if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/information/news.tpl';
         } else {
            $this->template = 'default/template/information/news.tpl';
         }
 
         $this->children = array(
         'common/column_left',
         'common/column_right',
         'common/content_top',
         'common/content_bottom',
         'common/footer',
         'common/header'
         );
 
         $this->response->setOutput($this->render());
      } else {
         $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_error'),
            'href' => $this->url->link('information/news', 'news_id=' . $news_id),
            'separator' => $this->language->get('text_separator')
         );
 
         $this->document->setTitle($this->language->get('text_error'));
 
         $this->data['heading_title'] = $this->language->get('text_error');
         $this->data['text_error'] = $this->language->get('text_error');
         $this->data['button_continue'] = $this->language->get('button_continue');
         $this->data['continue'] = $this->url->link('common/home');
 
         if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
         } else {
            $this->template = 'default/template/error/not_found.tpl';
         }
 
         $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
         );
 
         $this->response->setOutput($this->render());
      }
   }
}
?>