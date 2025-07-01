@in-memory
Feature: Park a vehicle

  In order to not forget where I've parked my vehicle
  As an application user
  I should be able to indicate my vehicle location

  Background:
    Given my fleet named "app_user_fleet"
    And a vehicle named "4444_FF_13"
    When I have registered this vehicle named "4444_FF_13" into my fleet named "app_user_fleet"

  @critical @in-db
  Scenario: Successfully park a vehicle
    And a location "11.22222" "-42.33333" "462"
    When I park my vehicle named "4444_FF_13" at this location "11.22222" "-42.33333" "462"
    Then the known location of my vehicle named "4444_FF_13" should verify this location "11.22222" "-42.33333" "462"

  Scenario: Can't localize my vehicle to the same location two times in a row
    And a location "77.555" "-66.66" "16"
    And my vehicle named "4444_FF_13" has been parked into this location "77.555" "-66.66" "16"
    When I try to park my vehicle named "4444_FF_13" at this location "77.555" "-66.66" "16"
    Then I should be informed that my vehicle named "4444_FF_13" is already parked at this location "77.555" "-66.66" "16"