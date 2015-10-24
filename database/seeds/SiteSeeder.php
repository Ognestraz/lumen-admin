<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as BaseModel;

class SiteSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                        BaseModel::unguard();

                        $treeSites = [
                            ['id' => 1, 'parent' => 0, 'path' => '', 'name' => 'Главная страница', 'content' => 'Текст главной страницы', 'template' => 'index'],
                            ['id' => 2, 'parent' => 1, 'path' => 'first', 'name' => 'Раздел1', 'content' => 'Текст раздела 1'],
                                ['id' => 3, 'parent' => 2, 'path' => 'first/subfirst', 'name' => 'Раздел1.1', 'content' => 'Текст раздела 1.1'],
                                ['id' => 4, 'parent' => 2, 'path' => 'first/subsecond', 'name' => 'Раздел1.2', 'content' => 'Текст раздела 1.2'],
                                    ['id' => 5, 'parent' => 4, 'path' => 'first/subsecond/a', 'name' => 'Раздел1.2.a', 'content' => 'Текст раздела 1.2.a'],
                                    ['id' => 6, 'parent' => 4, 'path' => 'first/subsecond/b', 'name' => 'Раздел1.2.b', 'content' => 'Текст раздела 1.2.b'],
                                ['id' => 7, 'parent' => 2, 'path' => 'first/subthird', 'name' => 'Раздел1.3', 'content' => 'Текст раздела 1.3'],                            
                            ['id' => 8, 'parent' => 1, 'path' => 'second', 'name' => 'Раздел2', 'content' => 'Текст раздела 2'],
                                ['id' => 9, 'parent' => 8, 'path' => 'second/subfirst', 'name' => 'Раздел2.1', 'content' => 'Текст раздела 2.1'],
                                ['id' => 10, 'parent' => 8, 'path' => 'second/subsecond', 'name' => 'Раздел2.2', 'content' => 'Текст раздела 2.2'],
                                ['id' => 11, 'parent' => 8, 'path' => 'second/subthird', 'name' => 'Раздел2.3', 'content' => 'Текст раздела 2.3'],
                            ['id' => 12, 'parent' => 1, 'path' => 'third', 'name' => 'Раздел3', 'content' => 'Текст раздела 3'],
                        ];
                        
                        $dataBase = [
                            'act' => true,
                            'block' => false,
                            'system' => false,
                            'parent' => 0,
                            'part' => '',
                            'name' => '',
                            'path' => '',
                            'autopath' => false,
                            'level' => 0,
                            'preview' => '',
                            'content' => '',
                            'title' => '',
                            'keywords' => '',
                            'description' => '',
                            'template' => 'default',
                            'template_childs' => '',
                            'sort' => 0,
                           // 'settings' => ''
                        ];
                        
                        DB::table('site')->truncate();
                        foreach ($treeSites as $row) {
                            Model\Site::create(array_merge($dataBase, $row));
                        }
	}

}
