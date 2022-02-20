<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class); // The Authoring User

            $table->string('title', 255);

            $table->string('slug', 255)
                ->unique(); // Make the slug an index

            $table->string('description', 255)->nullable(); // The Post Description, used in SEO and Post Previews

            $table->string('featured_image', 255)->nullable(); // Post cover and social sharing image

            $table->json('tags')->nullable(); // Post tags (categories)

            $table->longText('body'); // The Post Body
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
        Schema::dropIfExists('posts');
    }
};
