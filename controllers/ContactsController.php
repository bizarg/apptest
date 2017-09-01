<?php

/**
 * Created by PhpStorm.
 * User: val
 * Date: 31.08.2017
 * Time: 13:48
 */
class ContactsController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new Message();
    }

    public function index()
    {

        if ($_POST) {

            if ($this->model->save($_POST)) {
                Session::setFlash('Thank you! Your message was successfuly!');
            }
        }
    }

    public function admin_index()
    {
        $this->data = $this->model->getList();
    }
}