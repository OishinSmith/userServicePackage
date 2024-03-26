Developed a package in Laravel that includes:

● A method to retrieve a single user by ID

● A method to retrieve a paginated list of users

● A method to create a new user, providing a name and job, and returning a User ID.

● All users returned by the service must be converted into well defined DTO models

The package includes unit tests for the service. (using php unit)

There's also a CI/CD pipeline set up which runs the unit tests.

This package also works in PHP and Laravel

Goal:
Remote APIs are often unstable and unreliable; how will you handle this?
*Consider how you will communicate API errors to other developers utilising this
package.
* How can you make a generic exception thrown by an API or third party package
more specific to your domain?
* Will you let exceptions propagate or catch and handle them in some form?
** How can you make your code testable?
* How will you make your own code testable? Demonstrate this by providing unit
tests.
* How will you make your unit tests work when interacting with a remote API?
Would your tests still pass if the API was offline or the data on the API changed?
If not, how would you avoid this issue?

** Don't feel the need to reinvent the wheel; if there's a well established composer package
that could help, feel free to use it, but we still need to see intelligent choices in packages
selected and meaningful implementation. This should be limited to standalone
packages, not the use of entire frameworks.
** Make it framework agnostic. This package should work in Laravel, Drupal, Wordpress,
and any other PHP software just as easily with no reliance on being used in any particular
scenario.
** Code should be well typed and written to clean, modern PSR standards targeting PHP
8.2.

I didnt implement JSON serializable interfaces and supporting conversion to a standard array
structure.

