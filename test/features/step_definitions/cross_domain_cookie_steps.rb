Given /I have no framework cookies/ do
  # Cucumber + Capybara + iPhone Driver = no obvious way to nuke cookies that works.
  # So let's do a good old fashioned PHP-based cookie-nuking instead.
  visit "http://localhost/assets/test/selenium/nuke_cookies.php"
end

Given /I visit a page with a domain different from that of the framework/ do
  visit "http://localhost/assets/test/selenium/cross_domain_cookie.html"
end

Then /framework cookies should be set/ do
  should have_selector("#success")
end

Then /I should not be in an infinite redirect loop/ do
  should have_selector("#success")
end