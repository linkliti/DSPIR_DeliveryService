USE `DeliveryService`;
CALL getOrderStatus(1);

SELECT DeliveryStatus
FROM Orders;

SELECT id_Order, DeliveryStatus, friendly_DeliveryStatus(DeliveryStatus)
FROM Orders;