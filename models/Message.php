<?php

class Message extends Model
{
    protected $class = 'Message';
    protected $table = 'messages';
    protected $fillable = ['name', 'email', 'message'];
}