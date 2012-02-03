Feature: Cross-Domain Cookie
  In order to enable a distributed architecture
  The user
  Should be able to access pages on a different domain than where the cookies are being set

Scenario: Basic Cross-Domain Cookie
  Given I have no framework cookies
  And I visit a page with a domain different from that of the framework
  Then framework cookies should be set
  And I should not be in an infinite redirect loop

Scenario: Non-Standard Port
  Given I visit a page hosted on a non-standard port
  Then the framework should extract the correct cookie domain
  