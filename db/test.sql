USE `DeliveryService`;
CALL checkIDinTable(1, "Orders", "Order");
SHOW Variables;
EXECUTE prepared_checkID;