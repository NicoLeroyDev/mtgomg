<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            /* Core Card Fields */
            $table->integer('arena_id')->nullable();
            $table->string('scryfall_id', 50);
            $table->string('lang', 25);
            $table->integer('mtgo_id')->nullable();
            $table->integer('mtgo_foil_id')->nullable();
            $table->json('multiverse_ids')->nullable();
            $table->integer('tcgplayer_id')->nullable();
            $table->integer('tcgplayer_etched_id')->nullable();
            $table->integer('cardmarket_id')->nullable();
            $table->string('object', 50);
            $table->string('oracle_id', 50)->nullable(); // Not supposed to be nullable
            $table->string('prints_search_uri', 200);
            $table->string('rulings_uri', 200);
            $table->string('scryfall_uri', 200);
            $table->string('uri', 200);
            /* Gameplay Fields */
            $table->json('all_parts')->nullable();
            $table->json('card_faces')->nullable();
            $table->float('cmc')->nullable(); // Not supposed to be nullable
            $table->json('color_identity')->nullable();
            $table->json('color_indicator')->nullable();
            $table->json('colors')->nullable();
            $table->integer('edhrec_rank')->nullable();
            $table->string('hand_modifier', 100)->nullable();
            $table->json('keywords');
            $table->string('layout', 50);
            $table->json('legalities');
            $table->string('life_modifier', 25)->nullable();
            $table->string('loyalty', 25)->nullable();
            $table->string('mana_cost', 25)->nullable();
            $table->string('name', 200);
            $table->string('oracle_text', 200)->nullable();
            $table->boolean('oversized');
            $table->string('power', 25)->nullable();
            $table->json('produced_mana')->nullable();
            $table->boolean('reserved');
            $table->string('toughness', 25)->nullable();
            $table->string('type_line', 100)->nullable(); // Not supposed to be nullable
            /* Print Fields */
            $table->string('artist', 100)->nullable();
            $table->boolean('booster');
            $table->string('border_color', 25);
            $table->string('card_back_id', 50)->nullable(); // Not supposed to be nullable
            $table->string('collector_number', 50);
            $table->boolean('content_warning')->nullable();
            $table->boolean('digital');
            $table->json('finishes');
            $table->string('flavor_name', 50)->nullable();
            $table->string('flavor_text', 500)->nullable();
            $table->json('frame_effects')->nullable();
            $table->string('frame', 25);
            $table->boolean('full_art');
            $table->json('games');
            $table->boolean('highres_image');
            $table->string('illustration_id', 50)->nullable();
            $table->string('image_status', 25);
            $table->json('image_uris')->nullable();
            $table->json('prices');
            $table->string('printed_name', 200)->nullable();
            $table->string('printed_text', 500)->nullable();
            $table->string('printed_type_line', 100)->nullable();
            $table->boolean('promo');
            $table->json('promo_types')->nullable();
            $table->json('purchase_uris')->nullable(); // Not supposed to be nullable
            $table->string('rarity', 25);
            $table->json('related_uris');
            $table->date('released_at');
            $table->boolean('reprint');
            $table->string('scryfall_set_uri', 200);
            $table->string('set_name', 100);
            $table->string('set_search_uri', 200);
            $table->string('set_type', 100);
            $table->string('set_uri', 200);
            $table->string('set', 25);
            $table->string('set_id', 50);
            $table->boolean('story_spotlight');
            $table->boolean('textless');
            $table->boolean('variation');
            $table->integer('variation_of')->nullable();
            $table->string('security_stamp', 50)->nullable();
            $table->string('watermark', 50)->nullable();
            $table->json('preview')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
