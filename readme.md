#### Installation:
```
composer require devslane/generator
```

#### Publish:
```
php artisan vendor:publish --provider="Devslane\Generator\Providers\GeneratorServiceProvider"
```

#### Create Migration

```
php artisan mcs:create-migration testtable --columns=col1:integer,col2:string,col3:datetime,col4:boolean,user_id:fk=users



class CreateTesttableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testtable', function (Blueprint $table) {
            $table->bigIncrements('id');            
			$table->integer('col1');
			$table->string('col2');
			$table->string('col3');
			$table->boolean('col4');
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('testtable');
    }
}

```
