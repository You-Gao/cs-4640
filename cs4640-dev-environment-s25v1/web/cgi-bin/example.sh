#!/bin/bash

# Write out the HTTP Header for plain text output
# What happens if we leave this out?
echo -e "Content-Type: text/plain\n\n";

# write out a string
echo "Environment Example in Bash!"

# Print the environment variables (from Apache)
env
