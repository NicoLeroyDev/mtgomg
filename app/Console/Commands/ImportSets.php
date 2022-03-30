<?php

namespace App\Console\Commands;

use App\Models\Set;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportSets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import sets from Scryfall API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get(env('SCRYFALL_API_URL') . '/sets/');

        if ($response->status() !== 200) {
            $this->error('Error while contacting the Scryfall API (Sets).');

            return Command::FAILURE;
        }

        $sets = $response->collect($key = null)['data'];

        foreach ($sets as $set) {
            $set['scryfall_id'] = $set['id'];
            unset($set['id']);

            $entry = new Set();

            $entry->name = $set['name'];

            $entry->save();



            dd($set);
        }
    }
}
