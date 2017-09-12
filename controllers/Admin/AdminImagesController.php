<?php

class AdminImagesController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new Image();
    }

    public function index()
    {
        $images = $this->model->all();

        return view('images.admin_index', compact('images'));
    }

    public function edit($id)
    {
        $image = $this->model->findOrFail($id);

        return view('images.admin_edit', compact('image'));
    }

    public function update()
    {
        if ($_POST) {

            $this->validate($_POST, [
                'name' => 'required|min:2',
                'link' => 'required|min:2',
//                'img' => 'required|min:2',
                'position' => 'int',
            ]);

            if($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect("/admin/images/edit/{$_POST['id']}");
            }

            $image = $this->model->findOrFail($_POST['id']);

            $uploaddir = ROOT .DS. "webroot".DS."img".DS;
            $oldname = $uploaddir.$image->name;

            if (file_exists($oldname)) {
                rename($oldname, $uploaddir.$_POST['name']);
            }

            $image->name = $_POST['name'];
            $image->link = $_POST['link'];
            $image->position = $_POST['position'];
            $image->is_published = $_POST['is_published'] = isset($_POST['is_published']) ? 1 : 0;

            if ($image->update()) {
                Session::set('success', 'Image updated successfuly');
            } else {
                Session::set('fail', 'Image was not updated');
            }

            return Router::redirect('/admin/images/');
        }
    }

    public function add($banner_id = null)
    {
        return view('images.admin_add', compact($banner_id));
    }

    public function create()
    {

        if ($_POST) {

            $this->validate($_POST, [
//                'name' => 'required|min:2',
                'link' => 'required|min:2',
//                'img' => 'required|min:2',
                'position' => 'int',
            ]);

            if ($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect("/admin/images/add");
            }



            $image = new Image();
            $image->name = $_FILES['file']['name'];
            $image->link = $_POST['link'];
//            $image->img = PATH_IMG;
            $image->position = $_POST['position'];
            $image->is_published = $_POST['is_published'] = isset($_POST['is_published']) ? 1 : 0;

            if ($_FILES) {
                // Каталог, в который мы будем принимать файл:
                $uploaddir = ROOT .DS. "webroot".DS."img".DS;

                $uploadfile = $uploaddir.$_FILES['file']['name'];

                if (file_exists($uploadfile)) {
                    Session::set('fail', 'This file exist');
                    return Router::redirect('/admin/images');
                }

                if (is_uploaded_file($_FILES['file']['tmp_name'])) {

                    $finfo = new finfo(FILEINFO_MIME_TYPE);

                    if (false === $ext = array_search(
                            $finfo->buffer(file_get_contents($_FILES['file']['tmp_name'])) ,
                            array(
                                'jpeg' => 'image/jpeg',
                                'png' => 'image/png',
                                'gif' => 'image/gif',
                            ),
                            true
                        )) {
                        throw new RuntimeException('Invalid file format.');
                    }

                    if (resize($_FILES['file']['tmp_name'], $uploadfile, $ext)) {
                        if ($image->create()) {
                            Session::set('success', 'Image created successfuly');
                        } else {
                            Session::set('fail', 'Image was not created');
                        }
                    }
                } else {
                    throw new RuntimeException('Invalid file ');
                }
            }

            return Router::redirect('/admin/images');
        }
    }

    public function delete($id)
    {
        $image = $this->model->findOrFail($id);

        $path = ROOT . DS . "webroot" . DS . "img" .DS . $image->name;

        if (!unlink($path)) {
            Session::set('fail', 'Images was not deleted');
        }


        if ($image->destroy()) {
            Session::set('success', 'Banner was deleted');
        } else {
            Session::set('fail', 'Banner was not deleted');
        }

        return Router::redirect('/admin/images/');
    }
}