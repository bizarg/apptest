<?php

class User extends Model
{
    protected $class = 'User';
    protected $table = 'users';
    protected $fillable = ['id', 'login', 'email', 'role', 'password', 'is_active'];
}