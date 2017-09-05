<?php

class User extends Model
{
    protected $class = 'User';
    protected $table = 'users';
    protected $fillable = ['id', 'login', 'email', 'role', 'password', 'is_active'];

    public function signin($data)
    {
        $hash = md5(Config::get('salt') . $data['password']);
        dd($this);
        if ($this->is_active && $hash == $this->password) {
            Session::set('login', $this->login);
            Session::set('role', $this->role);
        }
        dd(Session::get('login')." : ".Session::get('role'));
        return Router::redirect('/pages/index');
    }


}