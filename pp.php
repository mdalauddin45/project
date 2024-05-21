<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "autism_test";

// Create connection to MySQL server
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$sql = "CREATE DATABASE IF NOT EXISTS autism_test";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($dbname);

// Create the table
$sql = "CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text VARCHAR(255) NOT NULL,
    score_0 INT NOT NULL,
    score_1 INT NOT NULL,
    score_2 INT NOT NULL,
    score_3 INT NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Insert sample questions if the table is empty
$sql = "SELECT COUNT(*) as count FROM questions";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sql = "INSERT INTO questions (question_text, score_0, score_1, score_2, score_3) VALUES
    ('I prefer to do things with others rather than on my own.', 0, 0, 1, 1),
    ('I prefer to do things the same way over and over again.', 1, 1, 0, 0),
    ('If I try to imagine something, I find it very easy to create a picture in my mind.', 0, 0, 1, 1),
    ('I frequently get so strongly absorbed in one thing that I lose sight of other things.', 1, 1, 0, 0),
    ('I often notice small sounds when others do not.', 1, 1, 0, 0),
    ('Other people frequently tell me that what I\'ve said is impolite, even though I think it is polite.', 1, 1, 0, 0),
    ('When I\'m reading a story, I can easily imagine what the characters might look like.', 0, 0, 1, 1),
    ('I am fascinated by dates.', 1, 1, 0, 0),
    ('In a social group, I can easily keep track of several different people\'s conversations.', 0, 0, 1, 1),
    ('I find social situations easy.', 0, 0, 1, 1)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Sample questions inserted successfully<br>";
    } else {
        echo "Error inserting questions: " . $conn->error;
    }
}

// Fetch questions from the database
$sql = "SELECT id, question_text FROM questions LIMIT 10";
$result = $conn->query($sql);
$questions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autism Spectrum Quotient Test</title>
    <style>
        .notable-table {
            width: 100%;
            border-collapse: collapse;
        }
        .notable-th, .notable-td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .notable-th.heading {
            text-align: center;
        }
        .notable-tr {
            text-align: left;
        }
        .submit-button {
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <form action="process_form.php" method="post">
        <div class="notable-table vertical">
            <div class="notable-thead">
                <div class="notable-tr">
                    <span class="notable-td blank">&nbsp;</span>
                    <span class="notable-th heading" scope="col">Definitely Agree</span>
                    <span class="notable-th heading" scope="col">Slightly Agree</span>
                    <span class="notable-th heading" scope="col">Slightly Disagree</span>
                    <span class="notable-th heading" scope="col">Definitely Disagree</span>
                </div>
            </div>
            <div class="notable-tbody">
                <?php if (!empty($questions)): ?>
                    <?php foreach ($questions as $question): ?>
                        <div id="question-<?php echo $question['id']; ?>" class="notable-tr question <?php echo $question['id'] % 2 == 0 ? 'even' : 'odd'; ?>">
                            <span class="notable-td prompt"><span class="num"><?php echo $question['id']; ?>. </span><span><?php echo $question['question_text']; ?></span></span>
                            <span class="notable-td response"><label class="aria-label" for="q<?php echo $question['id']; ?>_0">Definitely Agree</label><input type="radio" value="0" name="q<?php echo $question['id']; ?>" id="q<?php echo $question['id']; ?>_0" required></span>
                            <span class="notable-td response"><label class="aria-label" for="q<?php echo $question['id']; ?>_1">Slightly Agree</label><input type="radio" value="1" name="q<?php echo $question['id']; ?>" id="q<?php echo $question['id']; ?>_1" required></span>
                            <span class="notable-td response"><label class="aria-label" for="q<?php echo $question['id']; ?>_2">Slightly Disagree</label><input type="radio" value="2" name="q<?php echo $question['id']; ?>" id="q<?php echo $question['id']; ?>_2" required></span>
                            <span class="notable-td response"><label class="aria-label" for="q<?php echo $question['id']; ?>_3">Definitely Disagree</label><input type="radio" value="3" name="q<?php echo $question['id']; ?>" id="q<?php echo $question['id']; ?>_3" required></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No questions found.</p>
                <?php endif; ?>
            </div>
            <div class="notable-tfoot">
                <div class="notable-tr">
                    <span class="notable-td submit">
                        <div class="submit">
                            <input type="submit" value="Score my Answers" class="submit-button">
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </form>
</body>

</html>
