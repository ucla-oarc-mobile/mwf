Feature: JS Unit Tests
  In order to insure against defects
  The team
  Should be able to run all JS unit tests successfully

Scenario: JS Unit Tests
  Given I am on the JS Unit Tests page
  Then I should see that all tests have passed
  And I should see that no tests have failed

Scenario: mwf.userAgent does not leak variables into global space
  Given I am on the JS Unit Tests page filtered for mwf.userAgent
  Then I should see that all tests have passed
  And I should see that no tests have failed
  And I check the noglobals checkbox
  Then I should see that all tests have passed
  And I should see that no tests have failed