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

    public static function getServiceReviews(PDO $db, int $serviceId)
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
    
    /*
    public static function getTotalNumberOfReviews(PDO $db, int $serviceId): int {
        $stmt = $db->prepare('
            SELECT COUNT(*) as Count
            FROM Review
            WHERE ServiceId = ?
        ');

        $stmt->execute([$serviceId]);
        $result = $stmt->fetch();

        return $result ? intval($result['Count']) : 0;
    }

    public static function getNumberOfReviews(PDO $db, int $serviceId, int $stars): int {
        $stmt = $db->prepare('
            SELECT COUNT(*) as Count
            FROM Review
            WHERE ServiceId = ? AND Rating = ?
        ');

        $stmt->execute([$serviceId, $stars]);
        $result = $stmt->fetch();

        return $result ? intval($result['Count']) : 0;
    }
    */

    public static function getReviewCountsByRating(PDO $db, int $serviceId): array {
        $stmt = $db->prepare('
            SELECT Rating, COUNT(*) as Count
            FROM Review
            WHERE ServiceId = ?
            GROUP BY Rating
            ORDER BY Rating DESC
        ');

        $stmt->execute([$serviceId]);

        $counts = [];
        while ($row = $stmt->fetch()) {
            $counts[intval($row['Rating'])] = intval($row['Count']);
        }

        for ($i = 1; $i <= 5; $i++) {
            if (!isset($counts[$i])) {
                $counts[$i] = 0;
            }
        }

        return $counts;
    }
    
    public static function getRatingsData(PDO $db, int $serviceId): array {
        $ratingCounts = self::getReviewCountsByRating($db, $serviceId);
    
        $totalReviews = 0;
        $overallRating = 0;
        $percentages = [];
    
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingCounts[$i])) {
                $ratingCounts[$i] = 0;
            }
        }
    
        foreach ($ratingCounts as $stars => $count) {
            $totalReviews += $count;
            $overallRating += $stars * $count;
        }
    
        $overallRating = $totalReviews > 0 ? round($overallRating / $totalReviews, 1) : 0;
    
        for ($i = 1; $i <= 5; $i++) {
            $percentages[$i] = $totalReviews > 0 ? round(($ratingCounts[$i] / $totalReviews) * 100, 2) : 0;
        }
    
        return [
            'totalReviews' => $totalReviews,
            'overallRating' => $overallRating,
            'ratingCounts' => $ratingCounts,
            'percentages' => $percentages,
        ];
    }
}

?>
