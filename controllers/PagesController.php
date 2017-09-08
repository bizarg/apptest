<?php

//namespace apptest\controllers;

//use apptest\lib\Controller;

class PagesController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new Page();
    }

    public function index()
    {

        $banner = new Banner();
//        $banner = $banner->one(35);
//        $banner = $banner->all();
        $banner->select()->where('new', 'name')->andWhere('new1', 'name')->get();
        dd($banner);

//        $pages = $this->model->getList();

        return view('pages.index', compact('pages'));
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