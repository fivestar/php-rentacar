<?php

namespace Acme\RentacarBundle\Tests\Controller;

use Acme\RentacarBundle\Tests\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->loadFixtures();
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("予約フォームへ進む")')->count() > 0);
    }

    public function testNew()
    {
        $client = static::createClient();

        // /reservation/new
        $crawler = $client->request('GET', '/reservation/new');

        $this->assertTrue($crawler->filter('h1:contains("予約")')->count() > 0);

        $form = $crawler->selectButton('車種選択へ進む')->form();
        $crawler = $client->submit($form, array(
            'reservation_location[departureAt][date][year]'   => '2012',
            'reservation_location[departureAt][date][month]'  => '4',
            'reservation_location[departureAt][date][day]'    => '1',
            'reservation_location[departureAt][time][hour]'   => '12',
            'reservation_location[departureAt][time][minute]' => '0',
            'reservation_location[departureLocation]'         => '1',
            'reservation_location[returnAt][date][year]'      => '2012',
            'reservation_location[returnAt][date][month]'     => '4',
            'reservation_location[returnAt][date][day]'       => '2',
            'reservation_location[returnAt][time][hour]'      => '17',
            'reservation_location[returnAt][time][minute]'    => '30',
            'reservation_location[returnLocation]'            => '1',
        ));

        // reservation/car
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('h1:contains("車種選択")')->count() > 0);

        $form = $crawler->filter('.car-class-box:first-child')->selectButton('この車種を選択する')->form();
        $crawler = $client->submit($form);

        // login
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('h1:contains("ログイン")')->count() > 0);
        $this->assertTrue($crawler->filter('div.alert:contains("予約を行うには会員登録が必要です。")')->count() > 0);

        $form = $crawler->selectButton('ログイン')->form();
        $crawler = $client->submit($form, array(
            'login[email]' => 'user1@example.com',
            'login[password]' => 'password',
        ));

        // reservation/option
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('h1:contains("予約/オプション選択")')->count() > 0);

        $form = $crawler->selectButton('予約内容を確認する')->form();
        $crawler = $client->submit($form, array(
            'reservation_option[useInsurance]' => 1,
            'reservation_option[note]' => 'テスト',
        ));

        // reservation/confirm
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('h1:contains("予約内容確認")')->count() > 0);
        $table = $crawler->filter('.amount-table');
        $this->assertTrue($table->filter('.car-subtotal-row .amount-col:contains("¥ 18,000")')->count() > 0);
        $this->assertTrue($table->filter('.option-subtotal-row .amount-col:contains("¥ 2,000")')->count() > 0);
        $this->assertTrue($table->filter('.total-amount-row .amount-col:contains("¥ 20,000")')->count() > 0);


        $form = $crawler->selectButton('予約を確定する')->form();
        $crawler = $client->submit($form);

        // reservation/finish
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('h1:contains("予約完了")')->count() > 0);
        $this->assertTrue($crawler->filter('div.alert:contains("予約が完了しました。登録しているメールアドレス宛てにメールを送信しましたのでご確認ください。")')->count() > 0);
    }

    public function testEmptyHistory()
    {
        $client = static::createClient();

        $this->login($client, 'user1@example.com');

        $crawler = $client->request('GET', '/reservation/history');

        $this->assertTrue($crawler->filter('.reservation-list-table')->count() === 0);
        $this->assertTrue($crawler->filter('.alert:contains("予約履歴はありません")')->count() > 0);
    }

    public function testHistory()
    {
        $client = static::createClient();

        $this->login($client, 'user2@example.com');

        $crawler = $client->request('GET', '/reservation/history');

        $this->assertEquals(1, $crawler->filter('.reservation-list-table tbody tr')->count());
        $row = $crawler->filter('.reservation-list-table tbody tr:first-child');
        $this->assertTrue($row->filter('td:nth-child(2):contains("神楽坂")')->count() > 0);
        $this->assertTrue($row->filter('td:nth-child(2):contains("2012/04/01 12:00")')->count() > 0);
        $this->assertTrue($row->filter('td:nth-child(3):contains("神楽坂")')->count() > 0);
        $this->assertTrue($row->filter('td:nth-child(3):contains("2012/04/02 17:30")')->count() > 0);
        $this->assertTrue($row->filter('td:nth-child(4):contains("Aクラス")')->count() > 0);
        $this->assertTrue($row->filter('td:nth-child(5):contains("¥ 20,000")')->count() > 0);
    }
}
