Given /I am on the home page/ do
  visit "http://localhost/"
end

Then /I should see the home page/ do
  should have_selector("body.front-page")
  should have_selector("div.menu-front")
end