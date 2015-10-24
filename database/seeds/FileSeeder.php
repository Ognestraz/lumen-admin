<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as BaseModel;

class FileSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                        BaseModel::unguard();

                       /* $listFiles = [
                            ['id' => 1, 'model_id' => 0, 'model' => '', 'filename' => 'test1.jpg', 'name' => 'Файл 1', 'description' => 'Описание файла 1'],
                            ['id' => 2, 'model_id' => 0, 'model' => '', 'filename' => 'test2.jpg', 'name' => 'Файл 2', 'description' => 'Описание файла 2'],
                            ['id' => 3, 'model_id' => 0, 'model' => '', 'filename' => 'test3.jpg', 'name' => 'Файл 3', 'description' => 'Описание файла 3'],
                            ['id' => 4, 'model_id' => 0, 'model' => '', 'filename' => 'test4.jpg', 'name' => 'Файл 4', 'description' => 'Описание файла 4'],
                            ['id' => 5, 'model_id' => 0, 'model' => '', 'filename' => 'test5.jpg', 'name' => 'Файл 5', 'description' => 'Описание файла 5']
                        ];*/
                        
                        $listFiles = [];
                        for ($i = 1; $i <= 10; $i++) {
                            $listFiles[] = ['id' => $i, 'model_id' => 0, 'model' => '', 'filename' => "test{$i}.jpg", 'name' => "Файл {$i}", 'description' => "Описание файла {$i}"];
                        }
                        
                        $dataBase = [
                            'act' => true,
                            'part' => '',
                            'user_id' => 0,
                            'sort' => 0
                        ];
                        
                        
                        DB::table('files')->truncate();
                        
                        foreach ($listFiles as $row) {
                           Model\File::create(array_merge($dataBase, $row));
                        }
	}

}
