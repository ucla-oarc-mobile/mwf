Feature: Proxy Cookie Scrub
  In order to provide a robust service
  The user
  Should be able to visit the site with a device that using a proxy that disallows cookies

Scenario: Cookies Allowed By Browser But Stripped By Proxy (as happens with old Blackberry Bold 9000 devices)
  Given I have no framework cookies
  And I visit a page using a proxy that strips cookies
  Then I should not be in an infinite redirect loop
