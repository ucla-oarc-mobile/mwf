Given /^I am on the JS Unit Tests page$/ do 
  visit "http://localhost/assets/test/js_unit/"
  @results = find_by_id('qunit-testresult')
end

Given /^I am on the JS Unit Tests page filtered for (.*)$/ do |filter|
  visit "http://localhost/assets/test/js_unit/?filter=#{filter}"
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

And /^I check the (.*) checkbox$/ do |checkbox|
  check(checkbox)
end
