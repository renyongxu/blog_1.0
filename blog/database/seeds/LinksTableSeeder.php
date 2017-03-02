<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
          [
              'link_name' => '测试你1',
              'link_title' => '测试是否能够成功1',
              'link_url' => 'http://www.baidu.com',
              'link_order' => 1,
          ],
            [
                'link_name' => '测试你2',
                'link_title' => '测试是否能够成功2',
                'link_url' => 'http://www.souhu.com',
                'link_order' => 2,
            ]
        ];
        DB::table('links')->insert($data);
    }
}
