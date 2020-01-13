<?php

class ControllerExtensionPaymentPayabbhi extends Controller
{
    private $error = array();

    public function index()
    {
        $this->language->load('extension/payment/payabbhi');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_setting_setting->editSetting('payment_payabbhi', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');

        $data['entry_access_id'] = $this->language->get('entry_access_id');
        $data['entry_secret_key'] = $this->language->get('entry_secret_key');
        $data['entry_payment_auto_capture'] = $this->language->get('entry_payment_auto_capture');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['help_access_id'] = $this->language->get('help_access_id');
        $data['help_secret_key'] = $this->language->get('help_secret_key');
        $data['help_payment_auto_capture'] = $this->language->get('help_payment_auto_capture');
        $data['help_order_status'] = $this->language->get('help_order_status');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['payment_payabbhi_access_id'])) {
            $data['error_access_id'] = $this->error['payment_payabbhi_access_id'];
        } else {
            $data['error_access_id'] = '';
        }

        if (isset($this->error['payment_payabbhi_secret_key'])) {
            $data['error_secret_key'] = $this->error['payment_payabbhi_secret_key'];
        } else {
            $data['error_secret_key'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => ' :: ',
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/payabbhi', 'user_token=' . $this->session->data['user_token'], 'SSL'),
            'separator' => ' :: ',
        );

        $data['action'] = $this->url->link('extension/payment/payabbhi', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        if (isset($this->request->post['payment_payabbhi_access_id'])) {
            $data['payment_payabbhi_access_id'] = $this->request->post['payment_payabbhi_access_id'];
        } else {
            $data['payment_payabbhi_access_id'] = $this->config->get('payment_payabbhi_access_id');
        }

        if (isset($this->request->post['payment_payabbhi_secret_key'])) {
            $data['payment_payabbhi_secret_key'] = $this->request->post['payment_payabbhi_secret_key'];
        } else {
            $data['payment_payabbhi_secret_key'] = $this->config->get('payment_payabbhi_secret_key');
        }

        if (isset($this->request->post['payment_payabbhi_payment_auto_capture'])) {
            $data['payment_payabbhi_payment_auto_capture'] = $this->request->post['payment_payabbhi_payment_auto_capture'];
        } else {
            $data['payment_payabbhi_payment_auto_capture'] = $this->config->get('payment_payabbhi_payment_auto_capture');
        }

        if (isset($this->request->post['payment_payabbhi_order_status_id'])) {
            $data['payment_payabbhi_order_status_id'] = $this->request->post['payment_payabbhi_order_status_id'];
        } else {
            $data['payment_payabbhi_order_status_id'] = $this->config->get('payment_payabbhi_order_status_id');
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['payment_payabbhi_status'])) {
            $data['payment_payabbhi_status'] = $this->request->post['payment_payabbhi_status'];
        } else {
            $data['payment_payabbhi_status'] = $this->config->get('payment_payabbhi_status');
        }

        if (isset($this->request->post['payment_payabbhi_sort_order'])) {
            $data['payment_payabbhi_sort_order'] = $this->request->post['payment_payabbhi_sort_order'];
        } else {
            $data['payment_payabbhi_sort_order'] = $this->config->get('payment_payabbhi_sort_order');
        }

        $this->template = 'extension/payment/payabbhi';
        $this->children = array(
            'common/header',
            'common/footer',
        );
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/payabbhi', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/payabbhi')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['payment_payabbhi_access_id']) {
            $this->error['payment_payabbhi_access_id'] = $this->language->get('error_access_id');
        }

        if (!$this->request->post['payment_payabbhi_secret_key']) {
            $this->error['payment_payabbhi_secret_key'] = $this->language->get('error_secret_key');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
