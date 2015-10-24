<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as BaseModel;

class ImageSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                        BaseModel::unguard();

                        $listImages = [
                            ['id' => 1, 'model_id' => 0, 'model' => '', 'filename' => 'test1.jpg', 'name' => 'Фотография 1', 'description' => 'Описание фотографии 1'],
                            ['id' => 2, 'model_id' => 0, 'model' => '', 'filename' => 'test2.jpg', 'name' => 'Фотография 2', 'description' => 'Описание фотографии 2'],
                            ['id' => 3, 'model_id' => 0, 'model' => '', 'filename' => 'test3.jpg', 'name' => 'Фотография 3', 'description' => 'Описание фотографии 3'],
                            ['id' => 4, 'model_id' => 0, 'model' => '', 'filename' => 'test4.jpg', 'name' => 'Фотография 4', 'description' => 'Описание фотографии 4'],
                            ['id' => 5, 'model_id' => 0, 'model' => '', 'filename' => 'test5.jpg', 'name' => 'Фотография 5', 'description' => 'Описание фотографии 5']
                        ];
                        
                        $dataBase = [
                            'act' => true,
                            'part' => '',
                            'user_id' => 0,
                            'sort' => 0
                        ];
                        
                        DB::table('images')->truncate();
                        
                        foreach ($listImages as $row) {
                            Model\Image::create(array_merge($dataBase, $row));
                        }
	}

}
