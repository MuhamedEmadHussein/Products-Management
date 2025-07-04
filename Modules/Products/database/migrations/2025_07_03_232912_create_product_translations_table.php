<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->unique(['product_id', 'locale']);
            $table->timestamps();
        });

        // Move existing data to translations table if columns exist
        if (Schema::hasColumns('products', ['name'])) {
            $products = DB::table('products')->get();
            foreach ($products as $product) {
                DB::table('product_translations')->insert([
                    'product_id' => $product->id,
                    'locale' => config('app.locale', 'en'),
                    'name' => $product->name ?? '',
                    'description' => $product->description ?? '',
                    'notes' => $product->notes ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Drop translatable columns from products table
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'name')) {
                    $table->dropColumn('name');
                }
                if (Schema::hasColumn('products', 'description')) {
                    $table->dropColumn('description');
                }
                if (Schema::hasColumn('products', 'notes')) {
                    $table->dropColumn('notes');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add columns back to products table if they don't exist
        if (!Schema::hasColumns('products', ['name', 'description', 'notes'])) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->text('notes')->nullable();
            });
            
            // Move data back from translations table
            $translations = DB::table('product_translations')
                ->where('locale', config('app.locale', 'en'))
                ->get();
            foreach ($translations as $translation) {
                DB::table('products')
                    ->where('id', $translation->product_id)
                    ->update([
                        'name' => $translation->name,
                        'description' => $translation->description,
                        'notes' => $translation->notes,
                    ]);
            }
        }

        Schema::dropIfExists('product_translations');
    }
};
