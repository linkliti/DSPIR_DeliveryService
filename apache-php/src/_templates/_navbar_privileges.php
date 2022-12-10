<?php
$links = array();
function addLinksForNavbar($privilege, $page_url, $page_title, &$links) {
    if (checkPrivilege($privilege)) {
        $links[$page_url] = $page_title;
    }
}
// Track for not authorised
if (!checkPrivilege('is_auth')) {
    $links['/home/track.php'] = "Отслеживание";
}
// RSCHIR
$links['/pdf/showPDF.php'] = "PDF";
$links['/graph/graphs.php'] = "Графики";
// Debug
addLinksForNavbar(array('admin'), "/home/session_test.php", "Дебаг", $links);
addLinksForNavbar(array('admin'), "/home/test.php", "PHPINFO", $links);
//
addLinksForNavbar(array('manager'), "/table/workers.php", "Персонал", $links);
addLinksForNavbar(array('manager', 'driver'), "/table/orders.php", "Заказы", $links);
addLinksForNavbar(array('manager', 'assembler'), "/table/positions.php", "Склад", $links);
addLinksForNavbar(array('manager', 'driver'), "/table/pvzs.php", "Пункты выдачи", $links);
addLinksForNavbar(array('driver'), "/table/vehicles.php", "Автомобили", $links);
addLinksForNavbar(array('manager'), "/table/clients.php", "Клиенты", $links);
?>