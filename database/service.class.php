<?php

declare(strict_types=1);

class Service
{
   public int $id;
   public string $name;
   public string $description;
   public float $price;
   public int $deliveryTime;
   public bool $isPromoted;
   public int $freelancerId;
   public string $freelancerName;

   public function __construct(int $id, string $name, string $description, float $price, int $deliveryTime, bool $isPromoted, int $freelancerId, string $freelancerName)
   {
      $this->id = $id;
      $this->name = $name;
      $this->description = $description;
      $this->price = $price;
      $this->deliveryTime = $deliveryTime;
      $this->isPromoted = $isPromoted;
      $this->freelancerId = $freelancerId;
      $this->freelancerName = $freelancerName;
   }



   function getService(PDO $db, int $id)
   {
      // The User and Service table has some equal column names
      $stmt = $db->prepare('
      SELECT 
         Service.ServiceId, 
         Service.Name, 
         Service.Description, 
         Service.Price, 
         Service.DeliveryTime, 
         Service.IsPromoted,
         User.UserId as FreelancerId,
         User.Name as FreelancerName
      FROM Service
      JOIN User ON Service.FreelancerID = User.UserId
      WHERE Service.ServiceId = ?
      ');

      $stmt->execute([$id]);
      $service = $stmt->fetch();

      return new Service(
         $service['ServiceId'],
         $service['Name'],
         $service['Description'],
         floatval($service['Price']),
         intval($service['DeliveryTime']),
         boolval($service['IsPromoted']),
         $service['FreelancerId'],
         $service['FreelancerName'],
      );
   }

   public static function getAllServices(PDO $db): array {
      $stmt = $db->prepare('
         SELECT 
            Service.ServiceId,
            Service.Name,
            Service.Description,
            Service.Price,
            Service.DeliveryTime,
            Service.IsPromoted,
            User.UserId as FreelancerId,
            User.Name as FreelancerName
         FROM Service
         JOIN User ON Service.FreelancerID = User.UserId
      ');

      $stmt->execute();

      return self::buildServicesArray($db, $stmt);
   }

   public static function getNServices(PDO $db, int $count): array {
      $stmt = $db->prepare('
         SELECT 
            Service.ServiceId,
            Service.Name,
            Service.Description,
            Service.Price,
            Service.DeliveryTime,
            Service.IsPromoted,
            User.UserId as FreelancerId,
            User.Name as FreelancerName
         FROM Service
         JOIN User ON Service.FreelancerID = User.UserId
         LIMIT ?
      ');

      $stmt->execute([$count]);

      return self::buildServicesArray($db, $stmt);
   }

   function getFreelancerServices(PDO $db, int $freelancerId)
   {
      // The User and Service table has some equal column names
      $stmt = $db->prepare('
         SELECT 
            Service.ServiceId, 
            Service.Name, 
            Service.Description, 
            Service.Price, 
            Service.DeliveryTime, 
            Service.IsPromoted,
            User.UserId as FreelancerId,
            User.Name as FreelancerName
         FROM Service
         JOIN User ON Service.FreelancerID = User.UserId
         WHERE User.UserID = ?
      ');

      $stmt->execute([$freelancerId]);

      return self::buildServicesArray($db, $stmt);
   }

public static function getPromotedServices(PDO $db): array {
    $stmt = $db->prepare('
        SELECT 
          Service.ServiceId, 
          Service.Name, 
          Service.Description, 
          Service.Price, 
          Service.DeliveryTime, 
          Service.IsPromoted,
          User.UserId as FreelancerId, 
          User.Name as FreelancerName
        FROM Service
        JOIN User ON Service.FreelancerID = User.UserId
        WHERE Service.IsPromoted = ?
        LIMIT 4
    ');
    
    $stmt->execute([1]);

    return self::buildServicesArray($db, $stmt);
}


   public static function getServiceByCategoryId(PDO $db, int $categoryId): array {
      $stmt = $db->prepare('
        SELECT 
          Service.ServiceId, Service.Name, Service.Description, Service.Price, 
          Service.DeliveryTime, Service.IsPromoted,
          User.UserId as FreelancerId, User.Name as FreelancerName
        FROM Service
        JOIN ServiceCategory ON Service.ServiceId = ServiceCategory.ServiceId
        JOIN User ON Service.FreelancerID = User.UserId
        WHERE ServiceCategory.CategoryId = ?
      ');
      $stmt->execute([$categoryId]);
    
      return self::buildServicesArray($db, $stmt);
    }



   private static function buildServicesArray(PDO $db, PDOStatement $stmt): array {
      $services = [];
    
      while ($row = $stmt->fetch()) {
        $services[] = new Service(
          $row['ServiceId'],
          $row['Name'],
          $row['Description'],
          floatval($row['Price']),
          intval($row['DeliveryTime']),
          boolval($row['IsPromoted']),
          $row['FreelancerId'],
          $row['FreelancerName'],
        );
      }
    
      return $services;
    }
}

?>
