<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('notes')->nullable();
            $table->unique(['category_id', 'locale']);
            $table->timestamps();
        });

        // Move existing data to translations table
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            DB::table('category_translations')->insert([
                'category_id' => $category->id,
                'locale' => config('app.locale', 'en'),
                'name' => $category->name,
                'notes' => $category->notes,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Drop translatable columns from categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name', 'notes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name');
            $table->text('notes')->nullable();
        });

        // Move data back from translations table
        $translations = DB::table('category_translations')
            ->where('locale', config('app.locale', 'en'))
            ->get();
        foreach ($translations as $translation) {
            DB::table('categories')
                ->where('id', $translation->category_id)
                ->update([
                    'name' => $translation->name,
                    'notes' => $translation->notes,
                ]);
        }

        Schema::dropIfExists('category_translations');
    }
};
