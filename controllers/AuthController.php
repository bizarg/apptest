<?php

class AuthController extends Controller
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->model = new User();
    }

    public function login()
    {
        if ($_POST) {

            $this->validate($_POST, [
                'login' => 'required',
                'password' => 'required',
            ]);

            if($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect('/auth/login');
            }

            $user = $this->model->find($_POST['login'], 'login');

            if (!$user) {
                Session::set('error', ['Данный пользователь не найден']);
                dd('user');
                return Router::redirect('/auth/login/');
            }

            $user->signin($_POST);
        }
    }

    public function logout() {
        Session::destroy();
        Router::redirect('/');
    }

    public function register() {

        if ($_POST) {

            $email = $this->model->find($_POST['email'], 'email');
            $login = $this->model->find($_POST['login'], 'login');

            if(!$email && !$login) {
                if($_POST['password'] == $_POST['second_password']) {
                    $_POST['password'] = md5(Config::get('salt') . $_POST['password']);

                        $user = new User();
                        $user->login = $_POST['login'];
                        $user->email = $_POST['email'];
                        $user->password = $_POST['password'];

                    if ($user = $user->create()) {
                        $user->signin($_POST);
                    }
                }
            }
        }
    }


}