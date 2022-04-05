<?php

namespace App\Console\Commands;

use App\Models\Card;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cards from Scryfall API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* First, we need to find a download url in Scryfall API bulk data section for our json */
        $bulk_response = Http::get(env('SCRYFALL_API_URL') . '/bulk-data/all_cards/');

        if ($bulk_response->status() !== 200) {
            $this->error('Error while contacting the Scryfall API (Cards bulk data root).');

            return Command::FAILURE;
        }

        $download_uri = $bulk_response->collect($key = null)['download_uri'];

        /*
        Then we send a request to this download url to find all cards data in a json
        The database is huge, we have to set a timeout of 300 seconds to avoid timeout errors
        */
        $cards_response = Http::timeout(300)->get($download_uri);

        if ($cards_response->status() !== 200) {
            $this->error('Error while contacting the Scryfall API (Cards bulk data final json).');

            return Command::FAILURE;
        }

        $cards = $cards_response->collect($key = null);

        foreach ($cards as $card) {
            $card['scryfall_id'] = $card['id'];
            unset($card['id']);

            $entry = new Card();

            /* Core Card Fields */
            $entry->scryfall_id = $card['scryfall_id'];
            $entry->arena_id = $card['arena_id'] ?? null;
            $entry->lang = $card['lang'];
            $entry->mtgo_id = $card['mtgo_id'] ?? null;
            $entry->mtgo_foil_id = $card['mtgo_foil_id'] ?? null;
            $entry->multiverse_ids = $card['multivers_ids'] ?? null;
            $entry->tcgplayer_id = $card['tcgplayer_id'] ?? null;
            $entry->tcgplayer_etched_id = $card['tcgplayer_etched_id'] ?? null;
            $entry->cardmarket_id = $card['cardmarket_etched_id'] ?? null;
            $entry->object = $card['object'];
            $entry->oracle_id = $card['oracle_id'] ?? null;  // Not supposed to be nullable
            $entry->prints_search_uri = $card['prints_search_uri'];
            $entry->rulings_uri = $card['rulings_uri'];
            $entry->scryfall_uri = $card['scryfall_uri'];
            $entry->uri = $card['uri'];
            /* Gameplay Fields */
            $entry->all_parts = $card['all_parts'] ?? null;
            $entry->card_faces = $card['card_faces'] ?? null;
            $entry->cmc = $card['cmc'] ?? null;  // Not supposed to be nullable
            $entry->color_identity = $card['color_identity'] ?? null;
            $entry->color_indicator = $card['color_indicator'] ?? null;
            $entry->colors = $card['colors'] ?? null;
            $entry->edhrec_rank = $card['edhrec_rank'] ?? null;
            $entry->hand_modifier = $card['hand_modifier'] ?? null;
            $entry->keywords = $card['keywords'];
            $entry->layout = $card['layout'];
            $entry->legalities = $card['legalities'];
            $entry->life_modifier = $card['life_modifier'] ?? null;
            $entry->loyalty = $card['loyalty'] ?? null;
            $entry->mana_cost = $card['mana_cost'] ?? null;
            $entry->name = $card['name'];
            $entry->oracle_text = $card['oracle_text'] ?? null;
            $entry->oversized = $card['oversized'];
            $entry->power = $card['power'] ?? null; // Not supposed to be nullable
            $entry->produced_mana = $card['produced_mana'] ?? null;
            $entry->reserved = $card['reserved'];
            $entry->toughness = $card['toughness'] ?? null;
            $entry->type_line = $card['type_line'] ?? null;
            /* Print Fields */
            $entry->artist = $card['artist'] ?? null;
            $entry->booster = $card['booster'];
            $entry->border_color = $card['border_color'];
            $entry->card_back_id = $card['card_back_id'] ?? null;  // Not supposed to be nullable

            $entry->collector_number = $card['collector_number'];
            $entry->content_warning = $card['content_warning'] ?? null;
            $entry->digital = $card['digital'];
            $entry->finishes = $card['finishes'];
            $entry->flavor_name = $card['flavor_name'] ?? null;
            $entry->flavor_text = $card['flavor_text'] ?? null;
            $entry->frame_effects = $card['frame_effects'] ?? null;
            $entry->frame = $card['frame'];
            $entry->full_art = $card['full_art'];
            $entry->games = $card['games'];
            $entry->highres_image = $card['highres_image'];
            $entry->illustration_id = $card['illustration_id'] ?? null;
            $entry->image_status = $card['image_status'];
            $entry->image_uris = $card['image_uris'] ?? null;
            $entry->prices = $card['prices'];
            $entry->printed_name = $card['printed_name'] ?? null;
            $entry->printed_text = $card['printed_text'] ?? null;
            $entry->printed_type_line = $card['printed_type_line'] ?? null;
            $entry->promo = $card['promo'];
            $entry->promo_types = $card['promo_types'] ?? null;
            $entry->purchase_uris = $card['purchase_uris'] ?? null; // Not supposed to be nullable
            $entry->rarity = $card['rarity'];
            $entry->related_uris = $card['related_uris'];
            $entry->released_at = $card['released_at'];
            $entry->reprint = $card['reprint'];
            $entry->scryfall_set_uri = $card['scryfall_set_uri'];
            $entry->set_name = $card['set_name'];
            $entry->set_search_uri = $card['set_search_uri'];
            $entry->set_type = $card['set_type'];
            $entry->set_uri = $card['set_uri'];
            $entry->set = $card['set'];
            $entry->set_id = $card['set_id'];
            $entry->story_spotlight = $card['story_spotlight'];
            $entry->textless = $card['textless'];
            $entry->variation = $card['variation'];
            $entry->variation_of = $card['variation_of'] ?? null;
            $entry->security_stamp = $card['security_stamp'] ?? null;
            $entry->watermark = $card['watermark'] ?? null;
            $entry->preview = $card['preview'] ?? null;

            $entry->save();
        }

        echo 'The import has been made successfully (Cards)';

        return Command::SUCCESS;
    }
}
