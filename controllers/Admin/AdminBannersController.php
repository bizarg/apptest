<?php

class AdminBannersController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new Banner();
    }

    public function index()
    {
        $banners = $this->model->getList();

        foreach (checkArr($banners) as &$banner) {
            $banner->images = $banner->images();
        }

        return view('banners.admin_index', compact('banners'));
    }

    public function add()
    {
        return view('banners.admin_add');
    }

    public function create()
    {
        if ($_POST) {
            $this->validate($_POST, ['name_banner' => 'required']);

            if ($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect('/admin/banners/add');
            }


            $banner = new Banner();
            $banner->name = $_POST['name_banner'];

            if ($banner->create()) {
                Session::set('success', 'Banner created successfuly');
            } else {
                Session::setFlash('fail', 'Banner was not created');
            }

            return Router::redirect('/admin/banners');

//            if (isset($_POST['name'])) {
//
//                foreach ($_POST['name'] as $key => $item) {
//                    $image = new Image();
//                    $image->name = $item;
//                    $image->img = $_POST['img'][$key];
//                    $image->link = $_POST['link'][$key];
//                    $image->position = $_POST['position'][$key];
//                    $image->is_published = $_POST['is_published'][$key] ? 1 : 0;
//                    $image->banner_id = $banner_id;
//                    $image->create();
//                }

//        }
//            return Router::redirect('/admin/banners');
        }
    }

    public function edit($id)
    {
        $images = new Image();
        $images = $images->getList();

        $banner = $this->model->findOrFail($id);
        $banner->images();

        return view('banners.admin_edit', compact('images', 'banner'));

    }

    public function update($id)
    {
        if ($_POST)
        {
            $banner = $this->model->findOrFail($id);

            $this->validate($_POST, ['name_banner' => 'required']);

            if ($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect('/admin/banners/add');
            }

            $banner->name = $_POST['name_banner'];
            if ($banner->update()) {
                if ($_POST['images']) {

                    $banner->sync($_POST['images'], 'images', 'banner_id');


//                    foreach ($_POST['images'] as $image_id) {
//
//
//                        $images = $banner->images();
//
//                        foreach ($images as $img) {
//                            if(!in_array($img->id, $_POST['images'])) {
//                                $img->banner_id = null;
//                                $img->update();
//                            }
//                        }
//
//                        $image = new Image();
//                        $image = $image->find($image_id);
//                        $image->banner_id = $id;
//                        $image->update();
//                    }
                }
                return Router::redirect('/admin/banners/');
            } else {
                Session::set('fail', 'Banner was not update');
                return Router::redirect("/admin/banners/edit/{$id}");
            }
        }
    }

    public function delete($id)
    {
        if ($id) {
            if ($this->model->findOrFail($id)->destroy()) {
                Session::set('success', 'Banner was deleted');
            } else {
                Session::set('fail', 'Banner was not deleted');
            }
        }

        return Router::redirect('/admin/banners/');
    }
}