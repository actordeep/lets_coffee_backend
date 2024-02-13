<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('item_id'); // E.g., ID of the coffee product
            $table->unsignedInteger('rating');
            $table->text('description');
            $table->timestamps();

            $table->unique(['user_id','item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}