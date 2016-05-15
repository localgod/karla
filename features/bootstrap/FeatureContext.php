<?php
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Karla\Karla;
use Karla\MetaData;

if ("" == shell_exec("which convert | grep '/opt/local/bin/'")) {
    define('PATH_TO_IMAGEMAGICK', '/usr/bin/');
} else {
    define('PATH_TO_IMAGEMAGICK', '/opt/local/bin/');
}

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{

    /**
     * Output from Imagemagick
     * 
     * @var Metadata|string
     */
    private $output;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {}

    /**
     * @Given /^I can access Karla$/
     */
    public function iCanAccessKarla()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->identify();
    }

    /**
     * @When /^I perform the identify action$/
     */
    public function iPerformTheIdentifyAction()
    {
        $this->output = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute();
    }

    /**
     * @Then /^I should get a string with info about the image$/
     */
    public function iShouldSeeInfoAboutTheImage()
    {
        if (! preg_match('/.*JPEG.*/', $this->output)) {
            throw new Exception("Actual output is:\n" . $this->output);
        }
    }
}
