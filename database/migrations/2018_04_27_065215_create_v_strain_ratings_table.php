<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVStrainRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_strain_ratings AS
SELECT *, CAST(AVG(rating )AS DECIMAL(8,2)) as total 
FROM `strain_ratings`
GROUP BY strain_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('v_srtain_ratings');
    }
}
