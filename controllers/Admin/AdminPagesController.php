<?php

//namespace apptest\controller\Admin;

class AdminPagesController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new Page();

    }

    public function index()
    {
        $this->data['pages'] = $this->model->getList();
    }

    public function edit()
    {
        if ($_POST) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->update($_POST, $id);
            if ($result) {
                Session::setFlash('Page was saved');
            } else {
                Session::setFlash('Error');
            }

            Router::redirect('/admin/pages');
        }

        if (isset($this->params[0])) {
            $this->data['page'] = $this->model->find(($this->params[0]));
        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/pages/');
        }
    }

    public function add()
    {
        if ($_POST) {
            $result = $this->model->create($_POST);
            if ($result) {
                Session::setFlash('Page was saved');
            } else {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/pages');
        }
    }

    public function delete()
    {
        if (isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if ($result) {
                Session::setFlash('Page was deleted');
            } else {
                Session::setFlash('Error');
            }
        }
        Router::redirect('/admin/pages');
    }
}