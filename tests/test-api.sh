# #!/bin/bash

# echo "Testing started..."

# BASE_URL="https://localhost:8000"
# exitStatus=0

# emptyRecipe=[]

# echo "Test 1: Sending empty recipe..."

# response=$(curl -s -X POST "${BASE_URL}/recipes" \
#                     --header 'Content-Type: application/json' \
#                     -w "%{http_code}" \
#                     --data-raw "${emptyRecipe}")

# responseStatus=$(grep -o "400 Bad Request" <<< ${response})

# if [[ -n responseStatus ]]; then
#   echo "Error while sending request with empty recipe!"
#   exitStatus=1
# else
#   echo "Test 1 passed!"
# fi

# validRecipe='{"title" : "test ","image" : "https://images.immediate.co.uk/production/volatile/sites/30/2022/09/OnePotGarlicChicken-d0de695.jpg","description" : "test","user" : 1,"ingredients" : [{"ingredient" : 1,"amount" : "500"},"ingredient" : 2,"amount" : "10"}]}'

# echo "Test 2: Sending valid recipe..."

# response=$(curl -s -X POST "${BASE_URL}/recipes" \
#                     --header 'Content-Type: application/json' \
#                     -w "%{http_code}" \
#                     --data-raw "${validRecipe}")

# responseStatus=$(grep -o "201 Created" <<< ${response})

# if [[ -n responseStatus ]]; then
#   echo "Error while sending request with valid recipe!"
#   exitStatus=1
# else
#   echo "Test 2 passed!"
# fi


# echo "Test 3: Sending get request without ID"

# invalidId = -1

# response=$(curl -s -X GET "${BASE_URL}/recipes/${invalidId}" \
#                     --header 'Content-Type: application/json' \
#                     -w "%{http_code}" \
#                     --data-raw "${invalidId}")

# responseStatus=$(grep -o "400 Bad Request" <<< ${response})

# if [[ -n responseStatus ]]; then
#   echo "Error while sending get request with no ID!"
#   exitStatus=1
# else
#   echo "Test 3 passed!"
# fi

# echo "Test 4: Sending get request with ID"

# validId = 1
# response=$(curl -s -X GET "${BASE_URL}/recipes/${validId}" \
#                     --header 'Content-Type: application/json' \
#                     -w "%{http_code}" \)
                    
# responseStatus=$(grep -o "200 OK" <<< ${response})

# if [[ -n responseStatus ]]; then
#   echo "Error while sending request with id!"
#   exitStatus=1
# else
#   echo "Test 4 passed!"
# fi


# exit $exitStatus

#Work in progress...