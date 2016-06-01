# Autocomplete

A useful package for efficient autocomplete functionality.

## Installation

Using composer:

`composer require phparmory/autocomplete`

### Example usage

```php
<?php
use Armory\Autocomplete\Autocomplete;
use Armory\Autocomplete\Repositories\ArrayRepository;

$autocomplete = new Autocomplete(new ArrayRepository);

$autocomplete->index(1, "King Kong", 'movies'); // Indexes 'King Kong' against ID 1 in the 'movies' namespace
$autocomplete->index(2, "King's Speech", 'movies'); // Indexes "King's speech" against ID 2 in the 'movies' namespace

$autocomplete->find('King', 'movies'); // Returns [1, 2];
$autocomplete->find("King's", 'movies'); // Returns [2];
```

### Repositories

Autocomplete comes with an array and a Redis repository. An example using Redis:

```php
<?php
use Armory\Autocomplete\Autocomplete;
use Armory\Autocomplete\Repositories\RedisRepository;
use Predis\Client;

$autocomplete = new Autocomplete(new RedisRepository(new Client));

$autocomplete->index(1, 'Spiderman', 'movies');

$autocomplete->find('spider', 'movies'); // Returns [1]
```
