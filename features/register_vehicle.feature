@in-memory
Feature: Register a vehicle

  In order to follow many vehicles with my application
  As an application user
  I should be able to register my vehicle

  @critical @in-db
  Scenario: I can register a vehicle
    Given my fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"
    And a vehicle named "1111_FF_13"
    When I register this vehicle named "1111_FF_13" into my fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"
    Then this vehicle named "1111_FF_13" should be part of my vehicle fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"

  Scenario: I can't register same vehicle twice
    Given my fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"
    And a vehicle named "2222_FF_13"
    And I have registered this vehicle named "2222_FF_13" into my fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"
    When I try to register this vehicle named "2222_FF_13" into my fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"
    Then I should be informed this this vehicle named "2222_FF_13" has already been registered into my fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"

  Scenario: Same vehicle can belong to more than one fleet
    Given my fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"
    And the fleet of another user named "0197ca88-d09b-725b-859b-7aedb8cae389"
    And a vehicle named "3333_FF_13"
    And this vehicle named "3333_FF_13" has been registered into the other user's fleet named "0197ca88-d09b-725b-859b-7aedb8cae389"
    When I register this vehicle named "3333_FF_13" into my fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"
    Then this vehicle named "3333_FF_13" should be part of my vehicle fleet named "0197ca87-9afa-7207-afad-3af0f6acd589"