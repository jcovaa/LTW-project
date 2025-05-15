<?php



class Order {
    public int $orderId;
    public int $clientId;
    public int $serviceId;
    public string $status;
    public string $orderDate;

    public function __construct(int $orderId, int $clientId, int $serviceId, string $status, string $orderDate) {
        $this->orderId = $orderId;
        $this->clientId = $clientId;
        $this->serviceId = $serviceId;
        $this->status = $status;
        $this->orderDate = $orderDate;
    }

    public static function getOrdersByClient(PDO $db, int $clientId): array {
        $stmt = $db->prepare('
            SELECT * FROM "Order_"
            WHERE ClientId = ?
            ORDER BY OrderDate DESC
        ');
        $stmt->execute([$clientId]);

        $orders = [];
        while ($order = $stmt->fetch()) {
            $orders[] = new Order(
                $order['OrderId'],
                $order['ClientId'],
                $order['ServiceId'],
                $order['Status'],
                $order['OrderDate']
            );
        }

        return $orders;
    }


    public static function getOrdersByService(PDO $db, int $serviceId): array {
        $stmt = $db->prepare('
            SELECT * FROM "Order_"
            WHERE ServiceId = ?
            ORDER BY OrderDate DESC
        ');
        $stmt->execute([$serviceId]);

        $orders = [];
        while ($order = $stmt->fetch()) {
            $orders[] = new Order(
                $order['OrderId'],
                $order['ClientId'],
                $order['ServiceId'],
                $order['Status'],
                $order['OrderDate']
            );
        }

        return $orders;
    }
}