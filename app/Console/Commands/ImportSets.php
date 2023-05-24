<?php

namespace App\Console\Commands;

use App\Models\Set;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Command\Command as CommandAlias;

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

            return CommandAlias::FAILURE;
        }

        $sets = $response->collect($key = null)['data'];

        foreach ($sets as $set) {
            $set['scryfall_id'] = $set['id'];
            unset($set['id']);

            $entry = new Set();

            $entry->scryfall_id = $set['scryfall_id'];
            $entry->code = $set['code'];
            $entry->mtgo_code = $set['mtgo_code'] ?? null;
            $entry->tcgplayer_id = $set['tcgplayer_id'] ?? null;
            $entry->name = $set['name'];
            $entry->set_type = $set['set_type'];
            $entry->released_at = $set['released_at'] ?? null;
            $entry->block_code = $set['block_code'] ?? null;
            $entry->block = $set['block'] ?? null;
            $entry->parent_set_code = $set['parent_set_code'] ?? null;
            $entry->card_count = $set['card_count'];
            $entry->printed_size = $set['printed_size'] ?? null;
            $entry->digital = $set['digital'];
            $entry->foil_only = $set['foil_only'];
            $entry->nonfoil_only = $set['nonfoil_only'];
            $entry->scryfall_uri = $set['scryfall_uri'];
            $entry->uri = $set['uri'];
            $entry->icon_svg_uri = $set['icon_svg_uri'];
            $entry->search_uri = $set['search_uri'];

            $entry->save();
        }

        return CommandAlias::SUCCESS;
    }
}
