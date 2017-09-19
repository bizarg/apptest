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
        $obj = new Image();
        $images = $obj->all();

        $banner = $this->model->findOrFail($id);
        $banner->images = $banner->images();

        $arr = [];

        foreach ($banner->images as $image) {
            array_push($arr, $image->id);
        }

//        $select = new Image();

        $banner->images = $obj
            ->select('images.id, images.name, banner_image.position')
            ->addJoin('banner_image','images.id', 'banner_image.image_id')
            ->whereIn($arr, 'images.id')
            ->orderBy('banner_image.position')
            ->getArray();

//        dd($images[0]);
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
            if ($this->model->findOrFail($id)->delete()) {
                Session::set('success', 'Banner was deleted');
            } else {
                Session::set('fail', 'Banner was not deleted');
            }
        }

        return Router::redirect('/admin/banners/');
    }

    public function position($id)
    {
        $banner_image = new BannerImage();
//        dd($_POST['position'] );
        foreach (json_decode($_POST['position']) as $key => $item) {
            $model = $banner_image->select()->where($id, 'banner_id')->andWhere($item, 'image_id')->getOne();
            $model->position = ++$key;
            $model->update();
            $model->sql = null;
        }
//        dd('true');
//        return gettype(json_decode($_POST['position']));
        return 'true';
    }
}