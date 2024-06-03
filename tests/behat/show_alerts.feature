@block @block_alerts
Feature: Show alerts
  In order to alert users
  As a user
  I need to be able to see that the alerts block shows the intended alert.

  Background:
    Given the following "blocks" exist:
      | blockname   | contextlevel | reference  | pagetypepattern | defaultregion |
      | alerts      | System       | 1          | site-index      | side-pre      |
    And the following config values are set as admin:
      | config                  | value                           | plugin        |
      | title                   | Alert Title One                 | block_alerts  |
      | description             | Alert Description One           | block_alerts  |
      | link                    | https://nasa.gov                | block_alerts  |
      | linktext                | Alert Link One                  | block_alerts  |

  Scenario: See news as intended and check the links lead to the intended websites.
    When I am on site homepage
    Then I should see "Alert Title One"
    And I should see "Alert Description One"
    When I click on "Alert Link One" "link"
    Then I should see "NASA"
