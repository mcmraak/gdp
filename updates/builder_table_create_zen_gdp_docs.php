<?php namespace Zen\Gdp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateZenGdpDocs extends Migration
{
    public function up()
    {
        Schema::create('zen_gdp_docs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('link')->nullable();
            $table->text('html')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('zen_gdp_docs');
    }
}