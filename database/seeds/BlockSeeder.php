<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as BaseModel;

class BlockSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                        BaseModel::unguard();

                        $listBlock = [
                            ['id' => 1, 'parent' => 0, 'name' => 'main', 'title' => 'Главный блок', 'content' => 'Текст главного блока'],
                            ['id' => 2, 'parent' => 0, 'name' => 'main2', 'title' => 'Главный блок2', 'content' => 'Текст главного блока2'],
                            ['id' => 3, 'parent' => 0, 'name' => 'main3', 'title' => 'Главный блок3', 'content' => 'Текст главного блока3'],
                            ['id' => 4, 'parent' => 3, 'name' => 'main4', 'title' => 'Главный блок4','content' => 'Текст главного блока4'],
                            ['id' => 5, 'parent' => 3, 'name' => 'main5', 'title' => 'Главный блок5', 'content' => 'Текст главного блока5']
                        ];
                        
                        $dataBase = [
                            'act' => true,
                            'path' => '',
                            'autopath' => true,
                            'part' => '',
                            'sort' => 0
                        ];
                        
                        DB::table('block')->truncate();
                        
                        foreach ($listBlock as $row) {
                            Model\Block::create(array_merge($dataBase, $row));
                        }
	}

}
