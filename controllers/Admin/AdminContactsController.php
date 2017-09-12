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

        $messages = $this->model->all();

        return view('contacts.admin_index', compact('messages'));
    }
}