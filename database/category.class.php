<?php
#declare(strict_types=1);

class Category {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getCategories(PDO $db): array {
        $categories = [];

        $stmt = $db->prepare('
            SELECT 
                Category.CategoryId,
                Category.Name
            FROM Category
        ');

        $stmt->execute();
        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category(
                $category['CategoryId'], 
                $category['Name']
            );
        }
        
        return $categories;
    }

    public static function getCategory(PDO $db, int $id) {
        $stmt = $db->prepare('
            SELECT Category.CategoryId, Category.Name
            FROM Category
            WERE CategoryId = ?
        ');

        $stmt->execute([$id]);

        $category = $stmt->fetch();

        return new Category(
            $category['CategoryId'],
            $category['Name']);
    }

   public static function getServiceCategories(PDO $db, int $serviceId)
   {
      $stmt = $db->prepare('
      SELECT Category.CategoryId, Category.Name 
      FROM Category
      JOIN ServiceCategory ON Category.CategoryId = ServiceCategory.CategoryId
      WHERE ServiceCategory.ServiceId = ?
      ');

      $stmt->execute([$serviceId]);

      $categories = [];
      while ($row = $stmt->fetch()) {
         $categories[] = new Category(
            $row['CategoryId'],
            $row['Name']
         );
      }

      return $categories;
   }
}

?>