<?php

namespace AdversusPHP;

/**
 * Class Campaign
 *
 * @package AdversusPHP
 */
class Campaign extends Model
{

    /**
     * @var string
     */
    protected static $path = 'campaigns';

    /**
     * @return static[]
     */
    public function getLeads()
    {
        $campaignFilter = new Filter(1, Filter::EQUAL_TO, "135");
        $activeFilter   = new Filter("active", Filter::EQUAL_TO, true);
        return Lead::all([$campaignFilter, $activeFilter]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getSettings()['navn'];
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->data['settings'][0];
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->settings['active'];
    }

}