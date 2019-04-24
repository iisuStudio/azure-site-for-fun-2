<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable( 'users_info' )) {
            Schema::create( 'users_info', function ( Blueprint $table ) {
                $table->integer( 'user_id' )->unique();
                $table->string( 'images', 255 )->nullable();
                $table->string( 'name', 255 )->nullable();
                $table->string( 'name_en', 255 )->nullable();
                $table->string( 'title', 255 )->nullable();
                $table->string( 'gender', 255 )->nullable();
                $table->string( 'person_id', 255 )->nullable();
                $table->string( 'passport_num', 255 )->nullable();
                $table->string( 'card_no', 255 )->nullable();
                $table->integer( 'birthday' )->default( 0 );
                $table->string( 'email', 255 )->nullable();
                $table->string( 'contact', 255 )->nullable();
                $table->string( 'zip_code', 255 )->nullable();
                $table->string( 'city', 255 )->nullable();
                $table->string( 'area', 255 )->nullable();
                $table->string( 'address', 255 )->nullable();
                $table->string( 'country_name', 255 )->nullable();
                $table->string( 'country_code', 255 )->nullable();
                $table->string( 'line_id', 255 )->nullable();
                $table->timestamps();
            } );
            foreach (User::get() as $user) {
                $Dao = \App\Models\UserInfo::findOrNew( $user->id );
                $Dao->user_id = $user->id;
                $Dao->name = $user->name;
                $Dao->email = $user->email;
                $Dao->save();
            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_info');
    }
}
