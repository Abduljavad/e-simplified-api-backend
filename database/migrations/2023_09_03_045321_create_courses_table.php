<?php

use App\Models\Category;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_free')->default(0);
            $table->json('thumbnail')->nullable();
            $table->json('banner_image')->nullable();
            $table->foreignIdFor(Category::class)->nullable();
            $table->json('course_offerings')->nullable();
            $table->json('course_outcomes')->nullable();
            $table->json('teachers')->nullable();
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
        Schema::dropIfExists('courses');
    }
};
