<?php

class AdminContactsController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new Message();
    }

    public function index()
    {

        $this->data = $this->model->getList();

        return view('contacts.admin_index');
    }
}