<?php

namespace AdversusPHP;

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
     * @param $data
     */
    public static function create($data)
    {
        $response = static::$client->post('/leads', ['body' => \GuzzleHttp\json_encode($data)]);
        echo $response->getBody()->getContents();
    }

    /**
     * @return static
     */
    public function getCampaign()
    {
        return Campaign::find($this->data['campaignId']);
    }

    /**
     * @param array|null $data
     *
     * @return bool
     */
    public function update(array $data = null)
    {
        $data     = $data ?: $this->data;
        $url      = '/' . static::$path . '/' . $this->id;
        $response = self::$client->put($url, [
            'body' => \GuzzleHttp\json_encode($data)
        ]);
        return $response->getStatusCode() == 200;
    }
}