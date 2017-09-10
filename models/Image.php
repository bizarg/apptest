<?php

class Image extends Model
{
    protected $class = 'Image';
    protected $table = "images";
    protected $fillable = ['id', 'name', 'img', 'link', 'is_published', 'position'];
    protected $relations = ['banners'];

    public function banners()
    {
        $this->banners = $this->hasManyToMany('BannerImage', 'image_id');
        return $this;
    }
}
