<?php
class Transaction_model extends CI_Model {

    public function get_all_transactions() {
        $this->db->select('*');
        $this->db->from('transactions');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_transaction($transaction_data, $items) {
        $this->db->insert('transactions', $transaction_data);
        $transaction_id = $this->db->insert_id();

        foreach ($items as $item) {
            $item['transaction_id'] = $transaction_id;
            $this->db->insert('transaction_items', $item);
        }

        // Update sales report
        $this->update_sales_report();
    }

    public function get_transaction($id) {
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $transaction = $query->row();
            $transaction->items = $this->get_transaction_items($transaction->id);
            return $transaction;
        } else {
            return false;
        }
    }

    public function get_transaction_items($transaction_id) {
        $this->db->select('*');
        $this->db->from('transaction_items');
        $this->db->where('transaction_id', $transaction_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update_transaction($id, $transaction_data, $items) {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('transactions', $transaction_data);

        $this->db->where('transaction_id', $id);
        $this->db->delete('transaction_items');

        foreach ($items as $item) {
            $item['transaction_id'] = $id;
            $this->db->insert('transaction_items', $item);
        }

        $this->db->trans_complete();

        // Update sales report
        $this->update_sales_report();

        return $this->db->trans_status();
    }

    public function delete_transaction($id) {
        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->delete('transactions');

        $this->db->where('transaction_id', $id);
        $this->db->delete('transaction_items');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    private function update_sales_report() {
        $this->db->select('SUM(total) as total_income');
        $this->db->from('transaction_items');
        $query = $this->db->get();
        $total_income = $query->row()->total_income;

        $this->db->select('rice_name, SUM(quantity) as total_quantity');
        $this->db->from('transaction_items');
        $this->db->group_by('rice_name');
        $query = $this->db->get();
        $rice_sold = $query->result_array();

        $rice_sold_json = json_encode($rice_sold);

        $report_data = array(
            'report_date' => date('Y-m-d'),
            'total_income' => $total_income,
            'rice_sold' => $rice_sold_json
        );

        $this->db->replace('sales_reports', $report_data);
    }

    public function get_sales_report() {
        $this->db->select('*');
        $this->db->from('sales_reports');
        $query = $this->db->get();
        return $query->row();
    }
}
?>