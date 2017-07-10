Intl data
=========

The library provides easy access to Intl extension data for information about regions, sub-regions, countries, languages, locales, currencies and timezones. Also it has two additional classes for information about continents and measurement systems.

The library consist of static classes:
- Continent
- Region
- Subregion
- Country
- Language
- Locale
- Currency
- Timezone
- MeasurementSystem

Each of them has follow static methods:
```php
// Get list of codes.
ClassName::codes();

// Get a boolean indicating whether data has a code.
ClassName::has($code);

// Get list of names.
ClassName::names();

// Get name by code.
ClassName::name($code);

// E.g.
Country::names();
Currency::name('USD');
Locale::codes();
Timezone::has('America/New_York');
```

And some of the classes have additional static methods to get more information.


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tigrov/intldata "*"
```

or add

```
"tigrov/intldata": "*"
```

to the require section of your `composer.json` file.

 
	
Addition
--------

- For additional information about countries (flags, codes, borders and other) use a library  
https://github.com/rinvex/country
- For divisions (country regions and states) and cities use a library  
https://github.com/MenaraSolutions/geographer
- For more information about Intl extension data use  
http://intl.rmcreative.ru/tables?locale=en_US  
http://php.net/manual/book.intl.php

License
-------

[MIT](LICENSE)
