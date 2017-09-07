<?php

class Image extends Model
{
    protected $class = 'Image';
    protected $table = "images";
    protected $fillable = ['id', 'name', 'img', 'link', 'is_published', 'position', 'banner_id'];
    protected $relations = ['banners'];

    public function banner()
    {
        $this->banner = $this->hasOne('Banner', 'banner_id');
        return $this;
    }
}
