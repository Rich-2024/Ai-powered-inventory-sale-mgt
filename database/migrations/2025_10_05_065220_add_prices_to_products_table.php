<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricesToProductsTable extends Migration
{
   public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('original_qty')->default(0)->after('quantity');
            $table->unsignedInteger('loose_pieces')->default(0)->after('original_qty');
            $table->enum('unit_type', ['piece', 'dozen', 'carton'])->default('piece')->after('loose_pieces');
            $table->unsignedInteger('unit_conversion')->default(1)->after('unit_type'); // e.g. 12 for dozen, 24 for carton
        });
    }
 public function down()
{
    Schema::table('products', function (Blueprint $table) {
        if (Schema::hasColumn('products', 'original_qty')) {
            $table->dropColumn('original_qty');
        }
        if (Schema::hasColumn('products', 'loose_pieces')) {
            $table->dropColumn('loose_pieces');
        }
        if (Schema::hasColumn('products', 'unit_type')) {
            $table->dropColumn('unit_type');
        }
        if (Schema::hasColumn('products', 'unit_conversion')) {
            $table->dropColumn('unit_conversion');
        }
    });
}

}
