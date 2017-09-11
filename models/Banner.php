<?php

class Banner extends Model
{
    protected $class = 'Banner';
    protected $table = 'banners';
    protected $fillable = ['id', 'name'];
    protected $relations = ['images'];
    protected $destroy = ['bannerImages'];

    public function images()
    {
        return $this->hasManyToMany('BannerImage', 'banner_id');
    }

    public function bannerImages()
    {
        return $this->hasMany('BannerImage', 'banner_id');
    }
}