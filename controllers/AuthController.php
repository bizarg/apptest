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
                'login' => 'required|min:2|max:32',
                'password' => 'required|password',
            ]);

            if($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect('/auth/login');
            }

            $this->signin($_POST);
        }

        return view('auth.login');
    }

    public function logout() {
        Session::destroy();
        Router::redirect('/');
    }

    public function register() {

        if ($_POST) {
            $this->validate($_POST, [
                'email' => 'required|email',
                'login' => 'required|min:2|max:32',
                'password' => 'required|password',
                'second_password' => 'required|password',
            ]);

            if($this->fail) {
                Session::set('error', $this->error);
                return Router::redirect('/auth/register');
            }

//            $email = $this->model->find($_POST['email'], 'email');
//            $login = $this->model->find($_POST['login'], 'login');

            $email = $this->model->select()
                ->where($_POST['email'], 'email')
                ->getOne();

            if ($email) {
                Session::set('error', ['Пользователль с таким email уже зарегесрирован']);
                return Router::redirect('/auth/register');
            }

            if($_POST['password'] == $_POST['second_password']) {
                $hash = md5(Config::get('salt') . $_POST['password']);

                    $user = new User();
                    $user->login = $_POST['login'];
                    $user->email = $_POST['email'];
                    $user->password = $hash;

                if ($user->create()) {
                    $this->signin($_POST);
                } else {
                    return Router::redirect('/auth/register');
                }
            }
        }


        return view('auth.register');
    }

    private function signin($data)
    {
        $user = $this->model->select()
            ->where($_POST['login'], 'login')
            ->getOne();

        if (!$user) {
            Session::set('error', ['Данный пользователь не найден']);
            return Router::redirect('/auth/login');
        }

        $hash = md5(Config::get('salt') . $data['password']);

        if ($user->is_active && $hash == $user->password) {
            Session::set('login', $user->login);
            Session::set('role', $user->role);
            if ($user->role == 'admin') return Router::redirect('/admin/pages');
            return Router::redirect('/pages/index');
        }

    }
}