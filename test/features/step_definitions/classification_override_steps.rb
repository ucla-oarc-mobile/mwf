Given /^I visit the Device Telemetry page with a query parameter of (.*)$/ do |param|
  visit "http://localhost/mwf/device.php?" + param
end

Then /^device telemetry value (.*) should be (.*)$/ do |method, value|
  should have_content(method + value) 
end


