<?php

namespace TypiCMS\Modules\Objects\Models;

use Dimsav\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;

class Object extends Base
{
    use Historable;
    use PresentableTrait;
    use Translatable;

    protected $presenter = 'TypiCMS\Modules\Objects\Presenters\ModulePresenter';

    /**
     * Declare any properties that should be hidden from JSON Serialization.
     *
     * @var array
     */
    protected $hidden = [];

    protected $fillable = [
        'image',
        // Translatable columns
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
    ];

    protected $appends = ['status', 'title', 'thumb'];

    /**
     * Columns that are file.
     *
     * @var array
     */
    public $attachments = [
        'image',
    ];

    /**
     * Append status attribute from translation table.
     *
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return $this->status;
    }

    /**
     * Append title attribute from translation table.
     *
     * @return string title
     */
    public function getTitleAttribute($value)
    {
        return $this->title;
    }

    /**
     * Append thumb attribute.
     *
     * @return string
     */
    public function getThumbAttribute($value)
    {
        return $this->present()->thumbSrc(null, 22);
    }
}
