Given /I am on the JS Unit Tests page/ do 
  Capybara.default_wait_time = 10
  visit "http://localhost/assets/test/js_unit/"
  @results = find_by_id('qunit-testresult')
end

Then /I should see that all tests have passed/ do
  total = @results.find('.total').text
  passed = @results.find('.passed').text
  assert total==passed
end

Then /I should see that no tests have failed/ do
  failed = @results.find('.failed').text
  assert failed=="0"
end
