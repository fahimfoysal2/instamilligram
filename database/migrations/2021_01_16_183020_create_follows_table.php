<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('follower_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->unique(['user_id'], ['follower_id']);
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
        Schema::table('follows', function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['follower_id']);
            $table->dropUnique(['user_id'], ['follower_id']);
        });
        Schema::dropIfExists('follows');
    }
}
