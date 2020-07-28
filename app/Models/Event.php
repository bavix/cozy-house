<?php

namespace App\Models;

use Bavix\Entry\Models\Entry;

class Event extends Entry
{

    /**
     * @var string[]
     */
    protected $attributes = [
        '_ga' => '',
        '_gid' => '',
        '_ga_cid' => '',
        '__gads' => '',
        '_ym_uid' => '',
        '_ym_d' => '',
        'tmr_lvid' => '',
        'tmr_lvidts' => '',
        '_fbp' => '',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'request_id',
        'user_id',
        'token_id',
        'app_name',
        'device',
        'category',
        'name',
        'label',
        'payload',
        'request_url',
        'referral_url',
        'identify',
        'client_id',
        'client_ip',
        'user_agent',
        '_ga',
        '_gid',
        '_ga_cid',
        '__gads',
        '_ym_uid',
        '_ym_d',
        'tmr_lvid',
        'tmr_lvidts',
        '_fbp',
        'date',
        'datetime',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'dictionary_id' => 'int',
        'payload' => 'string',
        'date' => 'date:Y-m-d',
        'datetime' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @param array $data
     */
    public function setPayloadAttribute(array $data): void
    {
        $this->attributes['payload'] = \json_encode($data);
    }

}
