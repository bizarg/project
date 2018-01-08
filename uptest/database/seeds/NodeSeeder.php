<?php

use Illuminate\Database\Seeder;

class NodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('nodes')->insert(
            [
                ['name' => 'lcdach1.vamhost.net', 'ip' => '68.232.187.52', 'port' => 8585, 'country' => 'USA / Newark: Choopa', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdacn1.vamhost.net', 'ip' => '66.240.223.153', 'port' => 8585, 'country' => 'USA / San Diego: CariNet', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdaet1.vamhost.net', 'ip' => '93.174.93.172', 'port' => 8585, 'country' => 'Netherlands / Amsterdam: Ecatel', 'flag' => 'NL', 'status' => 'active'],
                ['name' => 'lcdagi2.vamhost.net', 'ip' => '79.143.179.193', 'port' => 8585, 'country' => 'Germany / Munich: Giga International', 'flag' => 'DE', 'status' => 'active'],
                ['name' => 'lcdalw389.vamhost.net', 'ip' => '95.211.108.95', 'port' => 8585, 'country' => 'Netherlands / Amsterdam: LeaseWeb', 'flag' => 'NL', 'status' => 'active'],
                ['name' => 'lcdalw459.vamhost.net', 'ip' => '85.17.31.91', 'port' => 8585, 'country' => 'Netherlands / Amsterdam: LeaseWeb', 'flag' => 'NL', 'status' => 'active'],
                ['name' => 'lcdalm361.vamhost.net', 'ip' => '199.115.116.193', 'port' => 8585, 'country' => 'USA / Manassas: LeaseWebUSA', 'flag' => 'US', 'status' => 'active'],
                ['name' => ' lcdamp335.vamhost.net', 'ip' => '109.123.116.108', 'port' => 8585, 'country' => 'United Kingdom / London: MidPhase (UK2)', 'flag' => 'GB', 'status' => 'active'],
                ['name' => 'lcdand23.vamhost.net', 'ip' => '46.165.193.9', 'port' => 8585, 'country' => 'Germany / Frankfurt: NetDirect', 'flag' => 'DE', 'status' => 'active'],
                ['name' => 'lcdanp30.vamhost.net', 'ip' => '216.180.231.114', 'port' => 8585, 'country' => 'USA / Atlanta: Gnax', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdaph88.vamhost.net', 'ip' => '213.229.124.7', 'port' => 8585, 'country' => 'United Kingdom / London: BlueSquare', 'flag' => 'GB', 'status' => 'active'],
                ['name' => 'lcdare1.vamhost.net', 'ip' => '31.3.240.114', 'port' => 8585, 'country' => 'United Kingdom / London: Redstation', 'flag' => 'GB', 'status' => 'active'],
                ['name' => 'lcdars1.vamhost.net', 'ip' => '78.129.192.55', 'port' => 8585, 'country' => 'United Kingdom / London: RapidSwitch', 'flag' => 'GB', 'status' => 'active'],
                ['name' => 'lcdasl2.vamhost.net', 'ip' => '209.239.114.24', 'port' => 8585, 'country' => 'USA / St. Louis: ServerLoft', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdahe1.vamhost.net', 'ip' => '78.46.43.246', 'port' => 8585, 'country' => 'Germany / Bayern: Hetzner', 'flag' => 'DE', 'status' => 'active'],
                ['name' => 'lcdadn1.vamhost.net', 'ip' => '65.98.62.234', 'port' => 8585, 'country' => 'USA / New Jersey: DedicatedNOW', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdaiw2.vamhost.net', 'ip' => '70.38.11.48', 'port' => 8585, 'country' => 'Canada / Montreal: iWeb', 'flag' => 'CA', 'status' => 'active'],
                ['name' => 'lcdagn112.vamhost.net', 'ip' => '69.65.42.133', 'port' => 8585, 'country' => 'USA / Chicago: GigeNet', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdamp543.vamhost.net', 'ip' => '50.23.131.215', 'port' => 8585, 'country' => 'USA / Seattle: MidPhase (SoftLayer)', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdahv15.vamhost.net', 'ip' => '199.193.118.157', 'port' => 8585, 'country' => 'USA / Tampa: Hivelocity', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdawz3.vamhost.net', 'ip' => '74.117.179.47', 'port' => 8585, 'country' => 'USA / Dallas: Colo4', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdamp710.vamhost.net', 'ip' => '198.105.215.4', 'port' => 8585, 'country' => 'USA / SaltLakeCity: MidPhase (UK2)', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'lcdamp56.vamhost.net', 'ip' => '174.127.85.39', 'port' => 8585, 'country' => 'USA / Dallas: MidPhase', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'ledamp57.vamhost.net', 'ip' => '174.37.222.52', 'port' => 8585, 'country' => 'USA / Washington: MidPhase (SoftLayer)', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'ledamp430.vamhost.net', 'ip' => '159.253.143.55', 'port' => 8585, 'country' => 'Netherlands / Amsterdam: MidPhase (SoftLayer)', 'flag' => 'NL', 'status' => 'active'],
                ['name' => 'ledamp711.vamhost.net', 'ip' => '50.97.232.167', 'port' => 8585, 'country' => 'USA / San Jose: MidPhase', 'flag' => 'US', 'status' => 'active'],
                ['name' => 'ledamp713.vamhost.net', 'ip' => '119.81.66.222', 'port' => 8585, 'country' => 'Singapore / Singapore: MidPhase', 'flag' => 'SG', 'status' => 'active'],
                ['name' => 'lcvmov1.vamhost.net', 'ip' => '5.196.121.194', 'port' => 8585, 'country' => 'France / Gravelines: OVH', 'flag' => 'FR', 'status' => 'active'],
                ['name' => 'hl1.amhost.net', 'ip' => '195.16.90.32', 'port' => 8585, 'country' => 'Ukraine / Kiev : HostLife', 'flag' => 'UA', 'status' => 'active'],
                ['name' => 'lcdavm13', 'ip' => '193.29.187.102', 'port' => 8585, 'country' => 'Romania / Romaina : Thcservers', 'flag' => 'RO', 'status' => 'active'],
                ['name' => 'lcdavm14.amhost.net', 'ip' => '94.23.98.1', 'port' => 8585, 'country' => 'France / Roubax: OVH', 'flag' => 'FR', 'status' => 'active'],
                ['name' => '89.163.253.206', 'ip' => '89.163.253.206', 'port' => 8585, 'country' => 'Germany / Duesseldorf', 'flag' => 'DE', 'status' => 'active'],
                ['name' => 'sl3-vm17', 'ip' => '62.75.223.134', 'port' => 8585, 'country' => 'France/Strasbourg', 'flag' => 'FR', 'status' => 'active'],
                ['name' => 'fv-1', 'ip' => '82.146.52.85', 'port' => 8585, 'country' => 'Russia / Moscow : FirstVDS', 'flag' => 'RU', 'status' => 'active'],
            ]);
    }
}
