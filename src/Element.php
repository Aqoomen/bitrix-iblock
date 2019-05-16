<?php
namespace iPremium\Bitrix\iBlock;

use iPremium\Bitrix\iBlock\QueryBilder;
use iPremium\Bitrix\iBlock\ElementItem as Item;

class Element
{

    use QueryBilder;
    /*
    use this param true if you want write in lovercase params
    and script auto transform it to BITRIX_CAPS_STYLE
     */
    protected $lovercase = false;


    protected $defalutSelect = [
        "ID",
        "NAME",
        "DETAIL_PICTURE",
        "DETAIL_PAGE_URL"
    ];



    public function get($count = 'all', $method = null)
    {
        $elements = [];

        $size = [ "nPageSize" => $count ];

        if ($count == 'all')
        {
            $size = false;
        }

        if ( \CModule::IncludeModule("iblock"))
        {
            $select = (is_null($this->select)) ? $this->defalutSelect : $this->select;

            //print_r($select);

        	$res = \CIBlockElement::GetList($this->order, $this->filter, false, $size, $select);

        	while($ob = $res->GetNextElement())
        	{
    			$element = $ob->GetFields();
    			$element["PROPERTIES"] = $ob->GetProperties();

                if ( is_callable($method) )
                {
                    call_user_func_array($method, [ &$element ]);
                }

                if ($this->returnArray) {
                    if ($count == 1) {
                        return $elements = $element;
                    }

                    $elements[] = $element;
                }
                else
                {
                    if ($count == 1) {
                        $elements = new Item($element);
                    } else {
                        $elements[] = new Item($element);
                    }


                }

        	}

            return $elements;
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

    public function all($method = null)
    {
        return $this->get('all', $method);
    }



}
