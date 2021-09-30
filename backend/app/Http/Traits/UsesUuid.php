<?php
namespace App\Http\Traits;
use Illuminate\Support\Str;
trait UsesUuid
{
    protected static function bootUsesUuid() {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->id = (string) Str::uuid()->getHex();
            }
        });
    }

    public function getIncrementing()
    {
        return true;
    }

    public function getKeyType()
    {
        return 'string';
    }
}