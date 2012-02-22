Feature: Customize Home screen
  In order to be usable
  The users
  Should be able to customize their home screen

Scenario: Remove an item
  Given I have no previous preferences
  And I am on the home page
  Then I should see the home page
  And I should see the "Collaboration" menu item
  Then I click the "Customize Home Screen" link
  And the "Home Screen Customization" page loads
  Then I uncheck "Collaboration"
  And I click the "Go Back To Home" link
  Then I should see the home page
  And I should not see the "Collaboration" menu item

Scenario: Move items
  Given I have no previous preferences
  And I am on the home page
  Then I should see the home page
  And I should see the menu items "About", "Device Telemetry", and "Collaboration"
  Then I click the "Customize Home Screen" link
  And the "Home Screen Customization" page loads
  Then I click "Down" for "About"
  And I click "Up" for "Collaboration"
  And I click the "Go Back To Home" link
  Then I should see the home page
  And I should see the menu items "Device Telemetry", "Collaboration", and "About"