Feature: gg

  @gg
  Scenario: gg
    And Create user by API == API ==
    And Open Login page == path: /login ==
    And Check is this Login page == path: /login ==
    And Send keys in Username input create username api data == path: /login ==
    And Send keys in Password input create password api data== path: /login ==
    And Click on Login button == path: /login ==

    And Check is this Clients page == path: /clients ==

    And Click on [Add client] button == path: /clients ==
    And Click on [Add new client using email] text in client registration popup == path: /clients ==
    And Send keys "gg_xx_2@fff.com" in email input in client registration popup == path: /clients ==
    And Click on [Submit] button in client registration popup == path: /clients ==
    And Sleep "1"
    And I show success label user create == path: /clients ==
    And In success popup label contain email "gg_xx_2@fff.com" == path: /clients ==
    And In success popup label contain password == path: /clients ==
    And Save user "gg_xx_2@fff.com" password == path: /clients ==
    And Press [Close button] == path: /clients ==
    And Refresh page
    And Click on email "gg_xx_2@fff.com" in clients table == path: /clients ==

    And Check on Overview Client Page == path: /clients ==
    And Check that Login credentials contains Default email "gg_xx_2@fff.com" == path: users/{id}/overview ==
    And Check that Personal info contains Date of birth "01 / 01 / 1970" == path: users/{id}/overview ==

    And Click on [Profile] button on left panel == path: users/{id}/...==
    And Check on Users profile page == path: users/{id}/profile ==
    And Send keys "Mitch" in Name input == path: users/{id}/profile ==
    And Send keys "Lucker" in Last Name input == path: users/{id}/profile ==
    And Send keys "Test address 1" in Address input == path: users/{id}/profile ==
    And Send keys "Test city 1" in City input == path: users/{id}/profile ==
    And Click on Country select
    And Click on Country option "United States of America"
    And Click on B-day day select
    And Click on B-day day option "03"
    And Click on B-day month select
    And Click on B-day month option "03"
    And Click on B-day year select
    And Click on B-day year option "1987"

    And Click on [Save] button
    And Show save success label
    And Check that Name "Mitch Lucker" contains in left panel  == path: users/{id}/... ==

    And  Click on [Overview] button on left panel == path: users/{id}/...==
    And Check that Name "Mitch Lucker" contains in left panel  == path: users/{id}/... ==
#    And Check that Login credentials contains Default phone "+971507784892" == path: users/{id}/overview ==
    And Check that Personal info contains First name "Mitch" == path: users/{id}/overview ==
    And Check that Personal info contains Last name "Lucker" == path: users/{id}/overview ==
#     And Check that Personal info contains Country "US" == path: users/{id}/overview == TODO name country is text node, xpath not work
    And Check that Personal info contains City/Village "Test city 1" == path: users/{id}/overview ==
    And Check that Personal info contains Region/District "Test address 1" == path: users/{id}/overview ==
    And Check that Login credentials contains Default email "gg_xx_2@fff.com" == path: users/{id}/overview ==
    And Check that Personal info contains Date of birth "03 / 03 / 1987" == path: users/{id}/overview ==

    And Click on [Documents] button on left panel == path: users/{id}/... ==
    And Check in table "0" line == path: users/{id}/documents ==
    And Check on Documents page == path: users/{id}/documents ==
    And Click on [Add new POI] tab == path: users/{id}/documents/... ==
# ADD POI
    And Check on Add new POI page == path: users/{id}/documents/create-proof-of-identity ==
    And Click on Subtype select == path: users/{id}/documents/create-proof-of-identity ==
    And Click on Subtype option with value "Civil ID card" == path: users/{id}/documents/create-proof-of-identity ==
    And Send file in file input "img/img_1.jpg" == path: users/{id}/documents/create-proof-of-identity ==
    And Click on [Save] button == path: users/{id}/documents/create-proof-of-identity ==

    And Check on Documents page == path: users/{id}/documents ==
    And Check in table "1" line == path: users/{id}/documents ==
    And Check in table "1" line with Type "Proof of identity | Passport" == path: users/{id}/documents ==
# ADD POR
    And Click on [Add new POR] tab == path: users/{id}/documents/... ==
    And Check on Add new POR page == path: users/{id}/documents/create-proof-of-residence ==
    And Click on Subtype select == path: users/{id}/documents/create-proof-of-residence ==
    And Click on Subtype option with value "Credit card statement" == path: users/{id}/documents/create-proof-of-residence ==
    And Send file in file input "img/img_1.jpg" == path: users/{id}/documents/create-proof-of-residence ==
    And Click on [Save] button == path: users/{id}/documents/create-proof-of-residence ==

    And Check on Documents page == path: users/{id}/documents ==
    And Check in table "2" line == path: users/{id}/documents ==
    And Check in table "1" line with Type "Proof of residence | Credit card statement" == path: users/{id}/documents ==

# ADD POP
    And Click on [Add new POP] tab == path: users/{id}/documents/... ==
    And Check on Add new POP page == path: users/{id}/documents/create-proof-of-payment ==
    And Click on Subtype select == path: users/{id}/documents/create-proof-of-payment ==
    And Click on Subtype option with value "Source of Fund document" == path: users/{id}/documents/create-proof-of-payment ==
    And Send file in file input "img/img_1.jpg" == path: users/{id}/documents/create-proof-of-payment ==
    And Click on [Save] button == path: users/{id}/documents/create-proof-of-payment ==

    And Check on Documents page == path: users/{id}/documents ==
    And Check in table "3" line == path: users/{id}/documents ==
    And Check in table "1" line with Type "Proof of payment | Source of Fund document" == path: users/{id}/documents ==