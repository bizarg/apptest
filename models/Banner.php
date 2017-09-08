<?php

class Banner extends Model
{
    protected $class = 'Banner';
    protected $table = 'banners';
    protected $fillable = ['id', 'name'];
    protected $relations = ['images'];

//    public function images()
//    {
//        return $this->images = $this->hasMany('Image', 'banner_id');
//    }

    public function images()
    {
        $this->images = $this->hasManyToMany('BannerImage', 'banner_id');
        return $this;
    }
}