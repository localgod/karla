Feature: Identify
  In order retrive info about a image
  As a developer
  I want to

  Scenario: Get basic information about a image
    Given I can access Karla
    When I perform the identify action
    Then I should get a string with info about the image
