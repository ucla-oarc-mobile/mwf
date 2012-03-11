Feature: Customize Home screen
  In order to be usable
  The users
  Should be able to customize their home screen

Scenario: Remove an item
  Given I have no previous preferences
  And I am on the home page
  Then I should see the home page
  And I note the name of menu item number 3, let's call it "third_item"
  Then I click the "Customize Home Screen" link
  And the "Customize Home Screen" page loads
  Then I uncheck so-called "third_item"
  Then I click the "Save" button
  And I go back
  And I reload
  Then I should see the home page
  And I should not see the so-called "third_item" menu item


Scenario: Reset to default
  Given I have no previous preferences
  And I am on the home page
  Then I should see the home page
  And I note the name of menu item number 1, let's call it "first_item"
  And I note the name of menu item number 2, let's call it "second_item"
  And I note the name of menu item number 3, let's call it "third_item"
  Then I click the "Customize Home Screen" link
  And the "Customize Home Screen" page loads
  Then I uncheck so-called "third_item"
  Then I click the "Save" button
  Then I click the "Reset To Default" button
  Then I go back
  And I reload
  Then I should see the home page
  And I should see that menu item number 1 is so-called "first_item"
  And I should see that menu item number 2 is so-called "second_item"
  And I should see that menu item number 3 is so-called "third_item"