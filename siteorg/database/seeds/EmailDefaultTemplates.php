<?php

use Illuminate\Database\Seeder;

class EmailDefaultTemplates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'user_id' => null,
                'type_id' => 1,
                'type' => 'problem',
                'subject' => 'Yandex Index PROBLEM',
                'html' => '{{domain}} is not found in Yandex index',
                'text' => '{{domain}} is not found in Yandex index',
            ],
            [
                'user_id' => null,
                'type_id' => 2,
                'type' => 'problem',
                'subject' => 'Google Index PROBLEM',
                'html' => 'Your site {{domain}} is not found in Google index',
                'text' => 'Your site {{domain}} is not found in Google index',
            ],
            [
                'user_id' => null,
                'type_id' => 3,
                'type' => 'problem',
                'subject' => 'Roskomnadzor Blacklist PROBLEM',
                'html' => '{{domain}} or {{ip}} is found in Roskomnadzor blacklist. Check details here http://eais.rkn.gov.ru/',
                'text' => '{{domain}} or {{ip}} is found in Roskomnadzor blacklist. Check details here http://eais.rkn.gov.ru/',
            ],
            [
                'user_id' => null,
                'type_id' => 4,
                'type' => 'problem',
                'subject' => 'SSL Certificate PROBLEM',
                'html' => 'SSL certificate for {{domain}} will expire in {{days}} days',
                'text' => 'SSL certificate for {{domain}} will expire in {{days}} days',
            ],
            [
                'user_id' => null,
                'type_id' => 5,
                'type' => 'problem',
                'subject' => 'Domain Access PROBLEM',
                //'html' => '{{domain}} returns error «{{error}}» for {{location}}',
                //'text' => '{{domain}} returns error «{{error}}» for {{location}}',
                'html' => '{{domain}} access error',
                'text' => '{{domain}} access error',
            ],
            [
                'user_id' => null,
                'type_id' => 6,
                'type' => 'problem',
                'subject' => 'Virus PROBLEM',
                'html' => '{{domain}} is found in virus databases. Check details here {{url}}',
                'text' => '{{domain}} is found in virus databases. Check details here {{url}}',
            ],
            [
                'user_id' => null,
                'type_id' => 7,
                'type' => 'problem',
                'subject' => 'Domain expire PROBLEM',
                'html' => '{{domain}} will expire in {{days}} days',
                'text' => '{{domain}} will expire in {{days}} days',
            ],
            [
                'user_id' => null,
                'type_id' => 1,
                'type' => 'ok',
                'subject' => 'Yandex Index OK',
                'html' => '{{domain}} is found in Yandex index',
                'text' => '{{domain}} is found in Yandex index',
            ],
            [
                'user_id' => null,
                'type_id' => 2,
                'type' => 'ok',
                'subject' => 'Google Index OK',
                'html' => '{{domain}} is found in Google index',
                'text' => '{{domain}} is found in Google index',
            ],
            [
                'user_id' => null,
                'type_id' => 3,
                'type' => 'ok',
                'subject' => 'Roskomnadzor  OK',
                'html' => '{{domain}} or {{ip}} deleted from Roskomnadzor blacklist.',
                'text' => '{{domain}} or {{ip}} deleted from Roskomnadzor blacklist.',
            ],
            [
                'user_id' => null,
                'type_id' => 4,
                'type' => 'ok',
                'subject' => 'SSL Certificate OK',
                'html' => 'SSL certificate OK to {{domain}}',
                'text' => 'SSL certificate OK to {{domain}}',
            ],
            [
                'user_id' => null,
                'type_id' => 5,
                'type' => 'ok',
                'subject' => 'Domain Access OK',
                'html' => '{{domain}} Access OK for {{location}}',
                'text' => '{{domain}} Access OK for {{location}}',
            ],
            [
                'user_id' => null,
                'type_id' => 6,
                'type' => 'ok',
                'subject' => 'Virus OK',
                'html' => '{{domain}} is not found in virus databases. Check details here {{url}}',
                'text' => '{{domain}} is not found  in virus databases. Check details here {{url}}',
            ],
            [
                'user_id' => null,
                'type_id' => 7,
                'type' => 'problem',
                'subject' => 'Domain expire OK',
                'html' => '{{domain}} not expire',
                'text' => '{{domain}} not expire',
            ],

        ];
        DB::table('email_templates')->insert($templates);
    }
}
