#!/bin/bash

# php-cs-fixer
php-cs-fixer fix src --verbose

# run tests
output=`composer run test`
returnCode=$?
outputlog="/tmp/phpunit_output_`date +%s`.log"

echo "$output" > $outputlog

# if unit tests fail, output a summary and exit with failure code.
if [ $returnCode -ne 0 ]; then

    # find the line with the summary.
    while read -r line; do
      if [[ $line =~ Failures: ]] ; then
        summary=$line
        break
      fi
    done <<< "$output"

    # output the status.
    echo -e "  + Test suite \033[1m\E[47;41mfailed\033[0m: "
    echo
    echo -e "$summary\033[0m"
    echo

    echo "  + The full output of phpunit has been saved in:"
    echo -e "      \033[1m${outputlog}\033[0m"
    echo

    # abort the commit.
    echo -e "  + \033[1m\E[47;41mABORTING COMMIT\033[0m"
    echo
    exit $returnCode
else
  echo -e "  + All tests \033[1m\E[47;42mpassed\033[0m. The full output of phpunit has been saved in:"
  echo -e "      \033[1m${outputlog}\033[0m"
  echo "  + Proceeding with commit. Have a nice day."
  echo
fi

exit 0
