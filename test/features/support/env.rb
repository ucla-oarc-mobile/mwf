require 'rspec/expectations'
require 'capybara'
require 'test/unit/assertions'
require 'selenium/webdriver'

World(Test::Unit::Assertions)

World do
  Capybara.register_driver :iphone do |app|
    Capybara::Selenium::Driver.new(app, :browser => :iphone)
  end

  session = Capybara::Session.new(:iphone)
  session
end