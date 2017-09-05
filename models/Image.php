<?php

class Image extends Model
{
    protected $class = 'Image';
    protected $table = "images";
    protected $fillable = ['id', 'name', 'img', 'link', 'is_published', 'position'];

}
