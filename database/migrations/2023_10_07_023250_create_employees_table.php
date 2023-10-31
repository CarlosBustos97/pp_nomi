<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constant;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('birth_city_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();

            $table->bigInteger('identification')->unique();
            $table->string('cellphone', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('name', 200);
            $table->char('status')->default(Constant::ACTIVE);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('birth_city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
        });
        Artisan::call('db:seed', [
            '--class' => 'EmployeeSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['birth_city_id']);
            $table->dropForeign(['manager_id']);
            $table->dropForeign(['area_id']);
            $table->dropForeign(['position_id']);
        });

        Schema::dropIfExists('employees');
    }
};
