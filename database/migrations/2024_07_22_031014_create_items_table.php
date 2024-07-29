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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('serial_no');
            $table->decimal('gst_rate', 5, 2)->nullable();
            $table->integer('opening_stock');
            $table->integer('current_stock');
            $table->decimal('wholesale_price', 8, 2);
            $table->decimal('retail_price', 8, 2);
            $table->string('image')->nullable();
            $table->dateTime('last_purchase_date')->nullable();
            $table->dateTime('last_sale_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
