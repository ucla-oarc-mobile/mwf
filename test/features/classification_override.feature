Feature: Classification Override
  In order to test
  The content provider
  Should be able to visit a page with a classification specified in the URL

Scenario: Classification Override
  Given I visit the Device Telemetry page with a query parameter of override=basic
  Then device telemetry value Classification::is_standard() should be false