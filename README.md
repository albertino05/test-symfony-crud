# Test symfony



# 1 - Match datetime from string
    - view service App\\Service\\DateTimeMatcher
    - view tests App\\Tests\\MatchDateFromStringTest

# 2 - Endpoint update person entity

    - view App\\Controller\\PersonController
    - view App\\Tests\\PersonTest

```
curl --location --request PUT 'localhost:3000/api/persona/3' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "allenson",
    "birthday": "2017/03/08"
}'
```

