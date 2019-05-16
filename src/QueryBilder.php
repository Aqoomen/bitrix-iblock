<?php
namespace iPremium\Bitrix\iBlock;

use iPremium\Bitrix\iBlock\ElementItem as Item;

trait QueryBilder
{
    protected $lovercase = false;

    protected $properties;

    protected $select;

    protected $filter;

    protected $iblockId;

    protected $order = [
        "SORT"=>"ASC"
    ];

    protected $returnArray = false;

    public function __construct($id, $return)
    {
        $this->iblockId = $id;
        $this->returnArray = $return;
        //to do use global settings in iBLock::instanse()->elementLoverCase();
    }

    public function lovercase($param)
    {
        $this->lovercase = $param;
    }

    public function select(...$params)
    {
        if ($this->lovercase)
        {
            foreach ($params as &$param) {
                $param = strtoupper($param);
            }

            $this->select = $params;
        }
        else
        {
            $this->select = $params;
        }

        return $this;
    }

    public static function iblock($id, $return = false)
    {
        return new static($id, $return);
    }

    public function filter($params)
    {
        if (!in_array($params, ['iblock_id', 'IBLOCK_ID']))
        {
            if ($this->iblockId != null)
            {
                $params = array_merge($params, ['IBLOCK_ID' => $this->iblockId]);
            }
        }

        if ($this->lovercase)
        {
            foreach ($params as &$param) {
                $param = strtoupper($param);
            }

            $this->filter = $params;
        }
        else
        {
            $this->filter = $params;
        }

        return $this;
    }

    public function order($params)
    {
        $this->order = $params;
    }

    

}
