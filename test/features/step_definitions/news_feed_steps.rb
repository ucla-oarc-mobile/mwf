Given /I visit a news page/ do
  visit 'http://localhost/assets/test/selenium/feed_test.php'
end

Then /I should see news items/ do
  should have_link("Don't forget about me!")
end