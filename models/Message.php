<?php

class Message extends Model
{
    protected $class = 'Message';
    protected $table = 'messages';
    protected $fillable = ['id', 'name', 'email', 'message'];
}