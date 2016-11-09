<?php

namespace AdversusPHP;

/**
 * Class Filter
 *
 * @package AdversusPHP
 */
class Filter
{

    const EQUAL_TO = '$eq';
    const NOT_EQUAL_TO = '$neq';
    const GREATER_THAN = '$gt';
    const LESS_THAN = '$lt';
    const CONTAINS = '$c';
    const DOES_NOT_CONTAIN = '$nc';

    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $filterType;
    /**
     * @var mixed
     */
    public $value;

    /**
     * Filter constructor.
     *
     * @param string $name
     * @param string $filterType
     * @param mixed $value
     */
    public function __construct($name, $filterType, $value)
    {
        $this->name = $name;
        $this->filterType = $filterType;
        if ($value instanceof \DateTime){
            $value = $value->format('Y-m-d\TH:i:s\Z');
        }
        $this->value = $value;
    }

    /**
     * @param $filters
     *
     * @return string
     */
    public static function toParam($filters)
    {
        if (!is_array($filters)) {
            $filters = [$filters];
        }
        $param = [];
        foreach ($filters as $filter) {
            $param[$filter->name] = [
                $filter->filterType => $filter->value
            ];
        }
        return json_encode($param);
    }

}