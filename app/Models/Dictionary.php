<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dictionary
 *
 * @property int $id
 * @property int $user_id
 * @property string $category
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dictionary whereUserId($value)
 * @mixin \Eloquent
 */
class Dictionary extends Model
{

    /**
     * @var string[]
     */
    protected $visible = [
        'id',
        'category',
        'name',
    ];

}
