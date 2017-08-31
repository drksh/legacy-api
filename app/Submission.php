<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Storage;

class Submission extends Model
{
    /**
     * Don't guard filling of any attributes.
     *
     * @var array
     */
    protected $guarded = [];

    public static function createFromType($type, array $attributes)
    {
        $model = Relation::getMorphedModel($type);
        $content = new $model($attributes);

        if ($content instanceof File) {
            $file = $attributes['body'];
            $file->store('', 'void');

            $content->body = Storage::disk('void')->url($file->hashName());
        }

        $content->save();

        return static::create([
            'content_id' => $content->id,
            'content_type' => $type,
        ]);
    }

    public function content()
    {
        return $this->morphTo();
    }
}
