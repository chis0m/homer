<?php

namespace Modules\Property\Models;

use App\Models\Agent;
use App\Models\General\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;
use App\Models\General\Asset;

/**
 * Class Property
 *
 * @package Modules\Property\Models
 * @property int $id
 * @property int $propertable_id
 * @property string $propertable_type
 * @property string $title
 * @property string|null $purpose
 * @property int $bedroom
 * @property int $bathroom
 * @property int $kitchen
 * @property int|null $size
 * @property int|null $furnished
 * @property int|null $serviced
 * @property int|null $newly_built
 * @property int $toilet
 * @property string|null $slug
 * @property string $type
 * @property string $price
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Asset[] $assets
 * @property-read int|null $assets_count
 * @property-read Model|\Eloquent $propertable
 * @method static \Illuminate\Database\Eloquent\Builder|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereBathroom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereBedroom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereFurnished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereKitchen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereNewlyBuilt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePropertableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePropertableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereServiced($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereToilet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|Property onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Property withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Property withoutTrashed()
 * @property string $status
 * @property int $notification_count
 * @property string|null $expired_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Property status($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property agentPropertyThatAre($value)
 */
class Property extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'propertable_id',
        'propertable_type',
    ];

    /**
     * @return MorphTo
     */
    public function propertable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return MorphMany
     */
    public function assets(): MorphMany
    {
        return $this->morphMany(Asset::class, 'assetable');
    }

    /**
     * @return MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public  function scopeStatus($query, $value): mixed
    {
        return $query->whereStatus($value);
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeAgentPropertyThatAre($query, $value): mixed
    {
        return $query->whereStatus($value)->where('propertable_type', Agent::class);
    }
}
