<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Webpatser\Uuid\Uuid;

/**
 * Class Asset
 *
 * @package App\Models\General
 * @property int $id
 * @property string $uuid
 * @property int $assetable_id
 * @property string $assetable_type
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $assetable
 * @method static \Illuminate\Database\Eloquent\Builder|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Asset query()
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereAssetableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereAssetableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereUuid($value)
 * @mixin \Eloquent
 */
class Asset extends Model
{
    use HasFactory;

    /**
     * Enums
     */
    public const VIDEO = 'video';
    public const IMAGE = 'image';
    public const GIF = 'image';

    protected $guarded = [];

    /**
     *  Setup model event hooks
     */
    public static function boot() :void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'uuid';
    }

    /**
     * @return MorphTo
     */
    public function assetable(): MorphTo
    {
        return $this->morphTo();
    }
}
