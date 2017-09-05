<?php

class Page extends Model
{
    protected $class = 'Page';
    protected $table = 'pages';
    protected $fillable = ['id', 'alias', 'title', 'content', 'is_published'];
}