<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\General\Configuration
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $default
 * @property string $value
 * @property string|null $unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Configuration whereValue($value)
 * @mixin \Eloquent
 */
class Configuration extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected  $guarded = [];

    /**
     * @return string|int
     */
    public static function getPropertyExpiryCount(): string|int
    {
        $count = self::whereSlug('property_expiry_notification_max_count')->first();
        return $count->value ?? $count->default ?? 4;
    }


    /**
     * @return string|int
     */
    public static function getPropertyExpiryTimeInterval(): string|int
    {
        $count = self::whereSlug('property_expiry_notification_time_interval')->first();
        return $count->value ?? $count->default ?? 4;
    }

}
