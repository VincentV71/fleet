@in-memory
Feature: Register a vehicle

  In order to follow many vehicles with my application
  As an application user
  I should be able to register my vehicle

  @critical
  Scenario: I can register a vehicle
    Given my fleet named "app_user_fleet"
    And a vehicle named "1111_FF_13"
    When I register this vehicle named "1111_FF_13" into my fleet named "app_user_fleet"
    Then this vehicle named "1111_FF_13" should be part of my vehicle fleet named "app_user_fleet"

  Scenario: I can't register same vehicle twice
    Given my fleet named "app_user_fleet"
    And a vehicle named "2222_FF_13"
    And I have registered this vehicle named "2222_FF_13" into my fleet named "app_user_fleet"
    When I try to register this vehicle named "2222_FF_13" into my fleet named "app_user_fleet"
    Then I should be informed this this vehicle named "2222_FF_13" has already been registered into my fleet named "app_user_fleet"

  Scenario: Same vehicle can belong to more than one fleet
    Given my fleet named "app_user_fleet"
    And the fleet of another user named "another_user_fleet"
    And a vehicle named "3333_FF_13"
    And this vehicle named "3333_FF_13" has been registered into the other user's fleet named "another_user_fleet"
    When I register this vehicle named "3333_FF_13" into my fleet named "app_user_fleet"
    Then this vehicle named "3333_FF_13" should be part of my vehicle fleet named "app_user_fleet"