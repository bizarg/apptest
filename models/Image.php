<?php

class Image extends Model
{
    protected $class = 'Image';
    protected $table = "images";
    protected $fillable = ['id', 'name', 'img', 'link', 'is_published', 'position'];
    protected $relations = ['banners'];
    protected $destroy = ['bannerImages'];

    public function banners()
    {
        return $this->hasManyToMany('BannerImage', 'image_id');
    }

    public function bannerImages()
    {
        return $this->hasMany('BannerImage', 'image_id');
    }
}
