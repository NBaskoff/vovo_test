<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->fulltext();
            //$table->decimal('price', 10, 2)->default(0)->index();
            $table->float('price', 10, 2)->default(0)->index();
            //$table->foreignIdFor(\App\Models\Category::class)->default(0)->index()->constrained()->cascadeOnDelete();
            $table->integer('category_id')->default(0)->index();
            $table->boolean('in_stock')->default(false)->index();
            $table->float('rating', 10, 2)->default(0)->index()->comment('0–5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
