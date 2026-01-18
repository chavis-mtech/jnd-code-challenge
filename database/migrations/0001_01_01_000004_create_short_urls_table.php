<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('short_urls', function (Blueprint $table) {
        $table->id();
        $table->string('code', 100)->unique();
        $table->string('origin_url', 2048)->unique();
        $table->timestamp('created_at')->useCurrent();
        $table->softDeletes();
      });


      Schema::create('user_short_urls', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('short_url_id');
        $table->unsignedBigInteger('count')->default(0);
        $table->timestamp('last_accessed_at')->nullable();
        $table->date('expires_date');
        $table->tinyInteger('status')->default(1)->comment('0=inactive, 1=active');
        $table->timestamps();
        $table->softDeletes();

        $table->unique(['user_id', 'short_url_id']);

        $table->index(['user_id', 'short_url_id']);

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('short_url_id')->references('id')->on('short_urls')->onDelete('cascade');
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('short_urls');
      Schema::dropIfExists('user_short_urls');
    }
  };
