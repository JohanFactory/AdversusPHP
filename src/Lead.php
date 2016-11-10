<?php

namespace AdversusPHP;

/**
 * Class Lead
 *
 * @package AdversusPHP
 */
/**
 * Class Lead
 *
 * @package AdversusPHP
 */
class Lead extends Model
{

    /**
     * @var string
     */
    protected static $path = 'leads';

    /**
     * @return int
     */
    public function getCampaignId()
    {
        return $this->data['campaignId'];
    }

    /**
     * @param int $campaignId
     */
    public function setCampaignId($campaignId)
    {
        $this->data['campaignId'] = $campaignId;
    }

    /**
     * @return int
     */
    public function getContactAttempts()
    {
        return $this->data['contactAttempts'];
    }

    /**
     * @param int $contactAttempts
     */
    public function setContactAttempts($contactAttempts)
    {
        $this->data['contactAttempts'] = $contactAttempts;
    }

    /**
     * @return \DateTime
     */
    public function getLastModifiedTime()
    {
        return new \DateTime($this->data['lastModifiedTime']);
    }

    /**
     * @param string|\DateTime $lastModifiedTime
     */
    public function setLastModifiedTime($lastModifiedTime)
    {
        if ($lastModifiedTime instanceof \DateTime){
            $lastModifiedTime = $lastModifiedTime->format('Y-m-d\TH:i:s\Z');
        }
        $this->data['lastModifiedTime'] = $lastModifiedTime;
    }

    /**
     * @return \DateTime
     */
    public function getNextContactTime()
    {
        return new \DateTime($this->data['nextContactTime']);
    }

    /**
     * @param string|\DateTime $nextContactTime
     */
    public function setNextContactTime($nextContactTime)
    {
        if ($nextContactTime instanceof \DateTime){
            $nextContactTime = $nextContactTime->format('Y-m-d\TH:i:s\Z');
        }
        $this->data['nextContactTime'] = $nextContactTime;
    }

    /**
     * @return int
     */
    public function getLastContactedBy()
    {
        return $this->data['lastContactedBy'];
    }

    /**
     * @param int $lastContactedBy
     */
    public function setLastContactedBy($lastContactedBy)
    {
        $this->data['lastContactedBy'] = $lastContactedBy;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->data['status'] = $status;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->data['active'];
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->data['active'] = $active;
    }

    /**
     * Create new lead from data array.
     * @param array|Lead $data
     */
    public static function create($data)
    {
        if ($data instanceof Lead){
            $data = $data->data;
        }
        $response = static::$client->post('/leads', ['body' => \GuzzleHttp\json_encode($data)]);
        return \GuzzleHttp\json_decode($response->getBody()->getContents())->id;
    }

    /**
     * @return Campaign
     */
    public function getCampaign()
    {
        return Campaign::find($this->data['campaignId']);
    }

    /**
     * @param int|Campaign $campaign
     */
    public function setCampaign($campaign)
    {
        if ($campaign instanceof Campaign){
            $campaign = $campaign->id;
        }
        $this->data['campaignId'] = $campaign;
    }

    /**
     * Get value of custom master data field by id
     * @param $id
     *
     * @return mixed
     */
    public function getMasterDataValue($id)
    {
        if (isset($this->data['masterData'])){
            $items = array_filter($this->data['masterData'], function ($v) use ($id){
                return $v['id'] === $id;
            });
            return $items[0]['value'];
        }
    }

    /**
     * Manipulate custom master data value by id
     * @param $id
     * @param $value
     *
     */
    public function setMasterDataValue($id, $value)
    {
        if (!array_key_exists('masterData', $this->data)){
            $this->data['masterData'] = [];
        }
        $exists = false;
        foreach ($this->data['masterData'] as $index => $item) {
            if ($item['id'] === $id){
                $this->data['masterData'][$index]['value'] = $value;
                $exists = true;
                break;
            }
        }
        if (!$exists){
            $this->data['masterData'][] = [
                'id' => $id,
                'value' => $value
            ];
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getResultDataValue($id)
    {
        if (isset($this->data['resultData'])){
            $items = array_filter($this->data['resultData'], function ($v) use ($id){
                return $v['id'] === $id;
            });
            return $items[0]['value'];
        }
    }

    /**
     * @param $id
     * @param $value
     *
     * @return bool
     */
    public function setResultDataValue($id, $value)
    {
        if (!array_key_exists('resultData', $this->data)){
            $this->data['resultData'] = [];
        }
        $success = false;
        foreach ($this->data['resultData'] as $index => $item) {
            if ($item['id'] === $id){
                $this->data['resultData'][$index]['value'] = $value;
                $success = true;
                break;
            }
        }
        return $success;
    }

    /**
     * @param array|null $data
     *
     * @return bool|int
     */
    public function save(array $data = null)
    {
        if ($this->id === null){
            $lead_id = self::create($this);
            $this->id = (int) $lead_id;
            return $lead_id;
        }
        $data     = $data ?: $this->data;
        $url      = '/' . static::$path . '/' . $this->id;
        $response = self::$client->put($url, [
            'body' => \GuzzleHttp\json_encode($data)
        ]);
        return $response->getStatusCode() == 200;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $response = self::$client->delete('/' . static::$path . '/' . $this->id);
        return $response->getStatusCode() == 200;
    }
}