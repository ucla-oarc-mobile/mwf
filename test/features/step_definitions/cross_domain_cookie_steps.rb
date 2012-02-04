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

Given /I visit a page hosted on a non-standard port/ do
  visit "http://localhost/assets/test/selenium/cross_domain_cookie_non_standard_port.php"
end

Then /the framework should extract the correct cookie domain/ do
  should have_selector("#success")
end

Given /I visit a page wherein the framework is hosted on a non-standard port/ do
  visit "http://localhost/assets/test/selenium/cross_domain_cookie_non_standard_port_redirect.php"
end

Then /the redirect will include the non-standard port/ do
  should have_selector("#success")
end

Given /I visit a page that loads the framework JavaScript from a non-standard port/ do
  visit "http://localhost/assets/test/selenium/cross_domain_cookie_non_standard_port_unset_override.php"
end

Then /the tag that loads js_unset_override.php will specify the non-standard port/ do
  should have_xpath("//script[@src = 'http://localhost/assets/redirect/js_unset_override.php']")
end