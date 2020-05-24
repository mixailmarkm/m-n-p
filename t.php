<?php
function onBeforeAdd(\Bitrix\Main\Entity\Event $event)
    {
        $fields = $event->getParameter("fields");
        if($fields['EVENT_NAME']!='SALE_ORDER_DELIVERY') return;
        $cFields = $fields['C_FIELDS'];

        $cFields['PICKUP_INFO'] = '';
        $cFields['PICKUP_INFO'] = $store['UF_REGULATIONS'];
        
        $result = new \Bitrix\Main\Entity\EventResult();
        $changedFields = array('C_FIELDS' => $cFields,);
        $result->modifyFields($changedFields);
        return $result;
    } 
