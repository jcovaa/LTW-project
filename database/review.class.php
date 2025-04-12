<?php

class Review
{
    public int $id;
    public int $serviceId;
    public int $clientId;
    public int $rating;
    public string $comment;


    public function __construct(int $id, int $serviceId, int $clientId, int $rating, string $comment)
    {
        $this->id = $id;
        $this->serviceId = $serviceId;
        $this->clientId = $clientId;
        $this->rating = $rating;
        $this->comment = $comment;
    }

    public static function getReview(PDO $db, int $id)
    {
        $stmt = $db->prepare('
            SELECT ReviewId, ServiceId, ClientId, Rating, Comment
            FROM Review
            WHERE ReviewId = ?
        ');

        $stmt->execute([$id]);

        $review = $stmt->fetch();

        return new Review(
            $review['ReviewId'],
            $review['ServiceId'],
            $review['ClientId'],
            intval($review['Rating']),
            $review['Comment']
        );
    }

    private static function getServiceReviews(PDO $db, int $serviceId)
    {
        $stmt = $db->prepare('
         SELECT ReviewId, ServiceId, ClientId, Rating, Comment 
         FROM Review
         WHERE ServiceId = ?
      ');

        $stmt->execute([$serviceId]);

        $reviews = [];
        while ($row = $stmt->fetch()) {
            $reviews[] = new Review(
                $row['ReviewId'],
                $row['ServiceId'],
                $row['ClientId'],
                intval($row['Rating']),
                $row['Comment']
            );
        }

        return $reviews;
    }
    

    private static function getAverageRatingForService(PDO $db, int $serviceId)
    {
        $stmt = $db->prepare('
            SELECT AVG(Rating) as AvgRating
            FROM Review
            WHERE ServiceId = ?
        ');
        $stmt->execute([$serviceId]);
        $result = $stmt->fetch();

        return $result && $result['AvgRating'] !== null ? round(floatval($result['AvgRating']), 1) : 0.0;   // result may be false or there may not exist any review
    }
}

?>
