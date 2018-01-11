Feature: CRM mass test

  @gg @crm
  Scenario: CRM mass test
    And Create user by API == API ==
    And Open Login page == CRM path: /login ==
    And Check is this Login page == CRM path: /login ==
    And Send keys in Username input create username api data == CRM path: /login ==
    And Send keys in Password input create password api data== CRM path: /login ==
    And Click on Login button == CRM path: /login ==

    And Check is this Clients page == CRM path: /clients ==

    And Click on [Add client] button == CRM path: /clients ==
    And Click on [Add new client using email] text in client registration popup == CRM path: /clients ==
    And Generate/Update prefix for "client_email"
    And Send keys "ta@mail.com" in email input in client registration popup == CRM path: /clients ==
    And Click on [Submit] button in client registration popup == CRM path: /clients ==
    And Sleep "1"
    And I show success label user create == CRM path: /clients ==
    And In success popup label contain email "ta@mail.com" == CRM path: /clients ==
    And In success popup label contain password == CRM path: /clients ==
    And Save user "ta@mail.com" password == CRM path: /clients ==
    And Press [Close button] == CRM path: /clients ==
    And Refresh page
    And Click on email "ta@mail.com" in clients table == CRM path: /clients ==

    And Check on Overview Client Page == CRM path: /clients ==
    And Check that Login credentials contains Default email "ta@mail.com" == CRM path: users/{id}/overview ==
    And Check that Personal info contains Date of birth "01 / 01 / 1970" == CRM path: users/{id}/overview ==
# UPDATE PROFILE
    And Click on [Profile] button on left panel == CRM path: users/{id}/...==
    And Check on Users profile page == CRM path: users/{id}/profile ==
    And Send keys "Mitch" in Name input == CRM path: users/{id}/profile ==
    And Send keys "Lucker" in Last Name input == CRM path: users/{id}/profile ==
    And Send keys "Test address 1" in Address input == CRM path: users/{id}/profile ==
    And Send keys "Test city 1" in City input == CRM path: users/{id}/profile ==
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
    And Check that Name "Mitch Lucker" contains in left panel  == CRM path: users/{id}/... ==

    And  Click on [Overview] button on left panel == CRM path: users/{id}/...==
    And Check that Name "Mitch Lucker" contains in left panel  == CRM path: users/{id}/... ==
#    And Check that Login credentials contains Default phone "+971507784892" == CRM path: users/{id}/overview ==
    And Check that Personal info contains First name "Mitch" == CRM path: users/{id}/overview ==
    And Check that Personal info contains Last name "Lucker" == CRM path: users/{id}/overview ==
#     And Check that Personal info contains Country "US" == CRM path: users/{id}/overview == TODO name country is text node, xpath not work
    And Check that Personal info contains City/Village "Test city 1" == CRM path: users/{id}/overview ==
    And Check that Personal info contains Region/District "Test address 1" == CRM path: users/{id}/overview ==
    And Check that Login credentials contains Default email "ta@mail.com" == CRM path: users/{id}/overview ==
    And Check that Personal info contains Date of birth "03 / 03 / 1987" == CRM path: users/{id}/overview ==

    And Click on [Documents] button on left panel == CRM path: users/{id}/... ==
    And Check on Documents page == CRM path: users/{id}/documents ==
    And Click on [Add new POI] tab == CRM path: users/{id}/documents/... ==
# ADD POI
    And Check on Add new POI page == CRM path: users/{id}/documents/create-proof-of-identity ==
    And Send file in file input "img/img_1.jpg" == CRM path: users/{id}/documents/create-proof-of-identity ==
    And Click on Subtype select == CRM path: users/{id}/documents/create-proof-of-identity ==
    And Click on Subtype option with value "Civil ID card" == CRM path: users/{id}/documents/create-proof-of-identity ==
    And Click on [Save] button == CRM path: users/{id}/documents/create-proof-of-identity ==

    And Check on Documents page == CRM path: users/{id}/documents ==
    And Check in table "1" line == CRM path: users/{id}/documents ==
    And Check in table "1" line with Type "Proof of identity | Civil ID card" == CRM path: users/{id}/documents ==
# ADD POR
    And Click on [Add new POR] tab == CRM path: users/{id}/documents/... ==
    And Check on Add new POR page == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Send file in file input "img/img_1.jpg" == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Click on Subtype select == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Click on Subtype option with value "Credit card statement" == CRM path: users/{id}/documents/create-proof-of-residence ==
    And Click on [Save] button == CRM path: users/{id}/documents/create-proof-of-residence ==

    And Check on Documents page == CRM path: users/{id}/documents ==
    And Check in table "2" line == CRM path: users/{id}/documents ==
    And Check in table "1" line with Type "Proof of residence | Credit card statement" == CRM path: users/{id}/documents ==

# ADD POP
    And Click on [Add new POP] tab == CRM path: users/{id}/documents/... ==
    And Check on Add new POP page == CRM path: users/{id}/documents/create-proof-of-payment ==
    And Send file in file input "img/img_1.jpg" == CRM path: users/{id}/documents/create-proof-of-payment ==
    And Click on Subtype select == CRM path: users/{id}/documents/create-proof-of-payment ==
    And Click on Subtype option with value "Source of Fund document" == CRM path: users/{id}/documents/create-proof-of-payment ==
    And Click on [Save] button == CRM path: users/{id}/documents/create-proof-of-payment ==

    And Check on Documents page == CRM path: users/{id}/documents ==
    And Check in table "3" line == CRM path: users/{id}/documents ==
    And Check in table "1" line with Type "Proof of payment | Source of Fund document" == CRM path: users/{id}/documents ==
