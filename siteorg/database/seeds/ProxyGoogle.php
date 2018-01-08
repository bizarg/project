<?php

use App\Proxy;
use Illuminate\Database\Seeder;

class ProxyGoogle extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $proxies = [
            ['151.80.209.19', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.20', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.21', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.22', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.23', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.27', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.28', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.29', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.30', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.31', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.64', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.65', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.66', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.67', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.68', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.69', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.70', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.209.71', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.67.123', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.67.124', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.67.125', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.67.126', 3128, 'testuser', 'uu3Pee9jei'],
            ['151.80.67.127', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.147', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.148', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.149', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.150', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.151', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.163', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.164', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.165', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.166', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.167', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.171', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.172', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.173', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.174', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.175', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.179', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.180', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.181', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.182', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.183', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.187', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.188', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.189', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.190', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.191', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.195', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.196', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.197', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.198', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.199', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.211', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.212', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.213', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.214', 3128, 'testuser', 'uu3Pee9jei'],
            ['178.33.98.215', 3128, 'testuser', 'uu3Pee9jei'],
            ['5.196.121.205', 3128, 'testuser', 'uu3Pee9jei'],
            ['185.2.137.109', 3128, 'testuser', 'uu3Pee9jei'],
            ['185.2.137.110', 3128, 'testuser', 'uu3Pee9jei'],
            ['185.38.184.32', 3128, 'testuser', 'uu3Pee9jei'],
            ['185.38.184.33', 3128, 'testuser', 'uu3Pee9jei'],
            ['185.38.184.34', 3128, 'testuser', 'uu3Pee9jei'],
            ['185.38.184.43', 3128, 'testuser', 'uu3Pee9jei'],
            ['185.38.184.44', 3128, 'testuser', 'uu3Pee9jei'],
            ['185.38.184.45', 3128, 'testuser', 'uu3Pee9jei'],
            ['46.28.55.119', 3128, 'testuser', 'uu3Pee9jei'],
            ['46.28.55.123', 3128, 'testuser', 'uu3Pee9jei'],
            ['46.28.55.124', 3128, 'testuser', 'uu3Pee9jei'],
            ['46.28.55.125', 3128, 'testuser', 'uu3Pee9jei'],
            ['5.63.150.132', 3128, 'testuser', 'uu3Pee9jei'],
            ['5.63.150.133', 3128, 'testuser', 'uu3Pee9jei'],
            ['5.63.150.134', 3128, 'testuser', 'uu3Pee9jei'],
            ['5.63.150.135', 3128, 'testuser', 'uu3Pee9jei'],
        ];

        foreach ($proxies as $proxy) {
            $newPr = new Proxy();
            $newPr->ip = $proxy[0];
            $newPr->port = $proxy[1];
            $newPr->login = $proxy[2];
            $newPr->password = $proxy[3];
            $newPr->type = 'google';
            $newPr->save();
        }
    }
}
