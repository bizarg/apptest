<?php

class PagesController extends Controller
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

    public function view()
    {
        $params = App::getRouter()->getParams();

        if ( isset($params[0])) {
            $alias = strtolower($params[0]);
        }
        $this->data['content'] = $this->model->getByAlias($alias);
    }
}