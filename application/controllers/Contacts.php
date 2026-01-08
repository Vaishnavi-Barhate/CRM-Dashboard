<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Contacts_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    //To Show list page
    public function index() {
        $data['contacts'] = $this->Contacts_model->get_all();
        $this->load->view('contacts/list', $data);
    }

    //To Add or edit form
    public function form($id = null) {
        $data['contact'] = null;
        if ($id) {
            $data['contact'] = $this->Contacts_model->get_by_id($id);
        }
        $this->load->view('contacts/form', $data);
    }

    //To Save data (Add/Edit)
    public function save() {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('company_name', 'Company Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->form();
            return;
        }

        $data = [
            'name' => $this->input->post('name'),
            'company_name' => $this->input->post('company_name'),
            'designation' => $this->input->post('designation'),
            'email' => $this->input->post('email')
        ];

        if ($this->input->post('id')) {
            $this->Contacts_model->update($this->input->post('id'), $data);
            $this->session->set_flashdata('success', 'Contact updated successfully!');
        } else {
            $this->Contacts_model->insert($data);
            $this->session->set_flashdata('success', 'New contact added successfully!');
        }
        redirect('contacts');
    }

    //To Delete single
    public function delete($id) {
        $this->Contacts_model->delete($id);
        $this->session->set_flashdata('success', 'Contact deleted!');
        redirect('contacts');
    }

    //To Delete multiple
    public function delete_bulk() {
        $ids = $this->input->post('ids');
        if (!empty($ids)) {
            $this->Contacts_model->delete_bulk($ids);
        }
        echo 'success';
    }
}
