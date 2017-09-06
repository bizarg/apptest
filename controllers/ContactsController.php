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
            if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
                return false;
            }

            $message = new Message();
            $message->name = $_POST['name'];
            $message->email = $_POST['email'];
            $message->message = $_POST['message'];

            if ($message->create($_POST)) {
                Session::setFlash('Thank you! Your message was successfuly!');
                Router::redirect('/contacts/');
            }
        }

        return view('contacts.index');
    }
}