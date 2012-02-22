Given /I have no previous preferences/ do
  visit "http://localhost/assets/test/selenium/nuke_prefs.html"
end

And /^I should see the "([^"]*)" menu item$/ do |menu_item|
  should have_link(menu_item)
end

And /^I should not see the "([^"]*)" menu item$/ do |menu_item|
  should have_no_link(menu_item)
end

And /^I should see the menu items "([^"]*)", "([^"]*)", and "([^"]*)"$/ do |first, second, third|
  assert find(:xpath, '//ol[@id="main_menu_list"]/li[1]/a').text == first;
  assert find(:xpath, '//ol[@id="main_menu_list"]/li[2]/a').text == second;
  assert find(:xpath, '//ol[@id="main_menu_list"]/li[3]/a').text == third;
end

Then /I click the "([^"]*)" link/ do |link_text|
  click_link(link_text)
end

Then /I click the "([^"]*)" button/ do |button_text|
  click_button(button_text)
end

And /the "([^"]*)" page loads/ do |header_text|
  should have_content(header_text)
end

Then /I uncheck "([^"]*)"/ do |label|
  uncheck(label)
end

Then /^I click "([^"]*)" for "([^"]*)"$/ do |button_value, label_text|
  find('label', {:text => label_text, :visible => true}).find(:xpath, './/../input[@type="submit" and @value="'+button_value+'"]').click
end