<?php



class Order
{
    public int $orderId;
    public int $clientId;
    public int $freelancerId;
    public int $serviceId;
    public string $status;
    public string $orderDate;
    public string $serviceName;
    public string $clientName;
    public string $freelancerName;

    public function __construct(int $orderId, int $clientId, int $serviceId, string $status, string $orderDate, string $clientName, string $serviceName, string $freelancerName, int $freelancerId)
    {
        $this->orderId = $orderId;
        $this->clientId = $clientId;
        $this->serviceId = $serviceId;
        $this->status = $status;
        $this->orderDate = $orderDate;
        $this->clientName = $clientName;
        $this->serviceName = $serviceName;
        $this->freelancerName = $freelancerName;
        $this->freelancerId = $freelancerId;
    }

    public static function getOrder(PDO $db, int $id)
    {
        $stmt = $db->prepare('
            SELECT O.*, 
                C.Name AS clientName, 
                S.Name AS serviceName, 
                F.Name AS freelancerName
                S.FreelancerId AS freelancerId
            FROM "Order_" O
            JOIN User C ON O.ClientId = C.UserId
            JOIN Service S ON O.ServiceId = S.ServiceId
            JOIN User F ON S.FreelancerID = F.UserId
            WHERE O.OrderId = ?
        ');


        $stmt->execute([$id]);

        $order = $stmt->fetch();

        return new Order(
            $order['OrderId'],
            $order['ClientId'],
            $order['ServiceId'],
            $order['Status'],
            $order['OrderDate'],
            $order['clientName'],
            $order['serviceName'],
            $order['freelancerName'],
            $order['freelancerId']
        );
    }

    public static function getOrdersByClient(PDO $db, int $clientId): array
    {
        $stmt = $db->prepare('
            SELECT O.*, 
                C.Name AS clientName, 
                S.Name AS serviceName, 
                F.Name AS freelancerName,
                S.FreelancerId AS freelancerId
            FROM "Order_" O
            JOIN User C ON O.ClientId = C.UserId
            JOIN Service S ON O.ServiceId = S.ServiceId
            JOIN User F ON S.FreelancerID = F.UserId
            WHERE O.ClientId = ?
            ORDER BY O.OrderDate DESC
    ');
        $stmt->execute([$clientId]);

        $orders = [];
        while ($order = $stmt->fetch()) {
            $orders[] = new Order(
                $order['OrderId'],
                $order['ClientId'],
                $order['ServiceId'],
                $order['Status'],
                $order['OrderDate'],
                $order['clientName'],
                $order['serviceName'],
                $order['freelancerName'],
                $order['freelancerId']
            );
        }

        return $orders;
    }

    public static function getOrdersByService(PDO $db, int $serviceId): array
    {
        $stmt = $db->prepare('
        SELECT O.*, 
            C.Name AS clientName, 
            S.Name AS serviceName, 
            F.Name AS freelancerName,
            S.FreelancerId AS freelancerId
        FROM "Order_" O
        JOIN User C ON O.ClientId = C.UserId
        JOIN Service S ON O.ServiceId = S.ServiceId
        JOIN User F ON S.FreelancerID = F.UserId
        WHERE O.ServiceId = ?
        ORDER BY O.OrderDate DESC
');
        $stmt->execute([$serviceId]);

        $orders = [];
        while ($order = $stmt->fetch()) {
            $orders[] = new Order(
                $order['OrderId'],
                $order['ClientId'],
                $order['ServiceId'],
                $order['Status'],
                $order['OrderDate'],
                $order['clientName'],
                $order['serviceName'],
                $order['freelancerName'],
                $order['freelancerId']
            );
        }

        return $orders;
    }

    public function updateStatus(PDO $db, string $newStatus): bool
    {
        $stmt = $db->prepare('UPDATE "Order_" SET Status = ? WHERE OrderId = ?');
        $success = $stmt->execute([$newStatus, $this->orderId]);

        if ($success) {
            $this->status = $newStatus; // Update the object’s status as well
        }

        return $success;
    }
}
