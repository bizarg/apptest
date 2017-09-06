<?php

class AdminImagesController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new Image();
    }

    //get /admin/images/index
    //page views/images/admin_index
    public function index()
    {
        $images = $this->model->getList();

        return view('images.admin_index', compact('images'));
    }

    //get /admin/images/edit
    //page views/images/admin_edit
    public function edit()
    {
        if (isset($this->params[0])) {
            $image= $this->model->find(($this->params[0]));
        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/images/');
        }

        return view('images.admin_edit', compact('image'));
    }

    //post /admin/images/update
    //redirect /admin/images/index
    public function update()
    {
        if ($_POST) {

            $this->validate($_POST, [
                'name' => 'required|min:2',
                'link' => 'required|min:2',
                'img' => 'required|min:2',
                'position' => 'int',
            ]);

            if($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect("/admin/images/edit/{$_POST['id']}");
            }

            $image = $this->model->find($_POST['id']);
            $image->name = $_POST['name'];
            $image->link = $_POST['link'];
            $image->img = $_POST['img'];
            $image->position = $_POST['position'];
            $image->is_published = $_POST['is_published'] = isset($_POST['is_published']) ? 1 : 0;
            $image->update();

            return Router::redirect('/admin/images/');
        }
    }

    public function add()
    {
        return view('images.admin_add');
    }
}