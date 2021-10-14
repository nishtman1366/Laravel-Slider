<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('SLIDER_CATEGORY_CREATED');
            $table->timestamps();
        });

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Nishtman\LaravelSlider\Models\Category::class)->constrained('sliders_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->string('subtitle');
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->string('status')->default('SLIDER_CREATED');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
