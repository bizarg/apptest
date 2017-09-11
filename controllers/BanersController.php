<?php

//namespace apptest\controllers;

//use apptest\lib\Controller;

class BanersController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new Banner();
    }

    public function index()
    {
        $banner = $this->model->select()->where('clock', 'name')->getOne();

        if ($banner) {
            $banner->images = $banner->images();
        }

        return view('banners.index', compact('pages', 'banner'));
    }

    public function view()
    {
        $params = App::getRouter()->getParams();

        if ( isset($params[0])) {
            $alias = strtolower($params[0]);
            $page = $this->model->find($alias, 'alias');
        }

        return view('pages.view', compact('page'));
    }
}