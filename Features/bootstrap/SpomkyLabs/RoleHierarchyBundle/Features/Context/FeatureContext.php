<?php

namespace SpomkyLabs\RoleHierarchyBundle\Features\Context;

use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Behat context class.
 */
class FeatureContext extends MinkContext implements SnippetAcceptingContext
{
    use KernelDictionary;

    private $result = null;

    /**
     * @Given I am logged in as :username
     */
    public function iAmAnLoggedInAs($username)
    {
        $client = $this->getSession()->getDriver()->getClient();
        $client->getCookieJar()->set(new Cookie(session_name(), true));

        $session = $client->getContainer()->get('session');

        $user = $this->kernel->getContainer()->get('test_bundle.user_manager')->getUser($username);

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    /**
     * @Given I am on the page :uri
     */
    public function iAmOnThePage($uri)
    {
        $client = $this->getSession()->getDriver()->getClient();
        $client->request("GET",$uri);
    }

    /**
     * @When I want to verify if I am granted :grant
     */
    public function iWantToVerifyIfIsGranted($grant)
    {
        $this->result = $this->getContainer()->get("security.context")->isGranted($grant);
    }

    /**
     * @Then I should get true
     */
    public function iShouldGetTrue()
    {
        if (true !== $this->result) {
            throw new \Exception("I did not get true.");
        }
    }

    /**
     * @Then I should get false
     */
    public function iShouldGetFalse()
    {
        if (false !== $this->result) {
            throw new \Exception("I did not get false.");
        }
    }
}