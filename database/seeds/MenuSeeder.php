<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as BaseModel;

class MenuSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                        BaseModel::unguard();

                        $listMenu = [
                            ['id' => 1, 'parent' => 0, 'element_id' => 0, 'module' => '', 'path' => '', 'name' => 'Главное меню', 'preview' => 'Описание главного меню'],
                            ['id' => 2, 'parent' => 1, 'element_id' => 2, 'module' => 'site', 'path' => 'first', 'name' => 'Меню Раздел1', 'preview' => 'Описание меню Раздел 1'],
                            ['id' => 3, 'parent' => 1, 'element_id' => 3, 'module' => 'site', 'path' => 'second', 'name' => 'Меню Раздел2', 'preview' => 'Описание меню Раздел 2'],
                            ['id' => 4, 'parent' => 3, 'element_id' => 4, 'module' => 'site', 'path' => 'second/subfirst', 'name' => 'Меню Раздел2.1', 'preview' => 'Описание меню Раздел 2.1'],
                            ['id' => 5, 'parent' => 3, 'element_id' => 5, 'module' => 'site', 'path' => 'second/subsecond', 'name' => 'Меню Раздел2.2', 'preview' => 'Описание меню Раздел 2.2'],
                            ['id' => 6, 'parent' => 3, 'element_id' => 6, 'module' => 'site', 'path' => 'second/subthird', 'name' => 'Меню Раздел2.3', 'preview' => 'Описание меню Раздел 2.3'],
                            ['id' => 7, 'parent' => 1, 'element_id' => 7, 'module' => 'site', 'path' => 'third', 'name' => 'Меню Раздел3', 'preview' => 'Описание меню Раздел 3'],
                            ['id' => 8, 'parent' => 0, 'element_id' => 0, 'module' => '', 'path' => '', 'name' => 'Меню Отдельное', 'preview' => 'Описание меню Отдельное'],
                            ['id' => 9, 'parent' => 8, 'element_id' => 0, 'module' => '', 'path' => 'http://yandex.ru', 'autopath' => true, 'name' => 'Яндекс', 'preview' => 'Описание меню Яндекс'],
                            ['id' => 10, 'parent' => 8, 'element_id' => 0, 'module' => '', 'path' => 'http://google.ru', 'autopath' => true, 'name' => 'Гугл', 'preview' => 'Описание меню Гугл'],
                            ['id' => 11, 'parent' => 8, 'element_id' => 0, 'module' => '', 'path' => 'http://vk.com', 'autopath' => true, 'name' => 'Вконтакте', 'preview' => 'Описание меню Вконтакте']
                        ];
                        
                        $dataBase = [
                            'act' => true,
                            'autopath' => true,
                            'sort' => 0
                        ];
                        
                        DB::table('menu')->truncate();
                        
                        foreach ($listMenu as $row) {
                            Model\Menu::create(array_merge($dataBase, $row));
                        }
	}

}
