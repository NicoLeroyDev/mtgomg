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
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->string('scryfall_id', 100);
            $table->string('code', 25);
            $table->string('mtgo_code', 25)->nullable();
            $table->integer('tcgplayer_id')->nullable();
            $table->string('name', 100);
            $table->string('set_type', 25);
            $table->date('released_at')->nullable();
            $table->string('block_code', 25)->nullable();
            $table->string('block', 50)->nullable();
            $table->string('parent_set_code', 25)->nullable();
            $table->integer('card_count');
            $table->integer('printed_size')->nullable();
            $table->boolean('digital');
            $table->boolean('foil_only');
            $table->boolean('nonfoil_only');
            $table->string('scryfall_uri', 200);
            $table->string('uri', 200);
            $table->string('icon_svg_uri', 200);
            $table->string('search_uri', 200);
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
        Schema::dropIfExists('sets');
    }
};
