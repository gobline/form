# Form component

The Form component is still in alpha stage. It has been designed to allow to:

* add form elements to the form and print them (with label, attributes, validation errors, etc.)
* bind entities to the form and pre-populate it
* validate those entities with user-defined filters

## TODO's

* add different types of form elements
* handle the case where an entity contains an array of entities
* phpunit tests
* code documentation

## Installation

You can install the Form component using the dependency management tool [Composer](https://getcomposer.org/).
Run the *require* command to resolve and download the dependencies:

```
composer require gobline/form
```