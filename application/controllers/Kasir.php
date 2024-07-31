<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaction_model');
    }

    public function index() {
        $data['transactions'] = $this->Transaction_model->get_all_transactions();
        $this->load->view('kasir/index', $data);
    }

    public function create() {
        $this->load->view('kasir/create');
    }

    public function store() {
    $items = $this->input->post('items');
    $totalKeseluruhan = array_reduce($items, function($sum, $item) {
        return $sum + $item['price'] * $item['quantity'];
    }, 0);

    $transaction_data = array(
        'transaction_id' => $this->input->post('transaction_id'),
        'customer_id' => $this->input->post('customer_id'),
        'customer_name' => $this->input->post('customer_name'),
        'notelp_pelanggan' => $this->input->post('notelp_pelanggan'),
        'customer_address' => $this->input->post('customer_address'),
        'order_date' => $this->input->post('order_date'),
        'delivery_date' => $this->input->post('delivery_date'),
        'status' => $this->input->post('status'),
        'amount_paid' => $this->input->post('amount_paid'),
        'totalKeseluruhan' => $totalKeseluruhan
    );

    $this->Transaction_model->insert_transaction($transaction_data, $items);

    if ($this->input->is_ajax_request()) {
        echo json_encode(['status' => 'success']);
    } else {
        redirect('kasir');
    }
}

    public function update($id) {
        $items = $this->input->post('items');
        $totalKeseluruhan = array_reduce($items, function($sum, $item) {
            return $sum + $item['price'] * $item['quantity'];
        }, 0);

        $transaction_data = array(
            'transaction_id' => $this->input->post('transaction_id'),
            'customer_id' => $this->input->post('customer_id'),
            'customer_name' => $this->input->post('customer_name'),
            'notelp_pelanggan' => $this->input->post('notelp_pelanggan'),
            'customer_address' => $this->input->post('customer_address'),
            'order_date' => $this->input->post('order_date'),
            'delivery_date' => $this->input->post('delivery_date'),
            'status' => $this->input->post('status'),
            'amount_paid' => $this->input->post('amount_paid'),
            'totalKeseluruhan' => $totalKeseluruhan
        );

        $update_status = $this->Transaction_model->update_transaction($id, $transaction_data, $items);

        if ($this->input->is_ajax_request()) {
            if ($update_status) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'failure']);
            }
        } else {
            redirect('kasir');
        }
    }

    public function delete($id) {
        $delete_status = $this->Transaction_model->delete_transaction($id);
        if ($delete_status) {
            redirect('kasir');
        } else {
        }
    }

    public function view($id) {
        $data['transaction'] = $this->Transaction_model->get_transaction($id);
        if ($data['transaction']) {
            $this->load->view('kasir/view', $data);
        } else {
            show_404();
        }
    }
    
    public function edit($id) {
        $data["berases"] = [
                ["id"=>"BR001","text"=>"beras 1"],
                [
                    "id"=>"BR002",
                    "text"=>"beras 2"
            ]
            ];
        $data['transaction'] = $this->Transaction_model->get_transaction($id);
        if ($data['transaction']) {
            $this->load->view('kasir/edit', $data);
        } else {
            show_404();
        }
    }
    
    public function receipt($id) {
        $data['transaction'] = $this->Transaction_model->get_transaction($id);
        if ($data['transaction']) {
            if ($this->input->is_ajax_request()) {
                echo json_encode($data['transaction']);
            } else {
                $this->load->view('kasir/receipt', $data);
            }
        } else {
            show_404();
        }
    }
    
    public function view_report() {
        $data['sales_report'] = $this->Transaction_model->get_sales_report();
        $this->load->view('kasir/view_report', $data);
    }
}
?>