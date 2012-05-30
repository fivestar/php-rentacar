<?php

namespace Acme\RentacarBundle\Tests\Controller;

use Acme\RentacarBundle\Tests\WebTestCase;

class UserControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->loadFixtures();
    }

    public function testRegister()
    {
        $client = static::createClient();

        // user/register
        $crawler = $client->request('GET', '/user/register');

        $form = $crawler->selectButton('会員登録')->form();
        $form['user_registration[agreement]']->tick();
        $crawler = $client->submit($form, array(
            'user_registration[name]'            => 'New user',
            'user_registration[email][first]'    => 'new_user@example.com',
            'user_registration[email][second]'   => 'new_user@example.com',
            'user_registration[rawPassword]'     => 'new_password',
            'user_registration[tel]'             => '090-0000-0000',
            'user_registration[birthday][year]'  => '1985',
            'user_registration[birthday][month]' => '1',
            'user_registration[birthday][day]'   => '1',
        ));

        $activationUrl = null;
        if ($profile = $client->getProfile()) {
            $messages = $profile->getCollector('swiftmailer')->getMessages();
            $mailBody = $messages[0]->getBody();

            $this->assertRegexp('/仮登録が完了しました/', $mailBody);
            if (preg_match('#http://localhost(/user/activate\?key=[a-z0-9]+)#', $mailBody, $matches)) {
                $activationUrl = $matches[1];
            } else {
                $this->fail();
            }
        }

        // user/confirm
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('h1:contains("仮登録完了")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("確認用のメールを送信しましたので、メールに含まれる本登録用のリンクへアクセスして登録を完了してください。")')->count() > 0);

        if (null === $activationUrl) {
            $this->markTestSkipped('Profiler is not available');
        }

        // user/activate
        $crawler = $client->request('GET', $activationUrl);

        // login
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('.alert:contains("ユーザ登録が完了しました。ログイン後、予約が行えるようになります")')->count() > 0);

        $this->login($client, 'new_user@example.com', 'new_password');

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('a:contains("New userさん")')->count() > 0);
    }

    public function testRegisterExistingUser()
    {
        $client = static::createClient();

        // user/register
        $crawler = $client->request('GET', '/user/register');

        $form = $crawler->selectButton('会員登録')->form();
        $form['user_registration[agreement]']->tick();
        $crawler = $client->submit($form, array(
            'user_registration[name]'            => 'New user',
            'user_registration[email][first]'    => 'user1@example.com',
            'user_registration[email][second]'   => 'user1@example.com',
            'user_registration[rawPassword]'     => 'new_password',
            'user_registration[tel]'             => '090-0000-0000',
            'user_registration[birthday][year]'  => '1985',
            'user_registration[birthday][month]' => '1',
            'user_registration[birthday][day]'   => '1',
        ));

        $activationUrl = null;
        if ($profile = $client->getProfile()) {
            $messages = $profile->getCollector('swiftmailer')->getMessages();
            $mailBody = $messages[0]->getBody();

            $this->assertRegexp('/既に登録されています/', $mailBody);
        } else {
            $this->markTestSkipped('Profiler is not available');
        }
    }
}
