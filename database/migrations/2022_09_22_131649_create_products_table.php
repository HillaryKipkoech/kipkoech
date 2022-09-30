<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_Category');
            $table->string('product_image');
            $table->decimal('product_price');
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
        Schema::dropIfExists('products');
    }
}

// Client ID: 1
// Client secret: AAm4Qh1eLUeo7q9SmCNOg8VaglPgfVSZWoLdX7I5
// Password grant client created successfully.
// Client ID: 2
// Client secret: hptqXReJFHbF04Qm9KfW3m752orYMzBsVgEWw4yD
