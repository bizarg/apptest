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
        $pages = $this->model->all();

        return view('admin.index', compact('pages'));
    }

    public function edit()
    {
        if ($_POST) {

            $this->validate($_POST, [
                'alias' => 'required',
                'title' => 'required',
            ]);

            if($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect("/admin/pages/edit/{$_POST['id']}");
            }

            $page = $this->model->find($_POST['id']);
            $page->alias = $_POST['alias'];
            $page->title = $_POST['title'];
            $page->content = $_POST['content'];
            $page->is_published =  $_POST['is_published'] ? 1 : 0;
            $result = $page->update();
            if ($result) {
                Session::setFlash('Page was saved');
            } else {
                Session::setFlash('Error');
            }

            Router::redirect('/admin/pages');
        }

        if (isset($this->params[0])) {
            $page = $this->model->find(($this->params[0]));

        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/pages/');
        }

        return view('pages.admin_edit', compact('page'));
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

        return view('pages.admin_add');
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