Given /I have no previous preferences/ do
  visit "http://localhost/assets/test/selenium/nuke_prefs.html"
end

And /^I note the name of menu item number (\d*), let's call it "([^"]*)"$/ do |n, name|
  if ! defined?(@note)
    @note = Hash.new;
  end
   @note[name] = find(:xpath, '//ol[@id="main_menu_list"]/li[' + n + ']/a').text;
end

And /^I should see that menu item number (\d*) is so\-called "([^"]*)"$/ do |n, item|
  assert find(:xpath, '//ol[@id="main_menu_list"]/li[' + n + ']/a').text == @note[item];
end

And /^I should not see the so\-called "([^"]*)" menu item$/ do |item|
  should have_no_selector(:xpath, '//ol[@id="main_menu_list"]/li[a="' + @note[item] + '"]');
end

Then /I click the "([^"]*)" link/ do |link_text|
  click_link(link_text)
end

Then /I click the "([^"]*)" button/ do |button_text|
  click_button(button_text)
end

And /the "([^"]*)" page loads/ do |header_text|
  find('h1').should have_content(header_text)
end

Then /I uncheck so\-called "([^"]*)"/ do |item|
  uncheck(@note[item])
end

And /^I go back$/ do
  evaluate_script('window.history.back()')
end

And /^I reload$/ do
  evaluate_script('window.location.reload()')
end