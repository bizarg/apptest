<?php

class BannerImage extends Model
{
    protected $class = 'BannerImage';
    protected $table = 'banner_image';
    protected $fillable = ['id', 'banner_id', 'image_id'];
    protected $relations = [
        'banner_id' => 'Banner',
        'image_id' => 'Image'
    ];

//    public function images($id)
//    {
//        return $this->images = $this->hasMany('Image', 'banner_id');
//    }
//
//    public function banners()
//    {
//        return $this->images = $this->hasMany('Banner', 'image_id');
//    }
}