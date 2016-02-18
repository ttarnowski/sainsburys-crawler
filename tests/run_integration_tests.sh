#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

${DIR}/../vendor/bin/phpunit --bootstrap ${DIR}/../vendor/autoload.php ${DIR}/integration