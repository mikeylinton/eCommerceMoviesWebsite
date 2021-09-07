<?php
session_start();
$pTitle = "Survey";
require('required/connect_db.php');

if (!isset($_SESSION['cID'])) {
    header("Location: signIn.php");
}

include('required/navBar.php');
?>
    <form action="" method="post">
        <br>
        <label for="age">Age</label>
        <select name="age" id="age">
            <option value="18-24">18 to 24</option>
            <option value="25-34">25 to 34</option>
            <option value="35-44">35 to 44</option>
            <option value="45-54">45 to 54</option>
            <option value="55-64">55 to 64</option>
            <option value="65<">Over 65</option>
            <option value="NULL">Prefer not to say</option>
        </select>
        <br>
        <label for="income">Income</label>
        <select name="income" id="income">
            <option value="15000>">Less than USD15,000</option>
            <option value="15000-34999">USD15,000 to 34,999</option>
            <option value="35000-49999">USD35,000 to 49,999</option>
            <option value="50000-74999">USD50,000 to 74,999</option>
            <option value="74999-99999">USD74,999 to 99,999</option>
            <option value="100000<">More than USD100,000</option>
            <option value="NULL">Prefer not to say</option>
        </select>
        <br>
        <label for="gender">Gender</label>
        <select name="gender" id="gender">
            <option value="Feamle">Female</option>
            <option value="Male">Male</option>
            <option value="Non-binary">Non-binary</option>
            <option value="Other">Other</option>
            <option value="NULL">Prefer not to say</option>
        </select>
        <br>
        <label for="employment">Employment Status</label>
        <select name="employment" id="employment">
            <option value="Full">Full-time</option>
            <option value="Part">Part-time</option>
            <option value="Self">Self-employed</option>
            <option value="Student">Student</option>
            <option value="N1">Unemployed</option>
            <option value="NULL">Prefer not to say</option>
        </select>
        <br>
        <label for="relationship">Relationship Status</label>
        <select name="relationship" id="relationship">
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Partnered">Partnered</option>
            <option value="Seperated">Seperated</option>
            <option value="NULL">Prefer not to say</option>
        </select>
        <br>
        <label for="genre">Favorite Genre</label>
        <select name="genre" id="genre">
            <option value="Action">Action</option>
            <option value="Adventure">Adventure</option>
            <option value="Animation">Animation</option>
            <option value="Biography">Biography</option>
            <option value="Crime">Crime</option>
            <option value="Comedy">Comedy</option>
            <option value="Documentary">Documentary</option>
            <option value="Drama">Drama</option>
            <option value="Family">Family</option>
            <option value="Fantasy">Fantasy</option>
            <option value="Film-Noir">Film-Noir</option>
            <option value="Horror">Horror</option>
            <option value="History">History</option>
            <option value="Mystery">Mystery</option>
            <option value="Music">Music</option>
            <option value="Musical">Musical</option>
            <option value="News">News</option>
            <option value="Romance">Romance</option>
            <option value="Sci-Fi">Sci-Fi</option>
            <option value="Short">Short</option>
            <option value="Sport">Sport</option>
            <option value="Thriller">Thriller</option>
            <option value="War">War</option>
            <option value="Western">Western</option>
        </select>
        <br>
        <br>
        <h4>Rate the following on a scale of 1=worst to 10=best.</h4>
        <label for="selection">Movie Selection</label>
        <select name="selection" id="selection">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <br>
        <label for="pricing">Movie Pricing</label>
        <select name="pricing" id="pricing">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <br>
        <label for="suggestions">Movie Suggestions</label>
        <select name="suggestions" id="suggestions">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <br>
        <label for="usability">Website Usability</label>
        <select name="usability" id="usability">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <br>
        <label for="recommed">recommed to Friend</label>
        <select name="recommed" id="recommed">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <br>
        <br>
        <input type="submit" value="Submit" name="submit">
    </form>
<?php
if (isset($_POST['submit'])) {
	header("Location: survey_action.php");
    $age = $_POST['age'];
    $income = $_POST['income'];
    $gender = $_POST['gender'];
    $employment = $_POST['employment'];
    $resultelationship = $_POST['relationship'];
    $genre = $_POST['genre'];
    $selection = $_POST['selection'];
    $pricing = $_POST['pricing'];
    $suggestions = $_POST['suggestions'];
    $usability = $_POST['usability'];
    $recommend = $_POST['recommed'];
    $churn = (100 - (($selection + $pricing + $suggestions + $usability + $recommend) * 2)) / 100;

    if ($churn < 0.4) {
        $churn = 0;
    } else {
        $churn = 1;
    }

    $customer = $_SESSION['cID'];
    $sql = "SELECT cID FROM Surveys WHERE cID='$customer'";
    $result = @mysqli_query($db, $sql);

    if (mysqli_num_rows($result) != 0) $surveyExists = true;

    if (!$surveyExists) {
        $sql = "INSERT INTO Surveys (cID,sChurn,sAge,sIncome,sGender,sEmployment,sRelationship,sGenre,sSelection,sPricing,sSuggestions,sUsability,sRecommend) VALUES ('$customer','$churn','$age','$income','$gender','$employment','$resultelationship','$genre','$selection','$pricing','$suggestions','$usability','$recommend')";
        $result = @mysqli_query($db, $sql);
        if ($result) {
			echo('
			<h4>Submitted!</h4>
			<p>Your answers have been recorded,thank you for your time.</p>
			');
        }
        mysqli_close($db);
    } else {
        echo('<p>Survey already submitted.</p>');
    }
}
mysqli_close($db);
include('required/footer.html');
?>