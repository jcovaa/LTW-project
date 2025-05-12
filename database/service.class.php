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
   public float $avgRating;
   public $categoryIds = array();
   public string $imageUrl;

   public function __construct(int $id, string $name, string $description, float $price, int $deliveryTime, bool $isPromoted, int $freelancerId, string $freelancerName, float $avgRating, string $imageUrl, $categoryIds)
   {
      $this->id = $id;
      $this->name = $name;
      $this->description = $description;
      $this->price = $price;
      $this->deliveryTime = $deliveryTime;
      $this->isPromoted = $isPromoted;
      $this->freelancerId = $freelancerId;
      $this->freelancerName = $freelancerName;
      $this->avgRating = $avgRating;
      $this->categoryIds = $categoryIds;
      $this->imageUrl = $imageUrl;
   }



   public static function addService(PDO $db, $name, $clientId, $price, $deliveryTime, $description, $imageUrl) {
      $stmt = $db->prepare('
         INSERT INTO Service(Name, FreelancerId, Price, DeliveryTime, Description, IsPromoted, ImageUrl)
         Values (?,?,?,?,?,0,?)
      ');
      return $stmt->execute([$name, $clientId, $price, $deliveryTime, $description, $imageUrl]);
   }


   public static function getService(PDO $db, int $id)
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
         Service.ImageURL,
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
         self::getAverageRatingForService($db, $id),
         (string)($service['ImageURL']),
         self::getServiceCategories($db, $id)
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
            Service.ImageURL,
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
            Service.ImageURL,
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
            Service.ImageURL,
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
            Service.ImageURL,
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
            Service.DeliveryTime, Service.IsPromoted, Service.ImageURL,
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
         $id = $row['ServiceId'];
         $services[] = new Service(
         $id,
         $row['Name'],
         $row['Description'],
         floatval($row['Price']),
         intval($row['DeliveryTime']),
         boolval($row['IsPromoted']),
         $row['FreelancerId'],
         $row['FreelancerName'],
         self::getAverageRatingForService($db, $id),
         (string)($row['ImageURL']),
         self::getServiceCategories($db, $id)
      );
      }
    
      return $services;
   }

   public static function getServiceCategories(PDO $db, int $serviceId)
   {
      $stmt = $db->prepare('
      SELECT Category.CategoryId
      FROM Category
      JOIN ServiceCategory ON Category.CategoryId = ServiceCategory.CategoryId
      WHERE ServiceCategory.ServiceId = ?
      ');

      $stmt->execute([$serviceId]);

      $categories = [];
      while ($row = $stmt->fetch()) {
         $categories[] = $row['CategoryId'];
      }

      return $categories;
   }


   private static function getAverageRatingForService(PDO $db, int $id) {
      $stmt = $db->prepare('
         SELECT AVG(Rating) as AvgRating
         FROM Review
         WHERE ServiceId = ?
      ');
      $stmt->execute([$id]);
      $result = $stmt->fetch();

      return $result && $result['AvgRating'] !== null ? round(floatval($result['AvgRating']), 1) : 0.0;   // result may be false or there may not exist any review
   }

   public static function searchServices(PDO $db, string $query): array {
      $stmt = $db->prepare('
         SELECT * 
         FROM Service 
         WHERE name LIKE ?
      ');

      $stmt->execute(['%' . $query . '%']);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   public static function filterServicesByRating(PDO $db, int $minRating, int $maxRating): array {
      $stmt = $db->prepare('
         SELECT
            Service.ServiceId,
            Service.Name,
            Service.Description,
            Service.Price,
            Service.DeliveryTime,
            Service.IsPromoted,
            Service.ImageURL,
            User.UserId as FreelancerId,
            User.Name as FreelancerName,
            AVG(Review.Rating) as AvgRating
         FROM Service
         JOIN User ON Service.FreelancerID = User.UserId
         LEFT JOIN Review ON Service.ServiceId = Review.ServiceId
         GROUP BY Service.ServiceId
         HAVING AvgRating BETWEEN ? AND ?
      ');

      $stmt->execute([$minRating, $maxRating]);

      return self::buildServicesArray($db, $stmt);
   }

   public static function filterServicesByPrice(PDO $db, float $minPrice, float $maxPrice): array {
      $stmt = $db->prepare('
         SELECT
            Service.ServiceId,
            Service.Name,
            Service.Description,
            Service.Price,
            Service.DeliveryTime,
            Service.IsPromoted,
            Service.ImageURL,
            User.UserId as FreelancerId,
            User.Name as FreelancerName,
         FROM Service
         JOIN User ON Service.FreelancerID = User.UserId
         WHERE Service.Price BETWEEN ? AND ?
      ');

      $stmt->execute([$minPrice, $maxPrice]);

      return self::buildServicesArray($db, $stmt);
   }

   public static function filterServices(PDO $db, array $filters): array {
      $query = '
         SELECT
            Service.ServiceId,
            Service.Name,
            Service.Description,
            Service.Price,
            Service.DeliveryTime,
            Service.IsPromoted,
            Service.ImageURL,
            User.UserId as FreelancerId,
            User.Name as FreelancerName
         FROM Service
         JOIN User ON Service.FreelancerID = User.UserId
         LEFT JOIN Review ON Service.ServiceId = Review.ServiceId
      ';

      $conditions = [];
      $params = [];

      if (!empty($filters['query'])) {
         $conditions[] = 'Service.Name LIKE ?';
         $params[] = '%' . $filters['query'] . '%';
      }

      if (!empty($filters['rating_range'])) {
         [$minRating, $maxRating] = explode('-', $filters['rating_range']);
         $conditions[] = 'AVG(Review.Rating) BETWEEN ? AND ?';
         $params[] = (float)$minRating;
         $params[] = (float)$maxRating;
      }

      if (!empty($filters['price_range'])) {
         if ($filters['price_range'] === '>500') {
            $conditions[] = 'Service.Price > ?';
            $params[] = 500;
         }
         else {
            [$minPrice, $maxPrice] = explode('-', $filters['price_range']);
            $conditions[] = 'Service.Price BETWEEN ? AND ?';
            $params[] = (float)$minPrice;
            $params[] = (float)$maxPrice;
         }
      }

      if (!empty($conditions)) {
         $query .= 'WHERE ' . implode(' AND ', $conditions);
      }

      $query .= ' GROUP BY Service.ServiceId';

      $stmt = $db->prepare($query);
      $stmt->execute($params);

      return self::buildServicesArray($db, $stmt);
   }
}

?>
