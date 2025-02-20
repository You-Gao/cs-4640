#!/usr/bin/env perl
# Use the CGI module
use CGI;

# Create a new CGI object
my $q = CGI->new;

# Access the firstname GET parameter
my $firstname = $q->param('firstname');
my $lastname = $q->param('lastname');

# Print out the HTTP header
# What happens if we leave this out?
print "Content-Type: text/html\n\n";


# Print out the initial HTML
print "<!DOCTYPE html>\n<html><head><title>Our CS4640 Perl Wordle Game</title></head>";
print "<body><h1>CS4640 Perl Wordle</h1>";

# Put additional code here
sub printGreeting {
  # Note: String interpolation! The variables are directly in the string
  my $msg = "<p>Hello $firstname $lastname!</p>";
  print $msg;
}

printGreeting;

# Get a random word from an array of words
my @wordlist = ("computer", "science", "wordle", "perl", "network", "game");
my $word = $q->param('word');
if (!$word) {
  $word = $wordlist[rand @wordlist];
}
# Read out the "guess" form input from GET
my $guess = $q->param('guess');

# Check if the guess is correct
my $success = $guess eq $word; # string equality with eq

# Function to check the guess
sub checkGuess {
  # Turn the strings into arrays of characters
  my @gchar = split(undef, $guess); 
  my @wchar = split(undef, $word); 

  # todo: print out the guess below (inside an <h2>) tag:
  print "<h2>Guess: $guess</h2>";
  
  # Print any characters that the user got in the right position
  print "<h3>Characters in the correct position</h3>\n<p>";
  my $any = 0;
  # Loop over each character in the guess array
  while (my ($i, $gc) = each @gchar) {
    # Check equality with the character in the word array
    if ($wchar[$i] eq $gc) {
      print "$gc correct at index $i<br>\n";
      $any += 1;
    } 
  }
  # If no letters correct, print
  if ($any == 0) {
    print("No characters in correct position\n");
  }

  print("</p>\n\n");
  print("<h3>Characters in any position of the word</h3>\n<p>");

  # Get unique array of characters in guess
  my @uchar = do { my %seen; grep { !$seen{$_}++ } @gchar};
  # foreach loop over the unique characters
  foreach (@uchar) {
    # Check if the character is in the $word
    # Note: the current loop variable is denoted by $_
    # In Perl, we can check if a substring matches with the =~ operator
    if ($word =~ m/$_/) {
      print("$_ is in the word<br>\n");
    }
  }
  
  print("</p>");

}

# todo: call the function above to check the guess
checkGuess; 

if ($success) {
  # If they got it correct, state it
  print "<h3>Congrats!</h3>";
} else {
  # If they don't have it correct, provide a text box to guess again
  # Note: 1) This is an interesting multi-line string!
  #       2) The form has no action! The browser will submit to the
  #          same URL/script!
  #       3) Hidden inputs are not displayed to the user
  print <<end_of_string
  <h3>Enter another guess</h3>
  <form method="POST">
  <input type="hidden" name="firstname" value="$firstname">
  <input type="hidden" name="lastname" value="$lastname">
  <input type="hidden" name="word" value="$word">
  <label>
    Guess:
    <input type="text" name="guess" placeholder="Enter another guess">
  </label>
  <input type="submit" name="submit" value="Submit">
  </form>
end_of_string
}

# Close out the body
print "</body></html>";

