<?php

namespace App;

use App\Events\PrintersChanged;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Printer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status', 'print_server', 'held_jobs'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('open', function (Builder $builder) {
            $builder->whereNotIn('status', ['OK'])
                ->orderBy('name', 'desc');
        });
    }

    public static function getStats()
    {
        $client = new Client();

        $response = $client->request('GET', 'http://pirateprint.ecu.edu:9191/api/health/printers', [
            'query' => ['Authorization' => env('PAPERCUT_AUTH_TOKEN')]
        ])->getBody();

        $json_response = json_decode($response);

        foreach ($json_response->printers as $jr) {
            $print_server = explode("\\", $jr->name)[0];
            if (($print_server === 'uniprint' || $print_server === 'papercut')) {
                Printer::updateOrCreate(
                    [
                        'name' => $jr->name
                    ],
                    [
                        'print_server' => $print_server,
                        'status' => $jr->status,
                        'held_jobs' => $jr->heldJobsCount
                    ]
                );
            }
        }

        event(new PrintersChanged);
    }
}
