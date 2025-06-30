<?php

namespace App\Helpers;

class DataGenerator
{
    private static $firstNames = [
        'John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'James', 'Emma',
        'Robert', 'Olivia', 'William', 'Ava', 'Richard', 'Isabella', 'Joseph', 'Sophia',
        'Thomas', 'Mia', 'Christopher', 'Charlotte', 'Charles', 'Amelia', 'Daniel', 'Harper',
        'Matthew', 'Evelyn', 'Anthony', 'Abigail', 'Mark', 'Emily', 'Donald', 'Elizabeth',
        'Steven', 'Sofia', 'Paul', 'Avery', 'Andrew', 'Ella', 'Joshua', 'Madison',
        'Kenneth', 'Scarlett', 'Kevin', 'Victoria', 'Brian', 'Aria', 'George', 'Grace',
        'Timothy', 'Chloe', 'Ronald', 'Camila', 'Jason', 'Penelope', 'Edward', 'Layla'
    ];

    private static $lastNames = [
        'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis',
        'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas',
        'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee', 'Perez', 'Thompson', 'White',
        'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson', 'Walker', 'Young',
        'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Nguyen', 'Hill', 'Flores',
        'Green', 'Adams', 'Nelson', 'Baker', 'Hall', 'Rivera', 'Campbell', 'Mitchell',
        'Carter', 'Roberts', 'Gomez', 'Phillips', 'Evans', 'Turner', 'Diaz', 'Parker',
        'Cruz', 'Edwards', 'Collins', 'Reyes', 'Stewart', 'Morris', 'Morales', 'Murphy'
    ];

    private static $bookTitles = [
        'The Great Adventure', 'Mystery of the Night', 'Journey to the Stars', 'Lost in Time',
        'The Hidden Truth', 'Beyond the Horizon', 'Echoes of Yesterday', 'Whispers in the Wind',
        'The Last Chapter', 'Shadows of the Past', 'Dreams of Tomorrow', 'The Silent Echo',
        'Breaking Dawn', 'Twilight Saga', 'Harry Potter', 'Lord of the Rings',
        'The Hobbit', 'Game of Thrones', 'The Hunger Games', 'Divergent',
        'The Fault in Our Stars', 'Looking for Alaska', 'Paper Towns', 'Turtles All the Way Down',
        'To Kill a Mockingbird', '1984', 'Animal Farm', 'Brave New World',
        'The Catcher in the Rye', 'The Great Gatsby', 'Pride and Prejudice', 'Jane Eyre',
        'Wuthering Heights', 'Frankenstein', 'Dracula', 'The Picture of Dorian Gray',
        'Alice in Wonderland', 'The Wizard of Oz', 'Peter Pan', 'The Little Prince',
        'The Alchemist', 'The Kite Runner', 'A Thousand Splendid Suns', 'The Book Thief',
        'Life of Pi', 'The Curious Incident', 'The Lovely Bones', 'The Time Traveler\'s Wife',
        'Water for Elephants', 'The Help', 'The Guernsey Literary', 'The Night Circus'
    ];

    private static $publishers = [
        'Penguin Random House', 'HarperCollins', 'Simon & Schuster', 'Macmillan',
        'Hachette Book Group', 'Scholastic', 'Bloomsbury', 'Faber & Faber',
        'Vintage Books', 'Knopf Doubleday', 'Crown Publishing', 'Ballantine Books',
        'Bantam Books', 'Del Rey', 'Anchor Books', 'Vintage Classics',
        'Modern Library', 'Everyman\'s Library', 'Oxford University Press', 'Cambridge University Press',
        'MIT Press', 'Harvard University Press', 'Yale University Press', 'Princeton University Press',
        'Stanford University Press', 'University of Chicago Press', 'Columbia University Press',
        'Johns Hopkins University Press', 'Cornell University Press', 'University of California Press'
    ];

    private static $genres = [
        'Fiction', 'Non-Fiction', 'Mystery', 'Thriller', 'Romance', 'Science Fiction',
        'Fantasy', 'Horror', 'Biography', 'Autobiography', 'History', 'Philosophy',
        'Psychology', 'Self-Help', 'Business', 'Economics', 'Politics', 'Religion',
        'Science', 'Technology', 'Art', 'Music', 'Travel', 'Cooking', 'Health',
        'Fitness', 'Education', 'Reference', 'Poetry', 'Drama', 'Comedy'
    ];

    public static function firstName(): string
    {
        return self::$firstNames[array_rand(self::$firstNames)];
    }

    public static function lastName(): string
    {
        return self::$lastNames[array_rand(self::$lastNames)];
    }

    public static function fullName(): string
    {
        return self::firstName() . ' ' . self::lastName();
    }

    public static function email(string $name = null): string
    {
        $name = $name ?? strtolower(self::firstName() . '.' . self::lastName());
        $domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'example.com'];
        return $name . '@' . $domains[array_rand($domains)];
    }

    public static function bookTitle(): string
    {
        return self::$bookTitles[array_rand(self::$bookTitles)];
    }

    public static function publisher(): string
    {
        return self::$publishers[array_rand(self::$publishers)];
    }

    public static function genre(): string
    {
        return self::$genres[array_rand(self::$genres)];
    }

    public static function randomDate(int $startYear = 1900, int $endYear = 2024): string
    {
        $year = rand($startYear, $endYear);
        $month = rand(1, 12);
        $day = rand(1, 28); // Using 28 to avoid month/day issues
        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }

    public static function randomYear(int $startYear = 1900, int $endYear = 2024): int
    {
        return rand($startYear, $endYear);
    }

    public static function randomNumber(int $min = 1, int $max = 100): int
    {
        return rand($min, $max);
    }

    public static function randomText(int $words = 10): string
    {
        $lorem = [
            'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',
            'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et',
            'dolore', 'magna', 'aliqua', 'ut', 'enim', 'ad', 'minim', 'veniam',
            'quis', 'nostrud', 'exercitation', 'ullamco', 'laboris', 'nisi', 'ut',
            'aliquip', 'ex', 'ea', 'commodo', 'consequat', 'duis', 'aute', 'irure',
            'dolor', 'in', 'reprehenderit', 'in', 'voluptate', 'velit', 'esse',
            'cillum', 'dolore', 'eu', 'fugiat', 'nulla', 'pariatur', 'excepteur',
            'sint', 'occaecat', 'cupidatat', 'non', 'proident', 'sunt', 'culpa',
            'qui', 'officia', 'deserunt', 'mollit', 'anim', 'id', 'est', 'laborum'
        ];

        $selectedWords = [];
        for ($i = 0; $i < $words; $i++) {
            $selectedWords[] = $lorem[array_rand($lorem)];
        }

        return ucfirst(implode(' ', $selectedWords)) . '.';
    }
} 