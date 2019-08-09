# Cookies

Edit the config/packages/runroom_cookies.yaml to add or remove cookies to the cookies settings.

The **type** defines a key on the messages.lang.yaml where you need to place the title and description (optional).

The cookies file defines the basic cookies used in all projects, this is a list of additional cookies you may need:

Each cookie is assigned to a domain to be able to delete it in case the user does not accept targeting or performance cookies.

targeting_cookies:
    - type: bing
      cookies:
        - { name: _uetsid }
        - { name: MUIDB }
        - { name: MUID
    - type: linkedin
      cookies:
        - { name: BizoID }
        - { name: lidc }
        - { name: UserMatchHistory }
        - { name: lang }
        - { name: bcookie }
        - { name: __utma }
        - { name: __utmv }
        - { name: __qca }
        - { name: visit }
    - type: youtube
      cookies:
        - { name: SID }
        - { name: HSID }
        - { name: demographics }
        - { name: VISITOR_INFO1_LIVE }
        - { name: APISID }
        - { name: SSID }
        - { name: LOGIN_INFO }
        - { name: YSC }
        - { name: SAPISID }
    - type: facebook
      cookies:
        - { name: sb }
        - { name: fr }
        - { name: spin }
        - { name: act }
        - { name: c_user }
        - { name: presence }
        - { name: datr }
        - { name: pl }
        - { name: xs }

Categories can also have an optional description, and each cookie could have a specific domain:

    - type: faceboook
      has_description: true
      cookies:
        - { name: sb }
        - { name: fr, domain: example.com }
        - { name: spin }
        - { name: act }
        - { name: c_user }
        - { name: presence }
        - { name: datr }
        - { name: pl }
        - { name: xs }
