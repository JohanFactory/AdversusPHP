# AdversusPHP
API wrapper for Adversus API

https://adversus.dk/api/

### Examples
```php
<?php

require_once 'vendor/autoload.php';

// initialize
$client = new \AdversusPHP\Client('username', 'password');
\AdversusPHP\Model::init($client);

// list all available models
$campaigns = \AdversusPHP\Campaign::all();
$leads = \AdversusPHP\Lead::all();

// list models with filter
$campaignFilter = new \AdversusPHP\Filter('campaignId', \AdversusPHP\Filter::EQUAL_TO, 1512);
$activeFilter = new \AdversusPHP\Filter('active', \AdversusPHP\Filter::EQUAL_TO, true);
$activeLeadsFromCampaign1512 = \AdversusPHP\Lead::all([$campaignFilter, $activeFilter]);

// get single model
$lead = \AdversusPHP\Lead::find(206592972);
// edit some values
$lead->data['active'] = true;
$lead->data['masterData'][1]['value'] = 'Edited value';
// save changes
$lead->update();
```