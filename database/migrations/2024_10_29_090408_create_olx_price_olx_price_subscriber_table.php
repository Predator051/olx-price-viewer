<?php

use App\Models\OlxPrice;
use App\Models\OlxPriceSubscriber;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('olx_price_olx_price_subscriber', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(OlxPrice::class)->constrained();
            $table->foreignIdFor(OlxPriceSubscriber::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('olx_price_olx_price_subscriber');
    }
};
