<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Todos extends CI_Controller {

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
        //configure page specific functionality
        //$todos = [[1, 'Fix lawnmower', 'done'], [2, 'Take out trash', 'done']];
        $this->load->model('Todo');
        $query = $this->Todo->db->query('SELECT * FROM todos');

        $data['todos'] = $query->result();

        //load page
        $this->load->helper('url');
        $this->template->load_view('pages/list', $data);
    }

    /**
     * Add/edit Page for this controller.
     */
    public function add_edit($id = null) {
        $this->load->helper('url');
        //configure page metadata and resources
        $this->load->library('template');
        $this->template->set_title('Add/Edit');
        $this->template->set_title_desc('Add or edit of todos');
        $this->template->add_meta('description', 'This is where you add or edit a todo.');
        $this->template->add_meta('keywords', 'todos, add, edit');
        //configure page specific functionality
        $this->load->model('Todo');
        $todo = null;
        //if there is something in the post
        if ($this->input->post()) {
            //if adding a new Todo
            $data = array(
                'title' => $this->input->post('title')
            );
            if (!$id) {
                //'add' functionality
                $this->Todo->db->insert('todos', $data);               
            } else {//if editing an existing todo
                //'edit' functionality 
                $this->Todo->db->where('id', $id);
                $this->Todo->db->update('todos', $data);
            }
            redirect('/todos', 'refresh');
        } else {
            if (!$id) {//coming to page to add
                $todo = new Todo();
                $todo->title = '';
            }else{//coming to page to edit
                
            }
        }
        $data['todo'] = $todo;
        //load page
        $this->load->helper('url');
        $this->template->load_view('pages/add_edit', $data);
    }

}
