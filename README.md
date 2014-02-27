metatron-client-php
===================

A PHP Client for metatron

Usage:

```php
$client = new \metatron\Client($metatronUrl);

// Get editions by ISBN
$editionSet = $client->getEditionsFromIsbn('9780674235380', array('filters.language'=>'1'));

echo $editionSet->getTotal();

-> 2

echo $editionSet->getRequestedEdition()->identifier;

-> "9780674235380"

$editions = $editionSet->getEditions();

// Currently, the attributes are just the Metatron object properties

echo $editions[1]->full_title;

-> "The Economic Structure of Corporate Law"

echo implode("; ", $editions[0]->getContributorNames());

-> "Frank H. Easterbrook; Daniel R. Fischel"

$worksSet = $client->getWorksFromTitleAuthor('Communication as culture: essays on media and society', 'Carey');

echo $worksSet->getTotal();

-> 1986

echo $workSet->getLimit();

-> 10

echo $workSet->getOffset();

-> 0

$works = $worksSet->getWorks();

echo $works[0]->identifier;

-> "communications_as_culture/carey"

$nextSet = $worksSet->next();

echo $nextSet->getTotal();

-> 1986

echo $nextSet->getLimit();

-> 10

echo $nextSet->getOffset();

-> 10

$works = $nextSet->getWorks();

echo $works[0]->identifier;

-> "communication_as_culture/carey" // <- Note! different than above

$editionSet = $works[0]->getEditions();

echo $editionSet->getTotal();

-> 3

$editions = $editionSet->getEditions();

echo $editions[0]->full_title;

-> "Communication as Culture"
```
etc.

