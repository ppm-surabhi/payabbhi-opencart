<?php

class ModelExtensionPaymentPayabbhi extends Model
{
    public function getMethod($address, $total)
    {

        $this->language->load('extension/payment/payabbhi');

        $method_data = array(
            'code' => 'payabbhi',
            'title' => $this->language->get('text_title'),
            'terms' => '',
            'sort_order' => $this->config->get('payment_payabbhi_sort_order'),
        );

        return $method_data;
    }
}
