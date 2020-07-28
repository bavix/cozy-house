<?php

namespace App\Console\Commands;

use App\Models\Event;
use Bavix\LaravelClickHouse\Database\Eloquent\Model as Entry;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class BulkWrite extends \Bavix\Entry\Commands\BulkWrite
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cozy:bulk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event handler';

    /**
     * @var string[]
     */
    protected $adjustments = [
        '_ga',
        '_gid',
        '_ga_cid',
        '__gads',
        '_ym_uid',
        '_ym_d',
        'tmr_lvid',
        'tmr_lvidts',
        '_fbp',
    ];

    /**
     *  {identify} => ['ga_id' => 123, ...{metrics}]
     *
     * @var array
     */
    protected $columnValues = [];

    /**
     * @inheritDoc
     */
    protected function bulkHandling(Entry $entry, array $bulk): array
    {
        if ($entry instanceof Event) {
            $cachePrefix = 'bulkWrite::clientValues__';
            foreach ($bulk as $bulkKey => $item) {
                $identify = $item['identify'] ?? Uuid::uuid4()->toString();
                if (empty($this->columnValues[$identify])) {
                    $values = $this->columnValues[$identify] = Cache::get($cachePrefix . $identify, []);
                }

                foreach ($this->adjustments as $adjustment) {
                    $metricId = $this->columnValues[$identify][$adjustment] ?? '';
                    if (!empty($item[$adjustment])) {
                        $metricId = $item[$adjustment];
                    }

                    $bulk[$bulkKey][$adjustment] = $metricId;
                    $this->columnValues[$identify][$adjustment] = $metricId;
                }
            }

            foreach ($this->columnValues as $identify => $values) {
                Cache::put($cachePrefix . $identify, $values, now()->addHours(3));
            }
        }

        return parent::bulkHandling($entry, $bulk);
    }

}
