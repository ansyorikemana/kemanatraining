<?php
/**
 * Copyright © 2017 PT Kemana Teknologi Solusi. All rights reserved.
 * http://www.kemana.com
 */

/**
 * @category Training4
 * @package  Training4_Warranty
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 *
 * @author   Kemana Team
 *
 */
 
namespace Training4\Warranty\Model\Attribute\Backend;

class AttributeWarranty extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    public function beforeSave($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if (is_numeric($value)) {
            $value .= " year(s)";
            $object->setData($this->getAttribute()->getAttributeCode(), $value);
        }
        return parent::beforeSave($object);
    }
}
