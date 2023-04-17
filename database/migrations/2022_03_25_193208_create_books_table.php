<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->text('description');
            $table->string('cover_image_url')->nullable();
            $table->date('publication_year');
            $table->integer('pages');
            $table->unsignedDecimal('price', 25, 2);
            $table->string('isbn');
            $table->mediumInteger('copies');
            $table->boolean('in_stock')->default(true);
            $table->boolean('is_highlighted')->default(false);
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
        Schema::dropIfExists('books');
    }
};
