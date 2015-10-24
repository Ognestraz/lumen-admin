<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as BaseModel;

class VideoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                        BaseModel::unguard();

                        $listVideos = [
                            ['id' => 1, 'model_id' => 0, 'model' => '', 'url' => 'http://youtube.com/watch?v=YD4ksoIoWdE', 'name' => 'Видео 1', 'description' => 'Описание фотографии 1'],
                            ['id' => 2, 'model_id' => 0, 'model' => '', 'url' => 'http://youtube.com/watch?v=Ua490zSutXs', 'name' => 'Видео 2', 'description' => 'Описание фотографии 2'],
                            ['id' => 3, 'model_id' => 0, 'model' => '', 'url' => 'http://youtube.com/watch?v=maGVkhuXUQA', 'name' => 'Видео 3', 'description' => 'Описание фотографии 3'],
                            ['id' => 4, 'model_id' => 0, 'model' => '', 'url' => 'http://youtube.com/watch?v=_SOPXIoEQ6w', 'name' => 'Видео 4', 'description' => 'Описание фотографии 4'],
                            ['id' => 5, 'model_id' => 0, 'model' => '', 'url' => 'http://youtube.com/watch?v=kMed8pin2dM', 'name' => 'Видео 5', 'description' => 'Описание фотографии 5']
                        ];
                        
                        $dataBase = [
                            'act' => true,
                            'part' => '',
                            'user_id' => 0,
                            'sort' => 0
                        ];
                        
                        DB::table('videos')->truncate();
                        
                        foreach ($listVideos as $row) {
                            Model\Video::create(array_merge($dataBase, $row));
                        }
	}

}
