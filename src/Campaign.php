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
     * @return Lead[]
     */
    public function getLeads()
    {
        $campaignFilter = new Filter("campaignId", Filter::EQUAL_TO, $this->id);
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