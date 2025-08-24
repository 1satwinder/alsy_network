<?php

use App\Models\SubPhotoGallery;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubPhotoGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_photo_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('photo_gallery_id');
            $table->string('youtube_link')->nullable();
            $table->integer('status')->index()
                ->comment('1: Active, 2: In-Active')
                ->default(SubPhotoGallery::STATUS_ACTIVE);
            $table->timestamps();

            $table->foreign('photo_gallery_id')->references('id')->on('photo_galleries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_photo_galleries');
    }
}
