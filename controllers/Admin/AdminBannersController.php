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
        $banners = $this->model->all();

        foreach (checkArr($banners) as $banner) {
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
                Session::set('fail', 'Banner was not created');
            }

            return Router::redirect('/admin/banners');
        }
    }

    public function edit($id)
    {
        $images = new Image();
        $images = $images->all();

        $banner = $this->model->findOrFail($id);
        $banner->images = $banner->images();

        return view('banners.admin_edit', compact('images', 'banner'));
    }

    public function update($id)
    {
        if ($_POST) {
            $banner = $this->model->findOrFail($id);

            $this->validate($_POST, ['name_banner' => 'required']);

            if ($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect('/admin/banners/add');
            }

            $banner->name = $_POST['name_banner'];

            if ($banner->update()) {

                $data = isset($_POST['images']) ? $_POST['images'] : [];
                $banner->sync($data, new BannerImage(),'images', 'banner_id');
//                return Router::redirect('/admin/banners/');
//
//            } else {
//                Session::set('fail', 'Banner was not update');
//                return Router::redirect("/admin/banners/edit/{$id}");
            }
        }
    }

    public function delete($id)
    {
        if ($id) {
            if ($this->model->findOrFail($id)->delete()) {
                Session::set('success', 'Banner was deleted');
            } else {
                Session::set('fail', 'Banner was not deleted');
            }
        }

        return Router::redirect('/admin/banners/');
    }
}