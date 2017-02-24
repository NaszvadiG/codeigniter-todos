<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Todos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Todo');
        $this->load->helper('url');
    }

    /**
     * Index Page for this controller. List todos.
     */
    public function index() {
        //configure page metadata and resources
        $this->load->library('template');
        $this->template->set_title('List');
        $this->template->set_title_desc('A list of todos');
        $this->template->add_meta('description', 'This is a really cool list of todos.');
        $this->template->add_meta('keywords', 'todos, list');
        
        //$this->template->add_js('main.js');
        $this->template->add_css('css/main.css');
        
        $query = $this->Todo->db->query('SELECT * FROM todos');

        $data['todos'] = $query->result();

        //load page
        $this->template->load_view('pages/list', $data);
    }

    /**
     * Add/edit Page for this controller.
     */
    public function add_edit($id = null) {
        $this->load->library('form_validation');
        //configure page metadata and resources
        $this->load->library('template');
        $this->template->set_title('Add/Edit');
        $this->template->set_title_desc('Add or edit of todos');
        $this->template->add_meta('description', 'This is where you add or edit a todo.');
        $this->template->add_meta('keywords', 'todos, add, edit');
        //configure page specific functionality

        $todo = null;
        //if there is something in the post
        if ($this->input->post()) {
            $this->form_validation->set_rules(array(
                array('field' => 'title',
                    'label' => 'Title',
                    'rules' => 'required')
            ));
            //check to see if form validates
            if ($this->form_validation->run()) {//validates
                //if adding a new Todo
                $data = array(
                    'title' => $this->input->post('title')
                );
                if (!$id) {
                    //'add' functionality
                    if ($this->Todo->db->insert('todos', $data)) {
                        $this->session->set_flashdata('success', 'Todo successfully added');
                    } else {
                        $this->session->set_flashdata('error', 'There was a problem adding the Todo');
                    }
                } else {//if editing an existing todo
                    //'edit' functionality 
                    $this->Todo->db->where('id', $id);
                    if ($this->Todo->db->update('todos', $data)) {
                        $this->session->set_flashdata('success', 'Todo successfully updated');
                    } else {
                        $this->session->set_flashdata('error', 'There was a problem updating the Todo');
                    }
                }
                redirect('/todos', 'refresh');
            } else {//doesn't validate
                $todo = new Todo();
                $todo->title = $this->input->post('title');
            }
        } else {
            if (!$id) {//coming to page to add
                $todo = new Todo();
                $todo->title = '';
            } else {//coming to page to edit
                //get Todo from db                
                $query = $this->Todo->db->get_where('todos', array('id' => $id), 1);
                $todo = $query->row();
            }
        }
        $data['todo'] = $todo;
        //load page
        $this->template->load_view('pages/add_edit', $data);
    }

    public function delete($id) {
        if ($this->Todo->db->delete('todos', array('id' => $id))) {
            $this->session->set_flashdata('success', 'Todo successfully deleted');
        } else {
            $this->session->set_flashdata('error', 'There was a problem deleting the Todo');
        }
        redirect('/todos', 'refresh');
    }

}
