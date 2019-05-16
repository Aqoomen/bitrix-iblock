<?php
namespace iPremium\Bitrix\iBlock;

class Section
{
    /*
    use this param true if you want write in lovercase params
    and script auto transform it to BITRIX_CAPS_STYLE
     */
    protected $lovercase = false;

    protected $properties;

    protected $select;

    protected $filter;

    protected $iblockId;

    protected $order = [
        "SORT" => "ASC"
    ];

    protected $defalutSelect = [
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "NAME",
        "DESCRIPTION",
        "UF_*",
        "SECTION_PAGE_URL"
    ];

    public function __construct()
    {
        $this->iblockId = $id;
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

    public static function iblock($id)
    {
        return new static($id);
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

    public function get($method = null)
    {
        $sections = [];

        if ( \CModule::IncludeModule("iblock"))
        {

            $select = (is_null($this->select)) ? $this->defalutSelect : $this->select;

            //fn_print_r($this->filter);

            $dbSectionList = \CIBlockSection::GetList($this->order, $this->filter, false, $select);

            while($arSection = $dbSectionList->GetNext())
    		{
                if ( is_callable($method) )
                {
                    call_user_func_array($method, [ &$arSection ]);
                }

                if ($count == 1) {
                    return $sections = $arSection;
                }

                $sections[] = $arSection;
    		}

            return $sections;
        }
        else
        {
            return false;
        }
    }

    public function first($method = null)
    {
        return $this->get(1, $method);
    }

}
